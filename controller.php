<?php
require 'vendor/autoload.php';
require 'database.php';

use League\Plates\Engine;

$templates = new Engine('./views');
$templates->addFolder('layouts', './views/layout');
$templates->addFolder('guru', './views/guru');           // ✅ GURU
$templates->addFolder('data_filler', './views/data_filler');
$templates->addFolder('siswa', './views/siswa');

$page = $_GET['page'] ?? 'dashboard';

switch ($page) {
    case 'dashboard':
        echo $templates->render('dashboard', ['title' => 'Dashboard']);
        break;
    case 'login':
        echo $templates->render('login', ['title' => 'Login']);
        break;
    case 'mapel':
        echo $templates->render('data_filler::mapels', ['title' => 'Data Mapel']);
        break;
    case 'kelas':
        echo $templates->render('data_filler::kelas', ['title' => 'Data Kelas']);
        break;
    case 'jenis_pelanggaran':
        echo $templates->render('data_filler::jenis_pelanggaran', ['title' => 'Data jenis pelanggaran']);
        break;
    case 'siswa':
        echo $templates->render('siswa::siswa', ['title' => 'Siswa']);
        break;
    case 'siswa_table':
        echo $templates->render('siswa::table', ['title' => 'Tabel Siswa']);
        break;
    case 'guru':
        echo $templates->render('guru::guru', ['title' => 'guru']);
        break;
    case 'guru_table':
        echo $templates->render('guru::table', ['title' => 'Data Guru']);  // ✅ FIXED TITLE
        break;
    case 'users':
        echo $templates->render('users', ['title' => 'users']);
        break;
    default:
        echo $templates->render('dashboard');
        break;
}
?>
