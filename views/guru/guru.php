<?php $this->layout('layouts::app', ['title' => 'Dashboard Guru - Pelanggaran']) ?>

<?php $this->start('main') ?>

<?php
// Hapus session_start() yang langsung, ganti dengan pengecekan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'database.php';

// Ambil data guru dari session
$logged_in_guru_id = $_SESSION['guru_id'] ?? 1;
$logged_in_guru_name = $_SESSION['guru_name'] ?? 'Guru Belum Login';

// Ambil data dari database
$stmt = $pdo->query("SELECT id, name, nis FROM siswas ORDER BY name ASC");
$siswas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT id, name, point FROM jenis_pelanggarans ORDER BY name ASC");
$jenis_pelanggarans = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil data pelanggaran bulan ini
$current_month_start = date('Y-m-01');
$current_month_end = date('Y-m-t');

$stmt = $pdo->prepare("
    SELECT 
        p.id,
        p.date,
        p.total_point,
        s.name as siswa_name,
        s.nis as siswa_nis,
        jp.name as jenis_name,
        ap.detail as alasan_detail,
        g.name as guru_name
    FROM pelanggarans p
    LEFT JOIN siswas s ON p.id_siswa = s.id
    LEFT JOIN jenis_pelanggarans jp ON p.id_jenis_pelanggaran = jp.id
    LEFT JOIN alasan_pelanggarans ap ON p.id_alasan_pelanggaran = ap.id
    LEFT JOIN gurus g ON p.id_guru = g.id
    WHERE DATE(p.date) BETWEEN ? AND ?
    ORDER BY p.date DESC, p.id DESC
    LIMIT 50
");
$stmt->execute([$current_month_start, $current_month_end]);
$pelanggarans = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Hitung statistik
$total_pelanggaran = count($pelanggarans);
$total_point_bulan = array_sum(array_column($pelanggarans, 'total_point'));
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
        min-height: 100vh;
        color: #ffffff;
        overflow-x: hidden;
    }

    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 24px;
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 24px;
    }

    @media (max-width: 1024px) {
        .dashboard-container {
            grid-template-columns: 1fr;
        }
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 24px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        overflow: hidden;
    }

    .dashboard-header {
        grid-column: 1 / -1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 28px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-title {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .header-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #dc2626, #eab308);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
        box-shadow: 0 8px 24px rgba(220, 38, 38, 0.3);
    }

    .header-text h1 {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 6px;
        background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.7) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .header-text p {
        color: rgba(255, 255, 255, 0.5);
        font-size: 14px;
    }

    .header-stats {
        display: flex;
        gap: 16px;
    }

    .stat-pill {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 16px 24px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-icon.blue {
        background: rgba(59, 130, 246, 0.2);
        color: #60a5fa;
    }

    .stat-icon.red {
        background: rgba(220, 38, 38, 0.2);
        color: #f87171;
    }

    .stat-content {
        display: flex;
        flex-direction: column;
    }

    .stat-value {
        font-weight: 800;
        font-size: 24px;
        color: white;
    }

    .stat-label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.5);
        margin-top: 4px;
    }

    .data-section {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .filter-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 24px;
        background: rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        flex-wrap: wrap;
        gap: 16px;
    }

    .filter-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 700;
        font-size: 16px;
        color: white;
    }

    .filter-title i {
        color: #60a5fa;
        font-size: 18px;
    }

    .filter-tabs {
        display: flex;
        gap: 8px;
        background: rgba(0, 0, 0, 0.2);
        padding: 4px;
        border-radius: 12px;
    }

    .filter-tab {
        padding: 10px 18px;
        border-radius: 10px;
        border: none;
        background: transparent;
        color: rgba(255, 255, 255, 0.7);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-tab:hover {
        color: white;
        background: rgba(255, 255, 255, 0.05);
    }

    .filter-tab.active {
        background: linear-gradient(135deg, #3b82f6, rgba(59, 130, 246, 0.8));
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .data-scroll {
        max-height: calc(100vh - 300px);
        overflow-y: auto;
        padding: 24px;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
    }

    .data-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .data-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .data-scroll::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }

    .violation-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }

    @media (max-width: 640px) {
        .violation-grid {
            grid-template-columns: 1fr;
        }
    }

    .violation-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .violation-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #dc2626, #eab308);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .violation-card:hover {
        transform: translateY(-4px) scale(1.02);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .violation-card:hover::before {
        opacity: 1;
    }

    .violation-date {
        position: absolute;
        top: 16px;
        left: 16px;
        background: rgba(0, 0, 0, 0.3);
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        gap: 6px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .violation-point {
        position: absolute;
        top: 16px;
        right: 16px;
        background: linear-gradient(135deg, #dc2626, #eab308);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        color: white;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    .violation-content {
        margin-top: 55px;
    }

    .student-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .student-avatar {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        color: white;
        flex-shrink: 0;
    }

    .student-info h4 {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 2px;
        color: white;
    }

    .student-info span {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.5);
    }

    .violation-type {
        background: rgba(220, 38, 38, 0.15);
        border: 1px solid rgba(220, 38, 38, 0.3);
        color: #fca5a5;
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .violation-reason {
        background: rgba(234, 179, 8, 0.1);
        border: 1px solid rgba(234, 179, 8, 0.2);
        color: #fcd34d;
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 12px;
        line-height: 1.5;
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }

    .violation-reason i {
        margin-top: 2px;
        font-size: 11px;
        flex-shrink: 0;
    }

    .violation-footer {
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.5);
    }

    .teacher-badge {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .teacher-badge i {
        color: #059669;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: rgba(255, 255, 255, 0.5);
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 18px;
        margin-bottom: 8px;
        color: white;
        font-weight: 600;
    }

    .form-section {
        position: sticky;
        top: 24px;
        height: fit-content;
    }

    @media (max-width: 1024px) {
        .form-section {
            position: relative;
            top: 0;
        }
    }

    .form-header {
        padding: 24px;
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(239, 68, 68, 0.05));
        border-bottom: 1px solid rgba(220, 38, 38, 0.2);
    }

    .form-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 18px;
        font-weight: 700;
        color: white;
    }

    .form-title i {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #dc2626, #eab308);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: white;
    }

    .form-subtitle {
        margin-top: 8px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.5);
        margin-left: 52px;
    }

    .form-body {
        padding: 24px;
    }

    .teacher-box {
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.15), rgba(52, 211, 153, 0.05));
        border: 1px solid rgba(5, 150, 105, 0.3);
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .teacher-avatar {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: white;
        flex-shrink: 0;
    }

    .teacher-details h4 {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 4px;
        color: white;
    }

    .teacher-details span {
        font-size: 12px;
        color: #6ee7b7;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        color: rgba(255, 255, 255, 0.7);
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 4px;
    }

    .form-select {
        width: 100%;
        padding: 14px 16px;
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        color: white;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23ffffff' fill-opacity='0.5' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        cursor: pointer;
    }

    .form-select:focus {
        outline: none;
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-select:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .form-select option {
        background: #1e293b;
        color: white;
        padding: 10px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    @media (max-width: 400px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .point-display {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        margin-bottom: 24px;
    }

    .point-label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .point-value {
        font-size: 36px;
        font-weight: 800;
        background: linear-gradient(135deg, #dc2626, #f97316);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1;
    }

    .btn-submit {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #dc2626, #f97316);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        color: white;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 8px 24px rgba(220, 38, 38, 0.3);
    }

    .btn-submit:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(220, 38, 38, 0.4);
    }

    .btn-submit:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-submit.loading {
        pointer-events: none;
    }

    .toast-container {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 10000;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .toast {
        background: rgba(20, 30, 48, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-left: 4px solid #059669;
        border-radius: 16px;
        padding: 16px 20px;
        min-width: 300px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        animation: slideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .toast.error {
        border-left-color: #dc2626;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100%) scale(0.9);
        }

        to {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
    }

    .toast-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        background: rgba(5, 150, 105, 0.2);
        color: #34d399;
    }

    .toast.error .toast-icon {
        background: rgba(220, 38, 38, 0.2);
        color: #f87171;
    }

    .toast-content {
        flex: 1;
    }

    .toast-title {
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 2px;
        color: white;
    }

    .toast-message {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.5);
    }

    .skeleton {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.05) 25%, rgba(255, 255, 255, 0.1) 50%, rgba(255, 255, 255, 0.05) 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 12px;
    }

    @keyframes shimmer {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }

    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        .header-stats {
            width: 100%;
            justify-content: center;
        }

        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-tabs {
            justify-content: center;
        }

        .data-scroll {
            max-height: none;
        }
    }
</style>
</head>

<body>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <div class="dashboard-container">
        <!-- Header -->
        <div class="glass-card dashboard-header">
            <div class="header-title">
                <div class="header-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="header-text">
                    <h1>Dashboard Guru</h1>
                    <p>Sistem Monitoring & Pelaporan Pelanggaran Siswa</p>
                </div>
            </div>
            <div class="header-stats">
                <div class="stat-pill">
                    <div class="stat-icon blue">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value" id="statTotal"><?= $total_pelanggaran ?></span>
                        <span class="stat-label">Total Pelanggaran</span>
                    </div>
                </div>
                <!-- <div class="stat-pill">
                    <div class="stat-icon red">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value" id="statPoints"><?= $total_point_bulan ?></span>
                        <span class="stat-label">Total Poin</span>
                    </div>
                </div> -->
            </div>
        </div>

        <!-- Left Column: Data Container -->
        <div class="data-section">
            <div class="glass-card">
                <div class="filter-bar">
                    <div class="filter-title">
                        <i class="fas fa-list-alt"></i>
                        <span>Riwayat Pelanggaran</span>
                    </div>
                    <div class="filter-tabs">
                        <button class="filter-tab active" onclick="setFilter('month', this)">
                            <i class="fas fa-calendar"></i> Bulan Ini
                        </button>
                        <button class="filter-tab" onclick="setFilter('today', this)">
                            <i class="fas fa-sun"></i> Hari Ini
                        </button>
                    </div>
                </div>

                <div class="data-scroll" id="dataContainer">
                    <?php if (empty($pelanggarans)): ?>
                        <div class="empty-state">
                            <i class="fas fa-clipboard-check"></i>
                            <h3>Tidak Ada Data</h3>
                            <p>Belum ada pelanggaran tercatat untuk periode ini</p>
                        </div>
                    <?php else: ?>
                        <div class="violation-grid">
                            <?php
                            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                            foreach ($pelanggarans as $item):
                                $date = new DateTime($item['date']);
                                $dateStr = $date->format('d') . ' ' . $months[(int)$date->format('m') - 1] . ' ' . $date->format('Y');
                                $initial = strtoupper(substr($item['siswa_name'] ?? 'S', 0, 1));
                            ?>
                                <div class="violation-card">
                                    <div class="violation-date">
                                        <i class="fas fa-calendar-day"></i>
                                        <?= $dateStr ?>
                                    </div>
                                    <div class="violation-point">
                                        <?= $item['total_point'] ?? 0 ?> PT
                                    </div>

                                    <div class="violation-content">
                                        <div class="student-row">
                                            <div class="student-avatar"><?= $initial ?></div>
                                            <div class="student-info">
                                                <h4><?= htmlspecialchars($item['siswa_name'] ?? '-') ?></h4>
                                                <span>NIS: <?= $item['siswa_nis'] ?? '-' ?></span>
                                            </div>
                                        </div>

                                        <div class="violation-type">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <?= htmlspecialchars($item['jenis_name'] ?? '-') ?>
                                        </div>

                                        <div class="violation-reason">
                                            <i class="fas fa-quote-left"></i>
                                            <?= htmlspecialchars($item['alasan_detail'] ?? '-') ?>
                                        </div>

                                        <div class="violation-footer">
                                            <div class="teacher-badge">
                                                <i class="fas fa-chalkboard-teacher"></i>
                                                <span>Oleh: <?= htmlspecialchars($item['guru_name'] ?? '-') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Column: Form Container -->
        <div class="form-section">
            <div class="glass-card">
                <div class="form-header">
                    <div class="form-title">
                        <i class="fas fa-plus-circle"></i>
                        <span>Laporkan Pelanggaran</span>
                    </div>
                    <div class="form-subtitle">Isi form untuk mencatat pelanggaran baru</div>
                </div>

                <div class="form-body">
                    <!-- Auto-detected Teacher -->
                    <div class="teacher-box">
                        <div class="teacher-avatar">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="teacher-details">
                            <h4><?= htmlspecialchars($logged_in_guru_name) ?></h4>
                            <span><i class="fas fa-check-circle"></i> Terdeteksi Otomatis</span>
                        </div>
                    </div>

                    <form id="pelanggaranForm">
                        <input type="hidden" id="id_guru" value="<?= $logged_in_guru_id ?>">

                        <div class="form-group">
                            <label class="form-label">Siswa <span class="required">*</span></label>
                            <select class="form-select" id="id_siswa" required>
                                <option value="">Pilih Siswa</option>
                                <?php foreach ($siswas as $siswa): ?>
                                    <option value="<?= $siswa['id'] ?>" data-nis="<?= $siswa['nis'] ?>">
                                        <?= htmlspecialchars($siswa['name']) ?> (<?= $siswa['nis'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Jenis <span class="required">*</span></label>
                                <select class="form-select" id="id_jenis_pelanggaran" required>
                                    <option value="">Pilih</option>
                                    <?php foreach ($jenis_pelanggarans as $jenis): ?>
                                        <option value="<?= $jenis['id'] ?>" data-point="<?= $jenis['point'] ?>">
                                            <?= htmlspecialchars($jenis['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alasan <span class="required">*</span></label>
                                <select class="form-select" id="id_alasan_pelanggaran" required disabled>
                                    <option value="">Pilih Jenis</option>
                                </select>
                            </div>
                        </div>

                        <div class="point-display">
                            <div class="point-label">Point Pelanggaran</div>
                            <div class="point-value" id="displayPoint">0</div>
                        </div>

                        <button type="submit" class="btn-submit" id="btnSubmit" disabled>
                            <i class="fas fa-save"></i>
                            <span>Simpan Pelanggaran</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    // State management
    let currentFilter = 'month';
    const guruId = document.getElementById('id_guru').value;

    // Filter functionality
    function setFilter(type, btn) {
        currentFilter = type;

        // Update UI
        document.querySelectorAll('.filter-tab').forEach(tab => tab.classList.remove('active'));
        btn.classList.add('active');

        // Load data dengan delay kecil untuk memastikan DOM ready
        setTimeout(() => loadData(), 100);
    }

    async function loadData() {
        const container = document.getElementById('dataContainer');

        // Show loading skeleton
        container.innerHTML = `
            <div class="violation-grid">
                ${Array(6).fill(0).map(() => `
                    <div class="violation-card" style="height: 220px;">
                        <div class="skeleton" style="width: 100px; height: 24px; position: absolute; top: 16px; left: 16px;"></div>
                        <div class="skeleton" style="width: 60px; height: 24px; position: absolute; top: 16px; right: 16px;"></div>
                        <div class="skeleton" style="width: 100%; height: 60px; margin-top: 55px;"></div>
                        <div class="skeleton" style="width: 100%; height: 40px; margin-top: 10px;"></div>
                    </div>
                `).join('')}
            </div>
        `;

        try {
            // TAMBAH: Timestamp untuk bust cache
            const timestamp = new Date().getTime();
            const response = await fetch(`action_dashboard_guru.php?action=get_data&filter=${currentFilter}&_=${timestamp}`, {
                method: 'GET',
                headers: {
                    'Cache-Control': 'no-cache',
                    'Pragma': 'no-cache'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();

            if (!data.success) {
                throw new Error(data.message || 'Gagal memuat data');
            }

            // Update stats
            document.getElementById('statTotal').textContent = data.total;
            const statPoints = document.getElementById('statPoints');
            if (statPoints) statPoints.textContent = data.total_points;

            // Render cards
            container.innerHTML = renderCards(data.items);

        } catch (error) {
            console.error('LoadData Error:', error);
            showToast('Gagal memuat data: ' + error.message, 'error');
            container.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h3>Terjadi Kesalahan</h3>
                    <p>${error.message}</p>
                </div>
            `;
        }
    }

    function renderCards(items) {
        if (!items || items.length === 0) {
            return `
                <div class="empty-state">
                    <i class="fas fa-clipboard-check"></i>
                    <h3>Tidak Ada Data</h3>
                    <p>Belum ada pelanggaran tercatat untuk periode ini</p>
                </div>
            `;
        }

        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        return `
            <div class="violation-grid">
                ${items.map(item => {
                    const date = new Date(item.date);
                    const dateStr = `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
                    const initial = (item.siswa_name || 'S').charAt(0).toUpperCase();
                    
                    return `
                        <div class="violation-card">
                            <div class="violation-date">
                                <i class="fas fa-calendar-day"></i>
                                ${dateStr}
                            </div>
                            <div class="violation-point">
                                ${item.total_point} PT
                            </div>
                            
                            <div class="violation-content">
                                <div class="student-row">
                                    <div class="student-avatar">${initial}</div>
                                    <div class="student-info">
                                        <h4>${escapeHtml(item.siswa_name || '-')}</h4>
                                        <span>NIS: ${item.siswa_nis || '-'}</span>
                                    </div>
                                </div>
                                
                                <div class="violation-type">
                                    <i class="fas fa-exclamation-circle"></i>
                                    ${escapeHtml(item.jenis_name || '-')}
                                </div>
                                
                                <div class="violation-reason">
                                    <i class="fas fa-quote-left"></i>
                                    ${escapeHtml(item.alasan_detail || '-')}
                                </div>
                                
                                <div class="violation-footer">
                                    <div class="teacher-badge">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        <span>Oleh: ${escapeHtml(item.guru_name || '-')}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('')}
            </div>
        `;
    }

    function escapeHtml(text) {
        if (!text) return '-';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Form handling - Jenis Pelanggaran change
    document.getElementById('id_jenis_pelanggaran').addEventListener('change', async function() {
        const jenisId = this.value;
        const alasanSelect = document.getElementById('id_alasan_pelanggaran');
        const pointDisplay = document.getElementById('displayPoint');

        if (!jenisId) {
            alasanSelect.innerHTML = '<option value="">Pilih Jenis</option>';
            alasanSelect.disabled = true;
            pointDisplay.textContent = '0';
            validateForm();
            return;
        }

        // Get point from selected option
        const selectedOption = this.options[this.selectedIndex];
        const point = selectedOption.dataset.point || 0;
        pointDisplay.textContent = point;

        // Load alasan
        try {
            const timestamp = new Date().getTime();
            const response = await fetch(`action_dashboard_guru.php?action=alasan&id_jenis=${jenisId}&_=${timestamp}`);
            const data = await response.json();

            alasanSelect.innerHTML = '<option value="">Pilih Alasan</option>';
            if (Array.isArray(data)) {
                data.forEach(alasan => {
                    alasanSelect.innerHTML += `<option value="${alasan.id}">${escapeHtml(alasan.detail)}</option>`;
                });
            }
            alasanSelect.disabled = false;
        } catch (error) {
            showToast('Gagal memuat alasan', 'error');
        }

        validateForm();
    });

    // Form validation
    function validateForm() {
        const siswa = document.getElementById('id_siswa').value;
        const jenis = document.getElementById('id_jenis_pelanggaran').value;
        const alasan = document.getElementById('id_alasan_pelanggaran').value;

        const isValid = siswa && jenis && alasan;
        document.getElementById('btnSubmit').disabled = !isValid;
    }

    document.getElementById('id_siswa').addEventListener('change', validateForm);
    document.getElementById('id_alasan_pelanggaran').addEventListener('change', validateForm);

    // Form submission - FIXED VERSION
    document.getElementById('pelanggaranForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const btn = document.getElementById('btnSubmit');
        const originalContent = btn.innerHTML;

        btn.disabled = true;
        btn.classList.add('loading');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Menyimpan...</span>';

        const formData = {
            action: 'add',
            id_siswa: document.getElementById('id_siswa').value,
            id_guru: guruId,
            id_jenis_pelanggaran: document.getElementById('id_jenis_pelanggaran').value,
            id_alasan_pelanggaran: document.getElementById('id_alasan_pelanggaran').value,
            total_point: document.getElementById('displayPoint').textContent
        };

        try {
            const response = await fetch('action_dashboard_guru.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Cache-Control': 'no-cache'
                },
                body: new URLSearchParams(formData)
            });

            const result = await response.json();

            if (result.success) {
                showToast('Pelanggaran berhasil dicatat!', 'success');
                
                // Reset form
                this.reset();
                document.getElementById('id_alasan_pelanggaran').innerHTML = '<option value="">Pilih Jenis</option>';
                document.getElementById('id_alasan_pelanggaran').disabled = true;
                document.getElementById('displayPoint').textContent = '0';
                
                // FIX UTAMA: Tunggu sebentar lalu reload data 2x untuk memastikan
                setTimeout(() => {
                    loadData();
                    // Double refresh untuk memastikan data muncul
                    setTimeout(() => loadData(), 500);
                }, 300);
                
            } else {
                showToast(result.message || 'Gagal menyimpan', 'error');
            }

        } catch (error) {
            console.error('Submit Error:', error);
            showToast('Terjadi kesalahan server', 'error');
        } finally {
            btn.disabled = false;
            btn.classList.remove('loading');
            btn.innerHTML = originalContent;
        }
    });

    // Toast notification
    function showToast(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;

        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        const title = type === 'success' ? 'Berhasil' : 'Error';

        toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas ${icon}"></i>
            </div>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            </div>
        `;

        container.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideIn 0.4s ease reverse';
            setTimeout(() => toast.remove(), 400);
        }, 4000);
    }

    // Load initial data saat page load
    document.addEventListener('DOMContentLoaded', function() {
        loadData();
    });
</script>

    <?php $this->stop() ?>