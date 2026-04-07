<?php
/**
 * export_do.php
 * Generate Surat Keputusan Drop Out (DO)
 */

require 'vendor/autoload.php';
include 'database.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

// ── Parameter ──────────────────────────────────────────────────────────────
$id         = (int)($_GET['id'] ?? 0);
$tanggal    = $_GET['tanggal'] ?? date('Y-m-d');
$detail     = $_GET['detail'] ?? '';

if ($id === 0) {
    http_response_code(400);
    die('ID siswa tidak valid.');
}

// ── Query data siswa ─────────────────────────────────────────────────────────
$stmt = $pdo->prepare("
    SELECT 
        s.id, s.name, s.nis, s.id_kelas,
        s.name_orang_tua, s.pekerjaan_orang_tua, 
        s.alamat_orang_tua, s.telphone_orang_tua,
        s.alamat, s.telphone,
        s.point, s.sp,
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

$tglParts = explode('-', $tanggal);
$tglEfektif = (int)$tglParts[2] . ' ' . $bulanId[(int)$tglParts[1]] . ' ' . $tglParts[0];

$now = new DateTime();
$tglSurat = $now->format('d') . ' ' . $bulanId[(int)$now->format('n')] . ' ' . $now->format('Y');

$noUrut = str_pad($id, 3, '0', STR_PAD_LEFT);
$romawiBulan = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'][(int)$now->format('n')-1];
$noSurat = "{$noUrut}/SMK TI/BG/{$romawiBulan}/" . $now->format('Y');

$namaSiswa      = e($siswa['name'] ?? '');
$nis            = e($siswa['nis'] ?? '');
$kelas          = e($kelas_full);
$alamatSiswa    = e($siswa['alamat'] ?? '');
$namaOrtu       = e($siswa['name_orang_tua'] ?? '......................................');
$alamatOrtu     = e($siswa['alamat_orang_tua'] ?? '......................................');

// ── Setup dokumen ────────────────────────────────────────────────────────────
$phpWord = new PhpWord();

$section = $phpWord->addSection([
    'marginTop'    => 720,
    'marginBottom' => 720,
    'marginLeft'   => 1134,
    'marginRight'  => 1134,
]);

// ── Styles ───────────────────────────────────────────────────────────────────
$fNormal     = ['name' => 'Times New Roman', 'size' => 12];
$fBold       = ['name' => 'Times New Roman', 'size' => 12, 'bold' => true];
$fUnderline  = ['name' => 'Times New Roman', 'size' => 14, 'bold' => true, 'underline' => 'single'];

$pLeft       = ['alignment' => Jc::LEFT, 'spaceAfter' => 0, 'spaceBefore' => 0];
$pCenter     = ['alignment' => Jc::CENTER, 'spaceAfter' => 0, 'spaceBefore' => 0];
$pJustify    = ['alignment' => Jc::BOTH, 'spaceAfter' => 120, 'spaceBefore' => 0];
$pRight      = ['alignment' => Jc::RIGHT, 'spaceAfter' => 0, 'spaceBefore' => 0];

// ── LOGO & HEADER ────────────────────────────────────────────────────────────
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
$section->addText('SURAT KEPUTUSAN DROP OUT', $fUnderline, $pCenter);
$section->addText('No : ' . $noSurat, $fNormal, $pCenter);
$section->addTextBreak(1);

// ── PEMBUKA ──────────────────────────────────────────────────────────────────
$section->addText(
    'Yang bertanda tangan dibawah ini Kepala SMK TI BALI GLOBAL Denpasar, kecamatan ' .
    'Denpasar Selatan, Kota Denpasar, Provinsi Bali, Menerangkan bahwa siswa dengan identitas:',
    $fNormal,
    $pJustify
);

// ── TABEL DATA SISWA ─────────────────────────────────────────────────────────
$tableSiswa = $section->addTable(['width' => 100 * 50]);

function addDoField($table, $label, $value, $fNormal, $pLeft) {
    $table->addRow(200);
    $table->addCell(3500)->addText($label, $fNormal, $pLeft);
    $table->addCell(500)->addText(':', $fNormal, $pLeft);
    $table->addCell(6000)->addText($value, $fNormal, $pLeft);
}

addDoField($tableSiswa, 'Nama Siswa', $namaSiswa, $fNormal, $pLeft);
addDoField($tableSiswa, 'Kelas/Program', $kelas, $fNormal, $pLeft);
addDoField($tableSiswa, 'NIS', $nis, $fNormal, $pLeft);
addDoField($tableSiswa, 'Alamat Siswa', $alamatSiswa ?: '......................................', $fNormal, $pLeft);

$section->addTextBreak(1);

// ── PARAGRAF PERTAMA ─────────────────────────────────────────────────────────
$section->addText(
    'Melalui surat ini, kami menyampaikan keputusan terkait status pendidikan siswa kepada Orang Tua/Wali:',
    $fNormal,
    $pJustify
);

// ── TABEL DATA ORANG TUA (setelah paragraf) ──────────────────────────────────
$tableOrtu = $section->addTable(['width' => 100 * 50]);

addDoField($tableOrtu, 'Nama Orang Tua/Wali', $namaOrtu, $fNormal, $pLeft);
addDoField($tableOrtu, 'Alamat Orang Tua/Wali', $alamatOrtu, $fNormal, $pLeft);

$section->addTextBreak(1);

// ── PARAGRAF KEDUA (Keputusan) ───────────────────────────────────────────────
$textKeputusan = 
    "Sehubungan dengan pelanggaran tata tertib yang telah dilakukan oleh siswa atas nama {$namaSiswa} " .
    "dari kelas {$kelas}, serta setelah melalui proses pembinaan dan pertimbangan yang matang, " .
    "dengan ini kami menyampaikan bahwa pihak sekolah memutuskan untuk mengakhiri status pendidikan " .
    "siswa yang bersangkutan di SMK TI Bali Global mulai tanggal {$tglEfektif} sudah bukan bagian dari peserta didik kami.";

$section->addText($textKeputusan, $fNormal, $pJustify);
$section->addTextBreak(1);

// ── PARAGRAF KETIGA ───────────────────────────────────────────────────────────
$section->addText(
    'Demikian dari surat ini dan keputusan ini diambil sebagai langkah terakhir setelah berbagai upaya pembinaan yang telah dilakukan oleh pihak sekolah.',
    $fNormal,
    $pJustify
);
$section->addTextBreak(1);

// Detail tambahan jika ada
if (!empty($detail)) {
    $section->addText('Keterangan tambahan: ' . $detail, $fNormal, $pJustify);
    $section->addTextBreak(1);
}

$section->addTextBreak(1);

// ── TANDA TANGAN ─────────────────────────────────────────────────────────────
$section->addText('Denpasar, ' . $tglSurat, $fNormal, $pRight);
$section->addText('Kepala SMK TI Bali Global Denpasar', $fNormal, $pRight);
$section->addTextBreak(3);
$section->addText('Drs. I Gusti Made Murjana, M.Pd', $fBold, $pRight);

// ── Download ─────────────────────────────────────────────────────────────────
$filename = 'surat_keputusan_DO_' 
          . preg_replace('/[^a-zA-Z0-9_]/', '_', $siswa['name'] ?? 'siswa') 
          . '_' . date('Ymd') . '.docx';

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