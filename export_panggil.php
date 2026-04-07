<?php
/**
 * export_panggil.php
 * Generate Surat Panggilan Orang Tua / Wali Siswa
 * Format sesuai contoh: No, Lamp, Perihal, Kepada, dll
 */

require 'vendor/autoload.php';
include 'database.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Tab;
use PhpOffice\PhpWord\ComplexType\TblWidth as TableWidth;

// ── Parameter ──────────────────────────────────────────────────────────────
$id         = (int)($_GET['id'] ?? 0);
$tanggal    = $_GET['tanggal'] ?? date('Y-m-d');
$jam        = $_GET['jam'] ?? '08:00';
$keperluan  = $_GET['keperluan'] ?? 'Masalah Disiplin Siswa';
$tempat     = $_GET['tempat'] ?? 'SMK TI Bali Global Denpasar';

if ($id === 0) {
    http_response_code(400);
    die('ID siswa tidak valid.');
}

// ── Query data siswa ─────────────────────────────────────────────────────────
$stmt = $pdo->prepare("
    SELECT 
        s.id, s.name, s.nis, s.id_kelas,
        s.name_orang_tua, s.telphone_orang_tua,
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

// Format tanggal Indonesia
$bulanId = [
    1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
    5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
    9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember',
];

$tglParts = explode('-', $tanggal);
$tglIndo = (int)$tglParts[2] . ' ' . $bulanId[(int)$tglParts[1]] . ' ' . $tglParts[0];

$now = new DateTime();
$tglSurat = $now->format('d') . ' ' . $bulanId[(int)$now->format('n')] . ' ' . $now->format('Y');

// Nomor surat otomatis
$noUrut = str_pad($id, 3, '0', STR_PAD_LEFT);
$noSurat = "{$noUrut}/SMKTI/B/" . $now->format('Y');

// Data
$namaSiswa   = e($siswa['name'] ?? '');
$nis         = e($siswa['nis'] ?? '');
$kelas       = e($kelas_full);
$namaOrtu    = e($siswa['name_orang_tua'] ?? '......................................');
$telpOrtu    = e($siswa['telphone_orang_tua'] ?? '......................................');

// ── Setup dokumen ────────────────────────────────────────────────────────────
$phpWord = new PhpWord();

$section = $phpWord->addSection([
    'marginTop'    => 720,   // 1.27cm
    'marginBottom' => 720,
    'marginLeft'   => 1134,  // 2cm
    'marginRight'  => 1134,
]);

// ── Styles ───────────────────────────────────────────────────────────────────
$fNormal     = ['name' => 'Times New Roman', 'size' => 12];
$fBold       = ['name' => 'Times New Roman', 'size' => 12, 'bold' => true];
$fHeader     = ['name' => 'Times New Roman', 'size' => 10];
$fTitle      = ['name' => 'Times New Roman', 'size' => 14, 'bold' => true];
$fSmall      = ['name' => 'Times New Roman', 'size' => 10];

$pLeft       = ['alignment' => Jc::LEFT, 'spaceAfter' => 0, 'spaceBefore' => 0];
$pCenter     = ['alignment' => Jc::CENTER, 'spaceAfter' => 0, 'spaceBefore' => 0];
$pJustify    = ['alignment' => Jc::BOTH, 'spaceAfter' => 120, 'spaceBefore' => 0];

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

// ── NOMOR SURAT ──────────────────────────────────────────────────────────────
$tableNomor = $section->addTable(['width' => 100 * 50]);
$tableNomor->addRow(200);
$tableNomor->addCell(2000)->addText('No.', $fNormal, $pLeft);
$tableNomor->addCell(6000)->addText(': ' . $noSurat, $fNormal, $pLeft);

$tableNomor->addRow(200);
$tableNomor->addCell(2000)->addText('Lamp.', $fNormal, $pLeft);
$tableNomor->addCell(6000)->addText(': -', $fNormal, $pLeft);

$tableNomor->addRow(200);
$tableNomor->addCell(2000)->addText('Perihal', $fNormal, $pLeft);
$tableNomor->addCell(6000)->addText(': Pemanggilan Orang Tua / Wali Siswa', $fNormal, $pLeft);

$section->addTextBreak(1);

// ── KEPADA ───────────────────────────────────────────────────────────────────
$section->addText('Kepada', $fNormal, $pLeft);
$section->addText('Yth. Bapak/ Ibu', $fNormal, $pLeft);

// Tabel Kepada
$tableKepada = $section->addTable(['width' => 100 * 50]);
$tableKepada->addRow(200);
$tableKepada->addCell(3000)->addText('Orang Tua / Wali dari', $fNormal, $pLeft);
$tableKepada->addCell(5000)->addText(': ' . $namaOrtu, $fNormal, $pLeft);

$tableKepada->addRow(200);
$tableKepada->addCell(3000)->addText('Kelas / NIS', $fNormal, $pLeft);
$tableKepada->addCell(5000)->addText(': ' . $kelas . ' / ' . $nis, $fNormal, $pLeft);

$section->addTextBreak(1);

// ── ISI SURAT ────────────────────────────────────────────────────────────────
$section->addText('Dengan hormat,', $fNormal, $pLeft);
$section->addTextBreak(1);

$section->addText(
    'Bersama surat ini, kami mengharapkan kehadiran Bapak / Ibu pada :',
    $fNormal,
    $pLeft
);

// Tabel Detail - TANPA parameter indent yang bermasalah
// Gunakan cell dengan width untuk simulasi indent
$tableDetail = $section->addTable(['width' => 100 * 50]);
$tableDetail->addRow(200);
$tableDetail->addCell(500)->addText('', $fNormal); // Empty cell untuk spacing/indent
$tableDetail->addCell(2000)->addText('Hari / Tanggal', $fNormal, $pLeft);
$tableDetail->addCell(6000)->addText(': ' . $tglIndo, $fNormal, $pLeft);

$tableDetail->addRow(200);
$tableDetail->addCell(500)->addText('', $fNormal);
$tableDetail->addCell(2000)->addText('Pukul', $fNormal, $pLeft);
$tableDetail->addCell(6000)->addText(': ' . $jam . ' Wita', $fNormal, $pLeft);

$tableDetail->addRow(200);
$tableDetail->addCell(500)->addText('', $fNormal);
$tableDetail->addCell(2000)->addText('Tempat', $fNormal, $pLeft);
$tableDetail->addCell(6000)->addText(': ' . $tempat, $fNormal, $pLeft);

$tableDetail->addRow(200);
$tableDetail->addCell(500)->addText('', $fNormal);
$tableDetail->addCell(2000)->addText('Keperluan', $fNormal, $pLeft);
$tableDetail->addCell(6000)->addText(': ' . $keperluan, $fNormal, $pLeft);

$section->addTextBreak(1);

// ── PENUTUP ──────────────────────────────────────────────────────────────────
$section->addText(
    'Demikian surat ini kami sampaikan, besar harapan kami pertemuan ini agar tidak diwakilkan. ' .
    'Atas perhatian dan kerjasamanya, kami ucapkan terimakasih.',
    $fNormal,
    $pJustify
);

$section->addTextBreak(1);

// ── TANDA TANGAN ─────────────────────────────────────────────────────────────
$tableTTD = $section->addTable(['width' => 100 * 50]);
$tableTTD->addRow(200);
$tableTTD->addCell(4500)->addText('Mengetahui,', $fNormal, $pLeft);
$tableTTD->addCell(4500)->addText('Denpasar, ' . $tglSurat, $fNormal, $pLeft);

$tableTTD->addRow(200);
$tableTTD->addCell(4500)->addText('Waka Kesiswaan', $fNormal, $pLeft);
$tableTTD->addCell(4500)->addText('Guru BK', $fNormal, $pLeft);

// Space tanda tangan
$tableTTD->addRow(1000);
$tableTTD->addCell(4500)->addText('');
$tableTTD->addCell(4500)->addText('');

$tableTTD->addRow(200);
$tableTTD->addCell(4500)->addText('Bagus Putu Eka Wijaya, S.Kom', $fNormal, $pLeft);
$tableTTD->addCell(4500)->addText('I Gusti Ayu Rinjani, M.Pd', $fNormal, $pLeft);

// ── Download ─────────────────────────────────────────────────────────────────
$filename = 'surat_panggilan_' 
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