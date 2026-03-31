<?php
/**
 * export_sp.php
 * Generate Surat Pernyataan Siswa dengan data pelanggaran + AI Summary
 */

require 'vendor/autoload.php';
include 'database.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Tab;

// ── KONFIGURASI OPENAI ─────────────────────────────────────────────────────
// Simpan API key di environment variable atau file config terpisah
$openaiApiKey = getenv('OPENAI_API_KEY') ?: '';

/**
 * Fungsi untuk generate rangkuman pelanggaran menggunakan OpenAI
 * 
 * @param array $pelanggarans Array data pelanggaran siswa
 * @param string $namaSiswa Nama siswa
 * @param string $apiKey OpenAI API Key
 * @return string Rangkuman dari AI
 */
function generateRangkumanAI(array $pelanggarans, string $namaSiswa, string $apiKey): string {

  
    if (empty($pelanggarans)) {
        return "Siswa belum memiliki catatan pelanggaran.";
    }
    
    $dataPelanggaran = [];
    foreach ($pelanggarans as $index => $p) {
        $jenis = $p['jenis_nama'] ?? 'Tidak diketahui';
        $alasan = $p['alasan_detail'] ?? 'Tidak ada keterangan';
        $dataPelanggaran[] = "- {$jenis} - {$alasan}";
    }
    
    $pelanggaranText = implode("\n", $dataPelanggaran);
    $totalPelanggaran = count($pelanggarans);
    
    //prompt untuk OpenAI
    $prompt = <<<PROMPT
Buatlah bagian "Rangkuman Riwayat Pelanggaran" untuk SURAT PERNYATAAN SISWA dari BK sekolah. Formatnya formal, ringkas, dan mudah dipahami orang tua. 

Data pelanggaran siswa {$namaSiswa}:
{$pelanggaranText}

Total pelanggaran: {$totalPelanggaran} kali.

Rangkum dalam paragraf pendek pengantar (1-2 kalimat) yang menjelaskan total pelanggaran dan dampaknya terhadap prestasi belajar. Akhiri dengan kalimat nasihat BK yang tegas tapi suportif. Gunakan bahasa Indonesia formal, seperti surat resmi BK. Output hanya bagian rangkuman ini saja, tanpa tambahan lain. dalam bentuk teks tanpa ada angka dalam bentuk full paragraf secara ringkas dan harus singkat.
PROMPT;

    try {
        // Inisialisasi client OpenAI dengan factory method
        $client = \OpenAI::client($apiKey);
        
        // Panggil API ChatGPT
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo', // atau 'gpt-4' jika tersedia
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Anda adalah konselor BK sekolah yang profesional dan berpengalaman dalam menangani pelanggaran siswa.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'temperature' => 0.7,
            'max_tokens' => 300,
        ]);
        
        // Ambil hasil dari response
        $rangkuman = $response->choices[0]->message->content ?? '';
        
        // Bersihkan output
        $rangkuman = trim($rangkuman);
        
        // Jika response kosong, gunakan fallback
        if (empty($rangkuman)) {
            return generateRangkumanManual($pelanggarans, $namaSiswa);
        }
        
        return $rangkuman;
        
    } catch (\Exception $e) {
        // Jika terjadi error, return rangkuman manual sebagai fallback
        error_log('OpenAI Error: ' . $e->getMessage());
        return generateRangkumanManual($pelanggarans, $namaSiswa);
    }
}

/**
 * Fungsi fallback jika OpenAI gagal
 */
function generateRangkumanManual(array $pelanggarans, string $namaSiswa): string {
    if (empty($pelanggarans)) {
        return "Siswa belum memiliki catatan pelanggaran.";
    }
    
    $total = count($pelanggarans);
    $jenisList = [];
    
    foreach ($pelanggarans as $p) {
        $jenis = $p['jenis_nama'] ?? 'Tidak diketahui';
        if (!in_array($jenis, $jenisList)) {
            $jenisList[] = $jenis;
        }
    }
    
    $jenisText = implode(', ', $jenisList);
    
    return "Siswa {$namaSiswa} telah melakukan {$total} kali pelanggaran yang meliputi {$jenisText}. "
         . "Pelanggaran-pelanggaran ini dapat mengganggu proses belajar mengajar dan mempengaruhi prestasi akademik siswa. "
         . "Diharapkan dengan adanya surat pernyataan ini, siswa dapat lebih disiplin dan bersemangat dalam menjalankan kewajibannya sebagai pelajar.";
}

// ── Parameter ──────────────────────────────────────────────────────────────
$id = (int)($_GET['id'] ?? 0);
if ($id === 0) {
    http_response_code(400);
    die('ID siswa tidak valid.');
}

// ── Query data siswa ─────────────────────────────────────────────────────────
$stmt = $pdo->prepare("
    SELECT 
        s.id, s.name, s.nis, s.id_kelas, s.id_user,
        s.name_orang_tua, s.pekerjaan_orang_tua, s.alamat_orang_tua,
        s.alamat, s.telphone_orang_tua, s.telphone,
        s.detail, s.point, s.sp,
        k.tingkat, k.jurusan, k.kelas
    FROM siswas s
    LEFT JOIN kelas k ON s.id_kelas = k.id
    WHERE s.id = ?
");
$stmt->execute([$id]);
$siswa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$siswa) {
    http_response_code(404);
    die('Data siswa tidak diitemukan.');
}

// ── Query data pelanggaran siswa ─────────────────────────────────────────────
$stmtPelanggaran = $pdo->prepare("
    SELECT 
        p.id,
        p.date,
        p.detail as pelanggaran_detail,
        j.name as jenis_nama,
        j.point as jenis_point,
        a.detail as alasan_detail
    FROM pelanggarans p
    LEFT JOIN jenis_pelanggarans j ON p.id_jenis_pelanggaran = j.id
    LEFT JOIN alasan_pelanggarans a ON p.id_alasan_pelanggaran = a.id
    WHERE p.id_siswa = ?
    ORDER BY p.date DESC
");
$stmtPelanggaran->execute([$id]);
$pelanggarans = $stmtPelanggaran->fetchAll(PDO::FETCH_ASSOC);

// ── Generate Rangkuman AI ────────────────────────────────────────────────────
$rangkumanAI = generateRangkumanAI($pelanggarans, $siswa['name'] ?? 'Siswa', $openaiApiKey);

// ── Helper & Data ───────────────────────────────────────────────────────────
function e(string $s = ''): string {
    return htmlspecialchars(trim($s), ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

$kelas_full = trim(
    ($siswa['tingkat'] ?? '') . ' ' . 
    ($siswa['jurusan'] ?? '') . ' ' . 
    ($siswa['kelas'] ?? '')
);

$bulanId = [
    1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
    5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
    9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember',
];
$now = new DateTime();
$tglCetak = $now->format('d') . ' ' . $bulanId[(int)$now->format('n')] . ' ' . $now->format('Y');

$nama          = e($siswa['name'] ?? '');
$nis           = e($siswa['nis'] ?? '');
$kelas         = e($kelas_full);
$jurusan       = e($siswa['jurusan'] ?? '');
$namaOrtu      = e($siswa['name_orang_tua'] ?? '');
$pekerjaanOrtu = e($siswa['pekerjaan_orang_tua'] ?? '');
$alamatOrtu    = e($siswa['alamat_orang_tua'] ?? '');
$telpOrtu      = e($siswa['telphone_orang_tua'] ?? '');
$sp            = (int)($siswa['sp'] ?? 0);
$spLabel       = 'SP' . ($sp > 0 ? $sp : 1);

// ── Setup dokumen ────────────────────────────────────────────────────────────
$phpWord = new PhpWord();

$section = $phpWord->addSection([
    'marginTop'    => 400,
    'marginBottom' => 1440,
    'marginLeft'   => 1440,
    'marginRight'  => 1440,
]);

// ── Styles ───────────────────────────────────────────────────────────────────
$fTitle    = ['name' => 'Arial', 'size' => 14, 'bold' => true];
$fNormal   = ['name' => 'Arial', 'size' => 11];
$fLabel    = ['name' => 'Arial', 'size' => 11];
$fDots     = ['name' => 'Arial', 'size' => 11];
$fTTD      = ['name' => 'Arial', 'size' => 9];
$fMasalah  = ['name' => 'Arial', 'size' => 10];
$fRangkuman = ['name' => 'Arial', 'size' => 10, 'italic' => true]; // Style untuk rangkuman AI

$pCenter   = ['alignment' => Jc::CENTER, 'spaceAfter' => 0, 'spaceBefore' => 0];
$pLeft     = ['alignment' => Jc::LEFT,   'spaceAfter' => 0, 'spaceBefore' => 0];
$pJustify  = ['alignment' => Jc::BOTH,   'spaceAfter' => 0, 'spaceBefore' => 0];

// Posisi tab
$tabPos1 = 720;   // 1 alinea untuk label
$tabPos2 = 2880;  // 2 alinea untuk titik dua dan isi

// ── LOGO ─────────────────────────────────────────────────────────────────────
foreach (['logo_sekolah.png', 'logo_sekolah.jpg', 'logo_sekolah.jpeg'] as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        $section->addImage($path, [
            'width'     => 460,
            'alignment' => Jc::CENTER,
        ]);
        break;
    }
}

// ── JUDUL ────────────────────────────────────────────────────────────────────
$section->addText('SURAT PERNYATAAN SISWA', $fTitle, $pCenter);
$section->addTextBreak(1);

// ── PEMBUKA ──────────────────────────────────────────────────────────────────
$section->addText('Yang bertandatangan di bawah ini :', $fNormal, $pLeft);

// ── DATA FIELDS ──────────────────────────────────────────────────────────────

function addFieldDoubleTab($section, $label, $value, $fLabel, $fDots, $tab1, $tab2) {
    $pStyle = [
        'alignment' => Jc::LEFT,
        'spaceAfter' => 0,
        'tabs' => [
            new Tab('left', $tab1),
            new Tab('left', $tab2),
        ],
    ];
    
    $textRun = $section->addTextRun($pStyle);
    $displayValue = !empty($value) ? $value : str_repeat('.', 70);
    $textRun->addText("\t" . $label . "\t: " . $displayValue, $fLabel);
}

// Field data
addFieldDoubleTab($section, 'Nama', $nama, $fLabel, $fDots, $tabPos1, $tabPos2);
addFieldDoubleTab($section, 'NIS', $nis, $fLabel, $fDots, $tabPos1, $tabPos2);
addFieldDoubleTab($section, 'Kelas', $kelas, $fLabel, $fDots, $tabPos1, $tabPos2);
addFieldDoubleTab($section, 'Program Keahlian', $jurusan, $fLabel, $fDots, $tabPos1, $tabPos2);

// ── RANGKUMAN AI ─────────────────────────────────────────────────────────────
$pStyleMasalahLabel = [
    'alignment' => Jc::LEFT,
    'spaceAfter' => 0,
    'tabs' => [
        new Tab('left', $tabPos1),
    ],
];
$textRunLabel = $section->addTextRun($pStyleMasalahLabel);
$textRunLabel->addText("\t" . 'Masalah', $fLabel);

$pStyleRangkuman = [
    'alignment' => Jc::BOTH,
    'spaceAfter' => 120,
    'spaceBefore' => 0,
    'indentation' => [
        'left' => $tabPos1,  // Indentasi kiri sama dengan posisi tab label (720 twips)
    ],
];

$section->addText($rangkumanAI, $fRangkuman, $pStyleRangkuman);

// ── LANJUTKAN FIELD LAINNYA ───────────────────────────────────────────────────
addFieldDoubleTab($section, 'Nama Orang Tua', $namaOrtu, $fLabel, $fDots, $tabPos1, $tabPos2);
addFieldDoubleTab($section, 'Pekerjaan', $pekerjaanOrtu, $fLabel, $fDots, $tabPos1, $tabPos2);
addFieldDoubleTab($section, 'Alamat Rumah', $alamatOrtu, $fLabel, $fDots, $tabPos1, $tabPos2);
addFieldDoubleTab($section, 'No. Hp./Telp.', $telpOrtu, $fLabel, $fDots, $tabPos1, $tabPos2);

$section->addTextBreak(1);

// ── ISI PERNYATAAN ───────────────────────────────────────────────────────────
$isi1 = "Menyatakan dan berjanji akan bersungguh-sungguh berubah dan bersedia mentaati aturan dan tata tertib sekolah. Apabila selama masa pembinaan tidak mengalami perubahan, maka siswa yang bersangkutan dikembalikan kepada orang tua/wali.";
$isi2 = "Demikian surat pernyataan ini saya buat dengan sesungguhnya tanpa ada tekanan dari siapapun.";

$section->addText($isi1, $fNormal, $pJustify);
$section->addText($isi2, $fNormal, $pJustify);

$section->addTextBreak(1);

// ── TANDA TANGAN ─────────────────────────────────────────────────────────────
$ttdTable = $section->addTable([
    'width' => 100 * 50,
    'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,
]);

// Baris 1: Label (CENTER)
$ttdTable->addRow(200);
$cell1 = $ttdTable->addCell(4500);
$cell1->addText('Mengetahui,', $fTTD, $pCenter);
$cell1->addText('Orang Tua/Wali siswa', $fTTD, $pCenter);

$cell2 = $ttdTable->addCell(4500);
$cell2->addText('Denpasar, ' . $tglCetak, $fTTD, $pCenter);
$cell2->addText('Siswa yang bersangkutan', $fTTD, $pCenter);

// Baris 2: Space tanda tangan
$ttdTable->addRow(700);
$ttdTable->addCell(4500)->addText('');
$ttdTable->addCell(4500)->addText('');

// Baris 3: Garis tanda tangan (CENTER)
$ttdTable->addRow(200);
$ttdTable->addCell(4500)->addText(str_repeat('.', 35), $fTTD, $pCenter);
$ttdTable->addCell(4500)->addText(str_repeat('.', 35), $fTTD, $pCenter);

// Baris 4: Nama (CENTER)
$ttdTable->addRow(200);
$ttdTable->addCell(4500)->addText($namaOrtu ?: '......................................', $fTTD, $pCenter);
$ttdTable->addCell(4500)->addText($nama ?: '......................................', $fTTD, $pCenter);

// ── GURU BK & WALI KELAS ─────────────────────────────────────────────────────
$guruTable = $section->addTable([
    'width' => 100 * 50,
    'layout' => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,
]);

$guruTable->addRow(200);
$guruTable->addCell(4500)->addText('Guru Bimbingan Konseling', $fTTD, $pCenter);
$guruTable->addCell(4500)->addText('Guru Wali Kelas', $fTTD, $pCenter);

$guruTable->addRow(700);
$guruTable->addCell(4500)->addText('');
$guruTable->addCell(4500)->addText('');

$guruTable->addRow(200);
$guruTable->addCell(4500)->addText(str_repeat('.', 35), $fTTD, $pCenter);
$guruTable->addCell(4500)->addText(str_repeat('.', 35), $fTTD, $pCenter);

$guruTable->addRow(200);
$guruTable->addCell(4500)->addText('Ni Putu Chintya Pradnya Suari, S.Pd', $fTTD, $pCenter);
$guruTable->addCell(4500)->addText('(_______________________)', $fTTD, $pCenter);

// ── WAKASEK KESISWAAN ────────────────────────────────────────────────────────
$section->addText('Mengetahui', $fTTD, $pCenter);
$section->addText('Wakasek Kesiswaan', $fTTD, $pCenter);
$section->addTextBreak(2, $fTTD);
$section->addText(str_repeat('.', 35), $fTTD, $pCenter);
$section->addText('Bagus Putu Eka Wijaya, S.Kom', $fTTD, $pCenter);

// ── Download ─────────────────────────────────────────────────────────────────
$filename = 'surat_pernyataan_' 
          . preg_replace('/[^a-zA-Z0-9_]/', '_', $siswa['name'] ?? 'siswa') 
          . '_' . $spLabel . '.docx';

$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: ');

readfile($filename);
unlink($filename);
exit;
?>