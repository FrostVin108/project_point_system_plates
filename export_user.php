<?php
require 'vendor/autoload.php';
include 'database.php';  // Your PDO connection

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;
use League\Plates\Engine;

$id = $_GET['id'] ?? 1;
$date = $_GET['date'] ?? date('Y-m-d');  // 🔥 From modal or today's date

// Fetch single user
$stmt = $pdo->prepare("SELECT id, name, role FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_OBJ);

if (!$user) {
    die("User not found");
}

// ✅ PERFECT HTML TEMPLATE with DATE
$templates = new Engine('templates');
$html = $templates->render('user_report', ['user' => $user, 'reportDate' => $date]);

$phpWord = new PhpWord();

// 🔥 BEAUTIFUL SECTION WITH MARGINS
$section = $phpWord->addSection([
    'marginTop' => 1200,
    'marginBottom' => 1200,
    'marginLeft' => 1200,
    'marginRight' => 1200
]);

// 🔥 ADD LOGO IMAGE (put logoti.jpg in project root)
// if (file_exists('logoti.jpg')) {
//     $section->addImage('logoti.jpg', [
//         'width' => 100,
//         'height' => 100,
//         'alignment' => 'center',
//         'marginTop' => 200,
//         'marginBottom' => 300
//     ]);
// }

// ✅ CORRECT CONSTANTS untuk text wrapping + top center
if (file_exists('logo_sekolah.jpg')) {
    $section->addImage('logo_sekolah.jpg', [
        // 'width' => 120,
        'height' => 120,
        'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
        'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_CENTER,
        'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_VERTICAL_TOP,
        'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
        'posVerticalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
        'margin' => 2000,
        'wrappingStyle' => 'square',
        // 'zIndex' => -1
    ]);
}


// 🔥 ADD HTML CONTENT WITH FULL STYLING SUPPORT + DATE
Html::addHtml($section, $html);

// 🔥 SAVE & DOWNLOAD
$writer = IOFactory::createWriter($phpWord, 'Word2007');
$filename = "user-{$user->id}-" . str_replace(' ', '_', $user->name) . "-{$date}.docx";
$writer->save($filename);

header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filename);
unlink($filename);
exit;
?>
