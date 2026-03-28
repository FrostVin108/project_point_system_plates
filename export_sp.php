<?php
/**
 * export_sp.php
 * Generate Surat Pernyataan Siswa dengan data dari database
 */

require 'vendor/autoload.php';
include 'database.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Tab;

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
    die('Data siswa tidak ditemukan.');
}

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
$fTTD      = ['name' => 'Arial', 'size' => 9];  // Font khusus tanda tangan

$pCenter   = ['alignment' => Jc::CENTER, 'spaceAfter' => 0, 'spaceBefore' => 0];
$pLeft     = ['alignment' => Jc::LEFT,   'spaceAfter' => 0, 'spaceBefore' => 0];
$pJustify  = ['alignment' => Jc::BOTH,   'spaceAfter' => 0, 'spaceBefore' => 0];

// Posisi tab
$tabPos1 = 720;
$tabPos2 = 2880;

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

function addMasalahDoubleTab($section, $label, $fLabel, $fDots, $tab1, $tab2) {
    $pStyle1 = [
        'alignment' => Jc::LEFT,
        'spaceAfter' => 0,
    ];
    $textRun1 = $section->addTextRun($pStyle1);
    $textRun1->addText("\t" . $label, $fLabel);
    
    $pStyle2 = [
        'alignment' => Jc::LEFT,
        'spaceAfter' => 0,
    ];
    for ($i = 0; $i < 3; $i++) {
        $textRun = $section->addTextRun($pStyle2);
        $textRun->addText("\t" . str_repeat('.', 70), $fDots);
    }
}

// Field data
addFieldDoubleTab($section, 'Nama', $nama, $fLabel, $fDots, $tabPos1, $tabPos2);
addFieldDoubleTab($section, 'NIS', $nis, $fLabel, $fDots, $tabPos1, $tabPos2);
addFieldDoubleTab($section, 'Kelas', $kelas, $fLabel, $fDots, $tabPos1, $tabPos2);
addFieldDoubleTab($section, 'Program Keahlian', $jurusan, $fLabel, $fDots, $tabPos1, $tabPos2);
addMasalahDoubleTab($section, 'Masalah', $fLabel, $fDots, $tabPos1, $tabPos2);
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

// ── TANDA TANGAN (Orang Tua & Siswa) ─────────────────────────────────────────
$ttdTable = $section->addTable([
    'borderSize' => 0,        // No border
    'borderColor' => 'FFFFFF', // White border (invisible)
    'width'      => 5000,
]);

// Baris 1: Label
$ttdTable->addRow(200);
$cell1 = $ttdTable->addCell(4500, ['borderSize' => 0, 'valign' => 'top']);
$cell1->addText('Mengetahui,', $fTTD, $pLeft);
$cell1->addText('Orang Tua/Wali siswa', $fTTD, $pLeft);

$cell2 = $ttdTable->addCell(4500, ['borderSize' => 0, 'valign' => 'top']);
$cell2->addText('Denpasar, ' . $tglCetak, $fTTD, $pLeft);
$cell2->addText('Siswa yang bersangkutan', $fTTD, $pLeft);

// Baris 2: Space untuk tanda tangan (200px ≈ 1500 twips)
$ttdTable->addRow(700);
$ttdTable->addCell(4500, ['borderSize' => 0])->addText('');
$ttdTable->addCell(4500, ['borderSize' => 0])->addText('');

// Baris 3: Garis tanda tangan
$ttdTable->addRow(200);
$ttdTable->addCell(4500, ['borderSize' => 0])->addText(str_repeat('.', 35), $fTTD, $pLeft);
$ttdTable->addCell(4500, ['borderSize' => 0])->addText(str_repeat('.', 35), $fTTD, $pLeft);

// Baris 4: Nama
$ttdTable->addRow(200);
$ttdTable->addCell(4500, ['borderSize' => 0])->addText($namaOrtu ?: '......................................', $fTTD, $pLeft);
$ttdTable->addCell(4500, ['borderSize' => 0])->addText($nama ?: '......................................', $fTTD, $pLeft);

// ── GURU BK & WALI KELAS ─────────────────────────────────────────────────────
$guruTable = $section->addTable([
    'borderSize' => 0,
    'borderColor' => 'FFFFFF',
    'width'      => 5000,
]);

$guruTable->addRow(200);
$guruTable->addCell(4500, ['borderSize' => 0])->addText('Guru Bimbingan Konseling', $fTTD, $pLeft);
$guruTable->addCell(4500, ['borderSize' => 0])->addText('Guru Wali Kelas', $fTTD, $pLeft);

// Space 200px
$guruTable->addRow(700);
$guruTable->addCell(4500, ['borderSize' => 0])->addText('');
$guruTable->addCell(4500, ['borderSize' => 0])->addText('');

$guruTable->addRow(200);
$guruTable->addCell(4500, ['borderSize' => 0])->addText(str_repeat('.', 35), $fTTD, $pLeft);
$guruTable->addCell(4500, ['borderSize' => 0])->addText(str_repeat('.', 35), $fTTD, $pLeft);

$guruTable->addRow(200);
$guruTable->addCell(4500, ['borderSize' => 0])->addText('Ni Putu Chintya Pradnya Suari, S.Pd', $fTTD, $pLeft);
$guruTable->addCell(4500, ['borderSize' => 0])->addText('', $fTTD, $pLeft);

$section->addTextBreak(1);

// ── WAKASEK KESISWAAN ────────────────────────────────────────────────────────
$section->addText('Mengetahui', $fTTD, $pCenter);
$section->addText('Wakasek Kesiswaan', $fTTD, $pCenter);
// Space 200px (gunakan TextBreak dengan paragraph style untuk tinggi)
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
header('Pragma: no-cache');

readfile($filename);
unlink($filename);
exit;
?>