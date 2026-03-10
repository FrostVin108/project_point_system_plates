<?php
require 'vendor/autoload.php';
include 'database.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

$id   = $_GET['id']   ?? 1;
$date = $_GET['date'] ?? date('Y-m-d');

$stmt = $pdo->prepare("SELECT id, name, role FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_OBJ);

if (!$user) die("User not found");

// ── Data jenis (hardcode untuk testing) ───────────────────────────────────
$jenisList   = ['A', 'B', 'C', 'D', 'E'];
$jumlahJenis = count($jenisList);

// ── Setup dokumen ──────────────────────────────────────────────────────────
$phpWord = new PhpWord();
$section = $phpWord->addSection([
    'marginTop'    => 1200,
    'marginBottom' => 1200,
    'marginLeft'   => 1200,
    'marginRight'  => 1200,
]);

// ── Font & paragraph styles ────────────────────────────────────────────────
$fN  = ['name' => 'Arial', 'size' => 10];
$fB  = ['name' => 'Arial', 'size' => 10, 'bold' => true];
$fT  = ['name' => 'Arial', 'size' => 13, 'bold' => true];
$fS  = ['name' => 'Arial', 'size' => 9];
$fSB = ['name' => 'Arial', 'size' => 9,  'bold' => true];
$fIt = ['name' => 'Arial', 'size' => 10, 'italic' => true];
$pC  = ['alignment' => Jc::CENTER, 'spaceAfter' => 0, 'spaceBefore' => 0];
$pL  = ['alignment' => Jc::START,  'spaceAfter' => 0, 'spaceBefore' => 0];
$pR  = ['alignment' => Jc::END,    'spaceAfter' => 0, 'spaceBefore' => 0];

// ── Judul ──────────────────────────────────────────────────────────────────
$section->addText('User Report', $fT, ['alignment' => Jc::CENTER, 'spaceAfter' => 40, 'spaceBefore' => 0]);
$section->addText('Report Date: ' . $date, $fIt, ['alignment' => Jc::CENTER, 'spaceAfter' => 120, 'spaceBefore' => 0]);

// ── Cell style: all border ─────────────────────────────────────────────────
$border = [
    'borderTopSize'    => 6, 'borderTopColor'    => '000000',
    'borderBottomSize' => 6, 'borderBottomColor' => '000000',
    'borderLeftSize'   => 6, 'borderLeftColor'   => '000000',
    'borderRightSize'  => 6, 'borderRightColor'  => '000000',
    'valign'           => 'center',
];

// ── Lebar kolom (dalam DXA, 1cm ≈ 567 DXA) ────────────────────────────────
// 100px ≈ 1440 | 260px ≈ 3744 | 120px ≈ 1728 | 30px ≈ 432 | 170px ≈ 2448
$wTgl  = 1040;
$wNama = 3584;
$wKls  = 1578;
$wJen  = 432;  // per kolom jenis
$wKet  = 2448;
$wJenTotal = $wJen * $jumlahJenis;

// ── Tabel ──────────────────────────────────────────────────────────────────
$table = $section->addTable([
    'borderSize' => 0,
    'cellMargin' => 60,
    'layout'     => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,
]);

// ── HEADER BARIS 1 ──────────────────────────────────────────────────────────
$table->addRow(200);
// TGL — rowspan 2
$table->addCell($wTgl,     array_merge($border, ['vMerge' => 'restart']))->addText('TGL',              $fSB, $pC);
// NAMA — rowspan 2
$table->addCell($wNama,    array_merge($border, ['vMerge' => 'restart']))->addText('NAMA',             $fSB, $pC);
// KELAS — rowspan 2
$table->addCell($wKls,     array_merge($border, ['vMerge' => 'restart']))->addText('KELAS',            $fSB, $pC);
// JENIS PELANGGARAN — colspan
$table->addCell($wJenTotal,array_merge($border, ['gridSpan' => $jumlahJenis]))->addText('JENIS PELANGGARAN', $fSB, $pC);
// KETERANGAN — rowspan 2
$table->addCell($wKet,     array_merge($border, ['vMerge' => 'restart']))->addText('KETERANGAN',       $fSB, $pC);

// ── HEADER BARIS 2: sub-kolom jenis ─────────────────────────────────────────
$table->addRow(200);
$table->addCell($wTgl,  array_merge($border, ['vMerge' => 'continue']));
$table->addCell($wNama, array_merge($border, ['vMerge' => 'continue']));
$table->addCell($wKls,  array_merge($border, ['vMerge' => 'continue']));
foreach ($jenisList as $j) {
    $table->addCell($wJen, $border)->addText($j, $fSB, $pC);
}
$table->addCell($wKet, array_merge($border, ['vMerge' => 'continue']));

// ── BARIS DATA ───────────────────────────────────────────────────────────────
$table->addRow(200);
$table->addCell($wTgl,  $border)->addText(date('d/m/Y'),  $fS, $pC);
$table->addCell($wNama, $border)->addText($user->name,    $fS, $pL);
$table->addCell($wKls,  $border)->addText($user->role,    $fS, $pC);
foreach ($jenisList as $i => $j) {
    $table->addCell($wJen, $border)->addText($i === 0 ? "\u{2713}" : '', $fS, $pC);
}
$table->addCell($wKet, $border)->addText('Test keterangan user ID ' . $user->id, $fS, $pL);

// ── Total ──────────────────────────────────────────────────────────────────
$section->addText('Total: 1 data', $fS, ['alignment' => Jc::END, 'spaceBefore' => 80, 'spaceAfter' => 0]);

// ── Download ───────────────────────────────────────────────────────────────
$filename = "user_test_{$user->id}_{$date}.docx";
$writer   = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filename);
unlink($filename);
exit;
?>