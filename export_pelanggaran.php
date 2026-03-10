<?php
require 'vendor/autoload.php';
include 'database.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

// ── Parameter ──────────────────────────────────────────────────────────────
$date_start = $_GET['date_start'] ?? date('Y-m-01');
$date_end   = $_GET['date_end']   ?? date('Y-m-t');

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_start)) $date_start = date('Y-m-01');
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_end))   $date_end   = date('Y-m-t');
if ($date_start > $date_end) [$date_start, $date_end] = [$date_end, $date_start];

// ── Query semua jenis pelanggaran ──────────────────────────────────────────
$stmtJenis = $pdo->query("SELECT id, name FROM jenis_pelanggarans ORDER BY id ASC");
$allJenis  = $stmtJenis->fetchAll(PDO::FETCH_ASSOC);

function singkatan(string $nama): string {
    $words   = preg_split('/\s+/', trim($nama));
    $akronim = '';
    foreach ($words as $w) {
        if ($w !== '') $akronim .= strtoupper(mb_substr($w, 0, 1));
    }
    return $akronim ?: '-';
}

$jenisMap = [];
foreach ($allJenis as $j) {
    $jenisMap[$j['id']] = [
        'name'      => $j['name'],
        'singkatan' => singkatan($j['name']),
    ];
}
$jumlahJenis = count($allJenis);

// ── Query data pelanggaran ─────────────────────────────────────────────────
$stmt = $pdo->prepare("
    SELECT
        p.date,
        p.id_jenis_pelanggaran,
        s.name      AS siswa_name,
        k.tingkat   AS kelas_tingkat,
        k.jurusan   AS kelas_jurusan,
        k.kelas     AS kelas_kelas,
        ap.detail   AS alasan_detail
    FROM pelanggarans p
    LEFT JOIN siswas              s  ON p.id_siswa              = s.id
    LEFT JOIN kelas               k  ON s.id_kelas              = k.id
    LEFT JOIN alasan_pelanggarans ap ON p.id_alasan_pelanggaran = ap.id
    WHERE DATE(p.date) BETWEEN ? AND ?
    ORDER BY p.date ASC, s.name ASC
");
$stmt->execute([$date_start, $date_end]);
$rawRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ── Format tanggal Indonesia ───────────────────────────────────────────────
$bulan_id = [
    1=>'Januari',   2=>'Februari',  3=>'Maret',    4=>'April',
    5=>'Mei',       6=>'Juni',      7=>'Juli',      8=>'Agustus',
    9=>'September', 10=>'Oktober',  11=>'November', 12=>'Desember',
];
function fmtTgl(string $tgl, array $b): string {
    if (!$tgl) return '-';
    $d = new DateTime(substr($tgl, 0, 10));
    return $d->format('d/m/Y');
}

$rows = array_map(function ($r) use ($bulan_id) {
    $kelas = trim(
        ($r['kelas_tingkat'] ?? '') . ' ' .
        ($r['kelas_jurusan'] ?? '') . ' ' .
        ($r['kelas_kelas']   ?? '')
    ) ?: '-';
    return [
        'date_fmt'      => fmtTgl($r['date'] ?? '', $bulan_id),
        'siswa_name'    => $r['siswa_name']           ?? '-',
        'kelas'         => $kelas,
        'id_jenis'      => $r['id_jenis_pelanggaran'] ?? null,
        'alasan_detail' => $r['alasan_detail']        ?? '-',
    ];
}, $rawRows);

$periode    = ($date_start === $date_end)
            ? fmtTgl($date_start, $bulan_id)
            : fmtTgl($date_start, $bulan_id) . ' - ' . fmtTgl($date_end, $bulan_id);
$cetak_pada = fmtTgl(date('Y-m-d'), $bulan_id);
$total_data = count($rows);

// ── Setup dokumen ──────────────────────────────────────────────────────────
$phpWord = new PhpWord();
$section = $phpWord->addSection([
    'marginTop'    => 1200,
    'marginBottom' => 1200,
    'marginLeft'   => 1200,
    'marginRight'  => 1200,
]);

// ── Font & paragraph styles ────────────────────────────────────────────────
$fT  = ['name' => 'Arial', 'size' => 13, 'bold' => true];
$fIt = ['name' => 'Arial', 'size' => 10, 'italic' => true];
$fN  = ['name' => 'Arial', 'size' => 10];
$fB  = ['name' => 'Arial', 'size' => 10, 'bold' => true];
$fS  = ['name' => 'Arial', 'size' => 9];
$fSB = ['name' => 'Arial', 'size' => 9,  'bold' => true];
$pC  = ['alignment' => Jc::CENTER, 'spaceAfter' => 0, 'spaceBefore' => 0];
$pL  = ['alignment' => Jc::START,  'spaceAfter' => 0, 'spaceBefore' => 0];
$pR  = ['alignment' => Jc::END,    'spaceAfter' => 0, 'spaceBefore' => 0];

// ── Logo header ───────────────────────────────────────────────────────────
$section->addTextBreak(1); // space antara margin atas dan logo
if (file_exists(__DIR__ . '/logo_sekolah.jpg')) {
    $section->addImage(__DIR__ . '/logo_sekolah.jpg', [
        'height'    => 80,
        'alignment' => Jc::CENTER,
    ]);
} elseif (file_exists(__DIR__ . '/logo_sekolah.png')) {
    $section->addImage(__DIR__ . '/logo_sekolah.png', [
        'height'    => 80,
        'alignment' => Jc::CENTER,
    ]);
}
$section->addTextBreak(1); // space antara logo dan judul

// ── Judul ──────────────────────────────────────────────────────────────────
$section->addText('LAPORAN DATA PELANGGARAN SISWA', $fT,  ['alignment' => Jc::CENTER, 'spaceAfter' => 40,  'spaceBefore' => 0]);
$section->addText('Periode : ' . $periode,          $fIt, ['alignment' => Jc::CENTER, 'spaceAfter' => 120, 'spaceBefore' => 0]);

// ── Cell style: all border ─────────────────────────────────────────────────
$border = [
    'borderTopSize'    => 6, 'borderTopColor'    => '000000',
    'borderBottomSize' => 6, 'borderBottomColor' => '000000',
    'borderLeftSize'   => 6, 'borderLeftColor'   => '000000',
    'borderRightSize'  => 6, 'borderRightColor'  => '000000',
    'valign'           => 'center',
];

// ── Lebar kolom (DXA) ──────────────────────────────────────────────────────
$wTgl      = 1040;
$wNama     = 3584;
$wKls      = 978;
$wJen      = 432;   // per kolom jenis
$wKet      = 2448;
$wJenTotal = $wJen * $jumlahJenis;

// ── Tabel ──────────────────────────────────────────────────────────────────
$table = $section->addTable([
    'borderSize' => 0,
    'cellMargin' => 60,
    'layout'     => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,
]);

// ── HEADER BARIS 1 ─────────────────────────────────────────────────────────
$table->addRow(200);
$table->addCell($wTgl,     array_merge($border, ['vMerge' => 'restart']))->addText('TGL',               $fSB, $pC);
$table->addCell($wNama,    array_merge($border, ['vMerge' => 'restart']))->addText('NAMA',              $fSB, $pC);
$table->addCell($wKls,     array_merge($border, ['vMerge' => 'restart']))->addText('KELAS',             $fSB, $pC);
$table->addCell($wJenTotal,array_merge($border, ['gridSpan' => max(1, $jumlahJenis)]))->addText('JENIS PELANGGARAN', $fSB, $pC);
$table->addCell($wKet,     array_merge($border, ['vMerge' => 'restart']))->addText('KETERANGAN',        $fSB, $pC);

// ── HEADER BARIS 2: singkatan jenis ───────────────────────────────────────
$table->addRow(200);
$table->addCell($wTgl,  array_merge($border, ['vMerge' => 'continue']));
$table->addCell($wNama, array_merge($border, ['vMerge' => 'continue']));
$table->addCell($wKls,  array_merge($border, ['vMerge' => 'continue']));
foreach ($allJenis as $j) {
    $table->addCell($wJen, $border)->addText($jenisMap[$j['id']]['singkatan'], $fSB, $pC);
}
$table->addCell($wKet, array_merge($border, ['vMerge' => 'continue']));

// ── BARIS DATA ─────────────────────────────────────────────────────────────
if (empty($rows)) {
    $table->addRow(200);
    $table->addCell(
        $wTgl + $wNama + $wKls + $wJenTotal + $wKet,
        array_merge($border, ['gridSpan' => 4 + $jumlahJenis])
    )->addText('Tidak ada data pelanggaran pada periode ini.', array_merge($fS, ['italic' => true, 'color' => '777777']), $pC);
} else {
    foreach ($rows as $r) {
        $table->addRow(200);
        $table->addCell($wTgl,  $border)->addText($r['date_fmt'],     $fS, $pC);
        $table->addCell($wNama, $border)->addText($r['siswa_name'],   $fS, $pL);
        $table->addCell($wKls,  $border)->addText($r['kelas'],        $fS, $pC);
        foreach ($allJenis as $j) {
            $centang = ((string)$r['id_jenis'] === (string)$j['id']) ? "\u{2713}" : '';
            $table->addCell($wJen, $border)->addText($centang, $fS, $pC);
        }
        $table->addCell($wKet, $border)->addText($r['alasan_detail'], $fS, $pL);
    }
}

// ── Total ──────────────────────────────────────────────────────────────────
$section->addText(
    'Total: ' . $total_data . ' pelanggaran',
    $fS,
    ['alignment' => Jc::END, 'spaceBefore' => 80, 'spaceAfter' => 300]
);

// ── Tanda tangan + keterangan singkatan ───────────────────────────────────
$tblTTD = $section->addTable(['borderSize' => 0, 'borderColor' => 'FFFFFF', 'cellMargin' => 0]);
$tblTTD->addRow(3000);

// Kolom kiri: keterangan kepanjangan singkatan
$cKet = $tblTTD->addCell(5860, ['borderSize' => 0, 'borderColor' => 'FFFFFF', 'valign' => 'top']);
$cKet->addText('Keterangan:', $fB, ['alignment' => Jc::START, 'spaceAfter' => 40, 'spaceBefore' => 0]);
foreach ($allJenis as $j) {
    $sing = $jenisMap[$j['id']]['singkatan'];
    $nama = $jenisMap[$j['id']]['name'];
    $cKet->addText($sing . '  =  ' . $nama, $fS, ['alignment' => Jc::START, 'spaceAfter' => 20, 'spaceBefore' => 0]);
}

// Kolom kanan: tanda tangan
$cTTD = $tblTTD->addCell(3500, ['borderSize' => 0, 'borderColor' => 'FFFFFF', 'valign' => 'top']);
$cTTD->addText('Kota, ' . $cetak_pada,  $fN, $pC);
$cTTD->addText('Kepala Sekolah,',        $fN, ['alignment' => Jc::CENTER, 'spaceAfter' => 0, 'spaceBefore' => 20]);
$cTTD->addTextBreak(4);
$cTTD->addText('(________________________________)', $fB,  $pC);
$cTTD->addText('NIP. ........................................', $fN, $pC);

// ── Download ───────────────────────────────────────────────────────────────
$filename = 'laporan_pelanggaran_' . $date_start . '_sd_' . $date_end . '.docx';
$writer   = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filename);
unlink($filename);
exit;
?>