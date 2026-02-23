<?php
session_start();
require 'vendor/autoload.php';
require 'database.php';

use League\Plates\Engine;

// 🔥 RBAC CONFIGURATION - LENGKAP
$page_access = [
    // Public pages (semua bisa akses)
    'login' => ['public'],
    'access_denied' => ['public'],  // ✅ WAJIB!
    'logout' => ['public'],         // ✅ WAJIB!

    // Dashboard & umum (semua user)
    'dashboard' => ['admin', 'guru', 'siswa'],

    // Guru ke atas
    'pelanggaran' => ['admin', 'guru'],
    'siswa' => ['admin', 'guru'],
    'siswa_table' => ['admin', 'guru'],

    // Admin only
    'guru' => ['admin'],
    'guru_table' => ['admin'],
    'users' => ['admin'],

    // Data filler (admin only)
    'mapel' => ['admin'],
    'kelas' => ['admin'],
    'jenis_pelanggaran' => ['admin'],
    'alasan_pelanggaran' => ['admin'],
];

// 🔥 ACCESS CHECK FUNCTION
function checkAccess($page, $user_role)
{
    global $page_access;

    // Public page - skip check
    if (in_array('public', $page_access[$page] ?? [])) {
        return true;
    }

    // No session = redirect login
    if (!isset($_SESSION['role'])) {
        header('Location: ?page=login');
        exit;
    }

    // Check if user role ada di allowed roles
    $allowed_roles = $page_access[$page] ?? [];
    if (!in_array($user_role, $allowed_roles)) {
        header('Location: ?page=access_denied');
        exit;
    }

    return true;
}

$page = $_GET['page'] ?? 'dashboard';

// 🔥 URUTAN BENAR: SPECIAL PAGES DULU
if ($page === 'logout') {
    session_destroy();
    header('Location: ?page=login');
    exit;
}

if ($page === 'login' && isset($_SESSION['user_id'])) {
    header('Location: ?page=dashboard');
    exit;
}

// 🔥 BARU CHECK ACCESS
checkAccess($page, $_SESSION['role'] ?? '');

$templates = new Engine('./views');
$templates->addFolder('layouts', './views/layout');
$templates->addFolder('guru', './views/guru');
$templates->addFolder('data_filler', './views/data_filler');
$templates->addFolder('siswa', './views/siswa');

$user_data = [
    'name' => $_SESSION['user_name'] ?? 'Guest',
    'role' => $_SESSION['role'] ?? '',
    'is_logged_in' => isset($_SESSION['user_id'])
];

switch ($page) {
    case 'dashboard':
        echo $templates->render('dashboard', [
            'title' => 'Dashboard',
            'user' => $user_data
        ]);
        break;

    case 'pelanggaran':
        echo $templates->render('pelanggaran', ['title' => 'Pelanggaran', 'user' => $user_data]);
        break;

    case 'login':
        echo $templates->render('login', ['title' => 'Login']);
        break;

    case 'mapel':
        echo $templates->render('data_filler::mapels', ['title' => 'Data Mapel', 'user' => $user_data]);
        break;

    case 'kelas':
        echo $templates->render('data_filler::kelas', ['title' => 'Data Kelas', 'user' => $user_data]);
        break;

    case 'jenis_pelanggaran':
        echo $templates->render('data_filler::jenis_pelanggaran', ['title' => 'Jenis Pelanggaran', 'user' => $user_data]);
        break;

    case 'alasan_pelanggaran':
        echo $templates->render('data_filler::alasan_pelanggaran', ['title' => 'Alasan Pelanggaran', 'user' => $user_data]);
        break;

    case 'siswa':
        echo $templates->render('siswa::siswa', ['title' => 'Siswa', 'user' => $user_data]);
        break;

    case 'siswa_table':
        echo $templates->render('siswa::table', ['title' => 'Tabel Siswa', 'user' => $user_data]);
        break;

    case 'guru':
        echo $templates->render('guru::guru', ['title' => 'Guru', 'user' => $user_data]);
        break;

    case 'guru_table':
        echo $templates->render('guru::table', ['title' => 'Data Guru', 'user' => $user_data]);
        break;

    case 'users':
        echo $templates->render('users', ['title' => 'Users', 'user' => $user_data]);
        break;

    case 'access_denied':
        echo $templates->render('access_denied', [
            'title' => 'Access Denied',
            'user' => $user_data,
            'page' => $page
        ]);
        break;

    default:
        echo $templates->render('dashboard', ['title' => 'Dashboard', 'user' => $user_data]);
        break;
}
?>