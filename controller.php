<?php
session_start();
require 'vendor/autoload.php';
require 'database.php';

use League\Plates\Engine;

// ============================================
// 🔥 RBAC CONFIGURATION - FINAL VERSION
// ============================================

$page_access = [
    // Public pages
    'login' => ['public'],
    'access_denied' => ['public'],
    'logout' => ['public'],

    // Admin only - Dashboard umum
    'dashboard' => ['admin'],

    // Guru access
    'guru' => ['admin', 'guru'],           // Dashboard guru (guru hanya ini)
    'pelanggaran' => ['admin', 'guru_bk'],    // Guru bisa input pelanggaran
    'pelanggaran_bk' => ['admin', 'guru_bk' ],

    // Siswa access
    'siswa' => ['admin', 'siswa'],         // Dashboard siswa (siswa hanya ini)

    // Admin only - Data management
    'siswa_table' => ['admin', 'guru_bk'],
    'guru_table' => ['admin'],
    'users' => ['admin'],
    'mapel' => ['admin'],
    'kelas' => ['admin'],
    'jenis_pelanggaran' => ['admin', 'guru_bk'],
    'alasan_pelanggaran' => ['admin', 'guru_bk'],
];

// ============================================
// 🔥 HELPER FUNCTIONS
// ============================================

/**
 * Get default page based on user role
 */
function getDefaultPage($role)
{
    return match($role) {
        'siswa' => 'siswa',
        'guru' => 'guru',
        'guru_bk' => 'pelanggaran_bk',
        'admin' => 'dashboard',
        default => 'login'
    };
}

/**
 * Check if user can access specific page
 */
function checkAccess($page, $user_role)
{
    global $page_access;

    // Public page - allow all
    if (in_array('public', $page_access[$page] ?? [])) {
        return true;
    }

    // No session - redirect to login
    if (!isset($_SESSION['role'])) {
        header('Location: ?page=login');
        exit;
    }

    // Check role permission
    $allowed_roles = $page_access[$page] ?? [];
    
    if (!in_array($user_role, $allowed_roles)) {
        header('Location: ?page=login');
        exit;
    }

    return true;
}

/**
 * Redirect to role-appropriate dashboard
 */
function redirectToRoleDashboard($role)
{
    $defaultPage = getDefaultPage($role);
    header("Location: ?page={$defaultPage}");
    exit;
}

// ============================================
// 🔥 MAIN ROUTING LOGIC
// ============================================

$page = $_GET['page'] ?? 'dashboard';
$current_role = $_SESSION['role'] ?? null;

// 1. Handle Logout
if ($page === 'logout') {
    session_destroy();
    header('Location: ?page=login');
    exit;
}

// 2. Handle Already Logged In User Accessing Login Page
if ($page === 'login' && isset($_SESSION['user_id'])) {
    redirectToRoleDashboard($_SESSION['role']);
}

// 3. Handle Default Dashboard Access - Redirect to Role-Specific Page
// Jika siswa/guru akses dashboard, redirect ke halaman mereka
if ($page === 'dashboard' && $current_role) {
    if (in_array($current_role, ['siswa', 'guru'])) {
        redirectToRoleDashboard($current_role);
    }
}

// 4. Handle Direct Access to Role Pages by Wrong Role
// Jika siswa mencoba akses guru page atau sebaliknya
if ($page === 'guru' && $current_role === 'siswa') {
    header('Location: ?page=siswa');
    exit;
}
if ($page === 'siswa' && $current_role === 'guru') {
    header('Location: ?page=guru');
    exit;
}
if ($page === 'siswa' && $current_role === 'guru_bk') {
    header('Location: ?page=pelanggaran_bk');
    exit;
}

// 5. Check Access Permission
checkAccess($page, $current_role ?? '');

// ============================================
// 🔥 VIEW RENDERING
// ============================================

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

// ============================================
// 🔥 PAGE ROUTES
// ============================================

switch ($page) {
    // -------- ADMIN DASHBOARD (Admin Only) --------
    case 'dashboard':
        echo $templates->render('dashboard', [
            'title' => 'Dashboard Admin',
            'user' => $user_data
        ]);
        break;

    // -------- GURU PAGES --------
    case 'guru':
        echo $templates->render('guru::guru', [
            'title' => 'Dashboard Guru',
            'user' => $user_data
        ]);
        break;

    case 'pelanggaran_bk':
        echo $templates->render('pelanggaran_bk', [
            'title' => 'Data Pelanggaran_bk',
            'user' => $user_data
        ]);
        break;

        case 'pelanggaran':
        echo $templates->render('pelanggaran', [
            'title' => 'Data Pelanggaran',
            'user' => $user_data
        ]);
        break;


    // -------- SISWA PAGES --------
    case 'siswa':
        echo $templates->render('siswa::siswa', [
            'title' => 'Dashboard Siswa',
            'user' => $user_data
        ]);
        break;

    // -------- ADMIN ONLY - DATA MANAGEMENT --------
    case 'siswa_table':
        echo $templates->render('siswa::table', [
            'title' => 'Tabel Siswa',
            'user' => $user_data
        ]);
        break;

    case 'guru_table':
        echo $templates->render('guru::table', [
            'title' => 'Data Guru',
            'user' => $user_data
        ]);
        break;

    case 'users':
        echo $templates->render('users', [
            'title' => 'Manajemen Users',
            'user' => $user_data
        ]);
        break;

    case 'kelas':
        echo $templates->render('data_filler::kelas', [
            'title' => 'Data Kelas',
            'user' => $user_data
        ]);
        break;

    case 'mapel':
        echo $templates->render('data_filler::mapels', [
            'title' => 'Data Mapel',
            'user' => $user_data
        ]);
        break;

    case 'jenis_pelanggaran':
        echo $templates->render('data_filler::jenis_pelanggaran', [
            'title' => 'Jenis Pelanggaran',
            'user' => $user_data
        ]);
        break;

    case 'alasan_pelanggaran':
        echo $templates->render('data_filler::alasan_pelanggaran', [
            'title' => 'Alasan Pelanggaran',
            'user' => $user_data
        ]);
        break;

    // -------- AUTH PAGES --------
    case 'login':
        echo $templates->render('login', [
            'title' => 'Login'
        ]);
        break;

    case 'access_denied':
        echo $templates->render('access_denied', [
            'title' => 'Akses Ditolak',
            'user' => $user_data,
            'required_role' => 'Anda tidak memiliki izin untuk mengakses halaman ini.'
        ]);
        break;

    // -------- DEFAULT / 404 --------
    default:
        // Redirect ke halaman default sesuai role
        if (isset($_SESSION['role'])) {
            redirectToRoleDashboard($_SESSION['role']);
        }
        header('Location: ?page=login');
        exit;
}