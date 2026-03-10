<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title ?? 'Vin web') ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidenav {
            width: 250px;
            height: 100vh;
            background-color: #333;
            color: white;
            padding: 20px;
            box-sizing: border-box;

            /* 🔥 FIXED NAVBAR - tidak ikut scroll */
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidenav h2 {
            margin-top: 0;
            color: #fff;
        }

        .sidenav a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 0;
            border-bottom: 1px solid #555;
        }

        .sidenav a:hover {
            background-color: #575757;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-btn {
            background: none;
            border: none;
            color: white;
            padding: 10px 0;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-family: inherit;
            font-size: inherit;
        }

        .dropdown-btn:hover {
            background-color: #575757;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content {
            display: none;
            background-color: #444;
            padding-left: 20px;
        }

        .dropdown-content a {
            padding: 8px 0;
            border-bottom: none;
        }

        .dropdown-content a:hover {
            background-color: #666;
        }

        main {
            flex: 1;
            /* 🔥 Dorong konten ke kanan supaya tidak tertutup sidenav */
            margin-left: 250px;
        }

        .container {
            margin: 20px;
            padding: 20px;
            border-radius: 15px;
            background-color: #f4f4f4;
            color: #333;
            min-height: 70vh;
        }

        .btn-word {
            background: #007bff;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
            display: inline-block;
        }

        .btn-word:hover {
            background: #0056b3;
            color: white;
        }

        /* 🔥 USER INFO STYLE */
        .user-info {
            background-color: #444;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .user-role {
            color: #ffd700;
            font-weight: bold;
        }
    </style>

    <!-- Font Awesome 6 FREE CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="sidenav">
        <h2><i class="fas fa-school me-2"></i>Vin Web</h2>
        
        <!-- 🔥 SESSION DETECTION - LOGIN/LOGOUT -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- ✅ USER SUDAH LOGIN -->
            <div class="user-info">
                <div><i class="fas fa-user-circle me-2"></i><?= $_SESSION['user_name'] ?></div>
                <div class="user-role"><?= $_SESSION['role'] ?></div>
                <a href="?page=logout" class="btn-word" style="font-size: 11px;">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
            </div>
        <?php else: ?>
            <!-- ❌ BELUM LOGIN -->
            <div style="padding: 15px; background-color: #444; border-radius: 8px; margin-bottom: 20px;">
                <div class="text-center">
                    <i class="fas fa-user-slash fa-2x text-warning mb-2"></i>
                    <div>Belum Login</div>
                    <a href="?page=login" class="btn-word mt-2">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- 🔥 MENU NAVIGATION - ROLE BASED -->
        <?php if (isset($_SESSION['role'])): ?>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <!-- ADMIN MENU FULL -->
                <a href="?page=dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="?page=pelanggaran"><i class="fas fa-exclamation-triangle me-2"></i>Pelanggaran</a>
                
                <div class="dropdown">
                    <button class="dropdown-btn"><i class="fas fa-database me-2"></i>Data Filler</button>
                    <div class="dropdown-content">
                        <a href="?page=kelas">Kelas</a>
                        <a href="?page=jenis_pelanggaran">Jenis Pelanggaran</a>
                        <a href="?page=alasan_pelanggaran">Alasan Pelanggaran</a>
                        <a href="?page=mapel">Mapel</a>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="dropdown-btn"><i class="fas fa-users me-2"></i>Siswa</button>
                    <div class="dropdown-content">
                        <a href="?page=siswa">Dashboard</a>
                        <a href="?page=siswa_table">Table</a>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="dropdown-btn"><i class="fas fa-chalkboard-teacher me-2"></i>Guru</button>
                    <div class="dropdown-content">
                        <a href="?page=guru">Dashboard</a>
                        <a href="?page=guru_table">Table</a>
                    </div>
                </div>

                <a href="?page=users" class="text-warning fw-bold">
                    <i class="fas fa-user-shield me-2"></i>Users (Admin)
                </a>
            <?php elseif ($_SESSION['role'] === 'guru'): ?>
                <!-- GURU MENU LIMITED -->
                <a href="?page=dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="?page=pelanggaran"><i class="fas fa-exclamation-triangle me-2"></i>Pelanggaran</a>
                
                <div class="dropdown">
                    <button class="dropdown-btn"><i class="fas fa-users me-2"></i>Siswa</button>
                    <div class="dropdown-content">
                        <a href="?page=siswa">Dashboard</a>
                        <a href="?page=siswa_table">Table</a>
                    </div>
                </div>
            <?php else: ?>
                <!-- SISWA MENU MINIMAL -->
                <a href="?page=dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
            <?php endif; ?>
        <?php else: ?>
            <!-- GUEST MENU -->
            <a href="?page=dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
        <?php endif; ?>
    </div>

    <main>
        <div class="container">
            <?= $this->section('main') ?>
        </div>
    </main>
</body>
</html>