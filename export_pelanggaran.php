<?php
require 'vendor/autoload.php';
include 'database.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;
use League\Plates\Engine;

// ── Parameter ──────────────────────────────────────────────────────────────
$date_start = $_GET['date_start'] ?? date('Y-m-01');
$date_end = $_GET['date_end'] ?? date('Y-m-t');

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_start))
    $date_start = date('Y-m-01');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_end))
    $date_end = date('Y-m-t');
if ($date_start > $date_end)
    [$date_start, $date_end] = [$date_end, $date_start];

// ── Query data ─────────────────────────────────────────────────────────────
$stmt = $pdo->prepare("
    SELECT
        p.date,
        p.total_point,
        s.name      AS siswa_name,
        s.nis       AS siswa_nis,
        k.tingkat   AS kelas_tingkat,
        k.jurusan   AS kelas_jurusan,
        k.kelas     AS kelas_kelas,
        jp.name     AS jenis_name,
        ap.detail   AS alasan_detail
    FROM pelanggarans p
    LEFT JOIN siswas              s  ON p.id_siswa             = s.id
    LEFT JOIN kelas               k  ON s.id_kelas             = k.id
    LEFT JOIN jenis_pelanggarans  jp ON p.id_jenis_pelanggaran = jp.id
    LEFT JOIN alasan_pelanggarans ap ON p.id_alasan_pelanggaran= ap.id
    WHERE DATE(p.date) BETWEEN ? AND ?
    ORDER BY p.date ASC, s.name ASC
");
$stmt->execute([$date_start, $date_end]);
$rawRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ── Format tanggal Indonesia ───────────────────────────────────────────────
$bulan_id = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember',
];
function fmtTgl(string $tgl, array $b): string
{
    if (!$tgl)
        return '-';
    $d = new DateTime(substr($tgl, 0, 10));
    return (int) $d->format('d') . ' ' . $b[(int) $d->format('m')] . ' ' . $d->format('Y');
}

// ── Siapkan data untuk template ────────────────────────────────────────────
$rows = array_map(function ($r) use ($bulan_id) {
    $kelas = trim(
        ($r['kelas_tingkat'] ?? '') . ' ' .
        ($r['kelas_jurusan'] ?? '') . ' ' .
        ($r['kelas_kelas'] ?? '')
    ) ?: '-';
    return [
        'siswa_name' => $r['siswa_name'] ?? '-',
        'siswa_nis' => $r['siswa_nis'] ?? '-',
        'kelas' => $kelas,
        'jenis_name' => $r['jenis_name'] ?? '-',
        'alasan_detail' => $r['alasan_detail'] ?? '-',
        'date_fmt' => fmtTgl($r['date'] ?? '', $bulan_id),
    ];
}, $rawRows);

$periode = ($date_start === $date_end)
    ? fmtTgl($date_start, $bulan_id)
    : fmtTgl($date_start, $bulan_id) . ' - ' . fmtTgl($date_end, $bulan_id);
$cetak_pada = fmtTgl(date('Y-m-d'), $bulan_id);
$total_data = count($rows);

// ── Render template via Plates ─────────────────────────────────────────────
$templates = new Engine('templates');
$html = $templates->render('export_pelanggaran', [
    'rows' => $rows,
    'periode' => $periode,
    'cetak_pada' => $cetak_pada,
    'total_data' => $total_data,
]);

// ── Buat dokumen Word ──────────────────────────────────────────────────────
$phpWord = new PhpWord();
$section = $phpWord->addSection([
    'marginTop' => 1200,
    'marginBottom' => 1200,
    'marginLeft' => 1200,
    'marginRight' => 1200,
]);

// Logo (opsional) — taruh logo_sekolah.jpg/png di root project
if (file_exists('logo_sekolah.jpg')) {
    $section->addImage('logo_sekolah.jpg', [
        'height' => 100,
        'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
        'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_CENTER,
        'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_VERTICAL_TOP,
        'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
        'posVerticalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
        'wrappingStyle' => 'square',
        
    ]);
} elseif (file_exists('logo_sekolah.png')) {
    $section->addImage('logo_sekolah.png', [
        'height' => 100,
        'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
        'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_CENTER,
        'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_VERTICAL_TOP,
        'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
        'posVerticalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
        'wrappingStyle' => 'square',
    ]);
}

Html::addHtml($section, $html);

// ── Download ───────────────────────────────────────────────────────────────
$filename = 'laporan_pelanggaran_' . $date_start . '_sd_' . $date_end . '.docx';
$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filename);
unlink($filename);
exit;
?>