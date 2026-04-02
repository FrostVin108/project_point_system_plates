<?php $this->layout('layouts::app', ['title' => 'Dashboard Siswa']) ?>

<?php $this->start('main') ?>

<?php
// Session check
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'database.php';

// Ambil user_id dari session
$logged_in_user_id = $_SESSION['user_id'] ?? null;

if (!$logged_in_user_id) {
    header('Location: login.php');
    exit;
}

// Ambil data siswa berdasarkan id_user - JOIN dengan tabel kelas untuk mendapatkan info lengkap
$stmt = $pdo->prepare("
    SELECT s.*, k.tingkat, k.jurusan, k.kelas 
    FROM siswas s 
    LEFT JOIN kelas k ON s.id_kelas = k.id 
    WHERE s.id_user = ?
");
$stmt->execute([$logged_in_user_id]);
$siswa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$siswa) {
    echo "<div class='error-state'>Data siswa tidak ditemukan untuk user ini.</div>";
    exit;
}

$id_siswa = $siswa['id'];

// Ambil data pelanggaran siswa
$stmt = $pdo->prepare("
    SELECT 
        p.id,
        p.date,
        p.total_point,
        p.detail,
        p.status,
        jp.name as jenis_name,
        ap.detail as alasan_detail,
        g.name as guru_name
    FROM pelanggarans p
    LEFT JOIN jenis_pelanggarans jp ON p.id_jenis_pelanggaran = jp.id
    LEFT JOIN alasan_pelanggarans ap ON p.id_alasan_pelanggaran = ap.id
    LEFT JOIN gurus g ON p.id_guru = g.id
    WHERE p.id_siswa = ?
    ORDER BY p.date DESC, p.id DESC
");
$stmt->execute([$id_siswa]);
$pelanggarans = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Hitung total point
$total_point = array_sum(array_column($pelanggarans, 'total_point'));

// Ambil data user untuk login info
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$logged_in_user_id]);
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

// Format kelas display
$kelas_display = '-';
if ($siswa['tingkat'] && $siswa['jurusan'] && $siswa['kelas']) {
    $kelas_display = $siswa['tingkat'] . ' ' . strtoupper($siswa['jurusan']) . ' ' . $siswa['kelas'];
}

// Format tanggal
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
?>

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

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
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 24px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        overflow: hidden;
    }

    /* Compact Profile Header */
    .profile-header {
        padding: 28px 32px;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(139, 92, 246, 0.08));
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.25) 0%, transparent 70%);
        pointer-events: none;
    }

    .profile-content {
        display: flex;
        align-items: center;
        gap: 24px;
        position: relative;
        z-index: 1;
    }

    .profile-avatar {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 800;
        color: white;
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.35);
        flex-shrink: 0;
    }

    .profile-info { flex: 1; min-width: 0; }

    .profile-name {
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 6px;
        background: linear-gradient(135deg, #fff 0%, rgba(255, 255, 255, 0.85) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .profile-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .profile-class {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.08);
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .profile-nis {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.6);
    }

    .profile-stats {
        display: flex;
        gap: 12px;
        margin-left: auto;
    }

    .stat-pill {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 14px 20px;
        border-radius: 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        min-width: 100px;
    }

    .stat-value {
        font-size: 22px;
        font-weight: 800;
        line-height: 1;
    }

    .stat-value.danger {
        background: linear-gradient(135deg, #ef4444, #f97316);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stat-value.warning {
        background: linear-gradient(135deg, #eab308, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stat-label {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sp-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(239, 68, 68, 0.1));
        border: 1px solid rgba(220, 38, 38, 0.3);
        color: #fca5a5;
        padding: 8px 16px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 13px;
        margin-top: 12px;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 1024px) {
        .content-grid { grid-template-columns: 1fr; }
        .profile-content { flex-wrap: wrap; }
        .profile-stats {
            width: 100%;
            margin-left: 0;
            margin-top: 16px;
            justify-content: flex-start;
        }
    }

    @media (max-width: 640px) {
        .profile-header { padding: 20px; }
        .profile-avatar { width: 56px; height: 56px; font-size: 22px; }
        .profile-name { font-size: 18px; }
        .profile-stats { flex-direction: row; width: 100%; }
        .stat-pill { flex: 1; min-width: auto; }
    }

    .section-header {
        padding: 20px 24px;
        background: rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 16px;
        font-weight: 700;
    }

    .section-title i {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #dc2626, #eab308);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: white;
    }

    .section-count {
        background: rgba(255, 255, 255, 0.1);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Table Styles - 4 Columns (no status) */
    .table-container {
        padding: 0;
        max-height: 600px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
    }

    .table-container::-webkit-scrollbar { width: 6px; }
    .table-container::-webkit-scrollbar-track { background: transparent; }
    .table-container::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .data-table th {
        background: rgba(0, 0, 0, 0.25);
        padding: 14px 16px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: sticky;
        top: 0;
        z-index: 10;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .data-table th:first-child { padding-left: 24px; }
    .data-table th:last-child { padding-right: 24px; }

    .data-table td {
        padding: 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        font-size: 13px;
        vertical-align: top;
    }

    .data-table td:first-child { padding-left: 24px; }
    .data-table td:last-child { padding-right: 24px; }

    .data-table tbody tr { transition: all 0.2s ease; }
    .data-table tbody tr:hover { background: rgba(255, 255, 255, 0.03); }

    .date-cell {
        color: rgba(255, 255, 255, 0.7);
        font-size: 13px;
        white-space: nowrap;
        width: 120px;
    }

    .date-cell i { margin-right: 8px; opacity: 0.5; font-size: 12px; }

    .violation-info { max-width: 300px; }

    .violation-type {
        color: #fff;
        font-weight: 600;
        margin-bottom: 4px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .violation-type::before {
        content: '';
        width: 6px;
        height: 6px;
        background: #ef4444;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .violation-reason {
        color: rgba(255, 255, 255, 0.5);
        font-size: 12px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .point-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.15), rgba(239, 68, 68, 0.08));
        border: 1px solid rgba(220, 38, 38, 0.25);
        color: #fca5a5;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 12px;
    }

    .teacher-cell {
        color: rgba(255, 255, 255, 0.6);
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .teacher-cell i { color: #60a5fa; font-size: 11px; }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: rgba(255, 255, 255, 0.5);
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.3;
        background: linear-gradient(135deg, #22c55e, #10b981);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .empty-state h3 { font-size: 16px; margin-bottom: 8px; color: white; font-weight: 600; }
    .empty-state p { font-size: 13px; }

    .detail-section {
        display: flex;
        flex-direction: column;
        gap: 20px;
        position: sticky;
        top: 24px;
    }

    @media (max-width: 1024px) {
        .detail-section { position: relative; top: 0; }
    }

    .detail-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 20px;
    }

    .detail-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        font-size: 14px;
        font-weight: 700;
    }

    .detail-header i {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: white;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .detail-row:last-child { border-bottom: none; }

    .detail-label { color: rgba(255, 255, 255, 0.5); font-size: 12px; }

    .detail-value {
        color: #fff;
        font-weight: 600;
        font-size: 13px;
        text-align: right;
        max-width: 60%;
        word-break: break-word;
    }

    .login-card .detail-header i {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    }

    .credential-box {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        padding: 16px;
        margin-top: 12px;
    }

    .credential-item { margin-bottom: 14px; }
    .credential-item:last-child { margin-bottom: 0; }

    .credential-label {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .credential-value {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 10px 12px;
    }

    .credential-text {
        flex: 1;
        font-family: 'Courier New', monospace;
        font-size: 13px;
        color: #fff;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .credential-text.password-hidden {
        letter-spacing: 3px;
        color: rgba(255, 255, 255, 0.6);
    }

    .btn-toggle {
        width: 32px;
        height: 32px;
        border: none;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 8px;
        color: rgba(255, 255, 255, 0.7);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .btn-toggle:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        transform: scale(1.05);
    }

    .btn-toggle:active { transform: scale(0.95); }

    .info-note {
        margin-top: 14px;
        padding: 10px 12px;
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 8px;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.6);
        display: flex;
        align-items: center;
        gap: 8px;
        line-height: 1.4;
    }

    .info-note i { color: #60a5fa; font-size: 12px; flex-shrink: 0; }

    .toast-container {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 10000;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    @media (max-width: 768px) {
        .toast-container { left: 24px; right: 24px; }
    }
</style>

<div class="dashboard-container">
    <!-- Profile Header -->
    <div class="glass-card">
        <div >
            <div class="profile-content">
                <div class="profile-avatar">
                    <?= strtoupper(substr($siswa['name'], 0, 1)) ?>
                </div>
                <div class="profile-info">
                    <h1 class="profile-name"><?= htmlspecialchars($siswa['name']) ?></h1>
                    <div class="profile-meta">
                        <div class="profile-class">
                            <i class="fas fa-graduation-cap"></i>
                            <span><?= htmlspecialchars($kelas_display) ?></span>
                        </div>
                        <div class="profile-nis">
                            <i class="fas fa-id-card"></i>
                            <span>NIS: <?= htmlspecialchars($siswa['nis']) ?></span>
                        </div>
                    </div>
                    
                    <?php if (($siswa['sp'] ?? 0) > 0): ?>
                    <div class="sp-badge">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>SP Ke-<?= $siswa['sp'] ?> (Surat Peringatan)</span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="profile-stats">
                    <div class="stat-pill">
                        <span class="stat-value danger"><?= $total_point ?></span>
                        <span class="stat-label">Total Poin</span>
                    </div>
                    <div class="stat-pill">
                        <span class="stat-value warning"><?= count($pelanggarans) ?></span>
                        <span class="stat-label">Pelanggaran</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Left: Violation History - 4 Columns (removed status) -->
        <div class="glass-card">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-history"></i>
                    <span>Riwayat Pelanggaran</span>
                </div>
                <span class="section-count"><?= count($pelanggarans) ?> Records</span>
            </div>
            
            <div class="table-container">
                <?php if (empty($pelanggarans)): ?>
                    <div class="empty-state">
                        <i class="fas fa-clipboard-check"></i>
                        <h3>Belum Ada Pelanggaran</h3>
                        <p>Anda belum memiliki catatan pelanggaran. Pertahankan perilaku baik!</p>
                    </div>
                <?php else: ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis & Alasan</th>
                                <th style="text-align: center;">Point</th>
                                <th>Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pelanggarans as $item): 
                                $date = new DateTime($item['date']);
                                $dateStr = $date->format('d') . ' ' . $months[(int)$date->format('m') - 1] . ' ' . $date->format('Y');
                            ?>
                                <tr>
                                    <td class="date-cell">
                                        <i class="fas fa-calendar-alt"></i>
                                        <?= $dateStr ?>
                                    </td>
                                    <td class="violation-info">
                                        <div class="violation-type"><?= htmlspecialchars($item['jenis_name'] ?? '-') ?></div>
                                        <div class="violation-reason"><?= htmlspecialchars($item['alasan_detail'] ?? $item['detail'] ?? '-') ?></div>
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="point-tag">
                                            <i class="fas fa-star" style="font-size: 10px;"></i>
                                            <?= $item['total_point'] ?> PT
                                        </span>
                                    </td>
                                    <td class="teacher-cell">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        <?= htmlspecialchars($item['guru_name'] ?? 'System') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right: Details & Login -->
        <div class="detail-section">
            <!-- Student Details Card -->
            <div class="glass-card detail-card">
                <div class="detail-header">
                    <i class="fas fa-user"></i>
                    <span>Detail Siswa</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Nama Lengkap</span>
                    <span class="detail-value"><?= htmlspecialchars($siswa['name']) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">NIS</span>
                    <span class="detail-value"><?= htmlspecialchars($siswa['nis']) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Kelas</span>
                    <span class="detail-value"><?= htmlspecialchars($kelas_display) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Alamat</span>
                    <span class="detail-value"><?= htmlspecialchars($siswa['alamat'] ?? '-') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Telepon</span>
                    <span class="detail-value"><?= htmlspecialchars($siswa['telphone'] ?? '-') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Orang Tua</span>
                    <span class="detail-value"><?= htmlspecialchars($siswa['name_orang_tua'] ?? '-') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Telpon Ortu</span>
                    <span class="detail-value"><?= htmlspecialchars($siswa['telphone_orang_tua'] ?? '-') ?></span>
                </div>
            </div>

            <!-- Login Credentials Card - Fixed Toggle -->
            <div class="glass-card detail-card login-card">
                <div class="detail-header">
                    <i class="fas fa-lock"></i>
                    <span>Informasi Login</span>
                </div>
                
                <div class="credential-box">
                    <div class="credential-item">
                        <div class="credential-label">Username</div>
                        <div class="credential-value">
                            <span class="credential-text" id="usernameField"><?= htmlspecialchars($user_data['name'] ?? '-') ?></span>
                            <button type="button" class="btn-toggle" onclick="copyToClipboard('username')" title="Copy Username">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="credential-item">
                        <div class="credential-label">Password</div>
                        <div class="credential-value">
                            <span class="credential-text password-hidden" id="passwordField" data-password="<?= htmlspecialchars($user_data['password'] ?? '') ?>">••••••••</span>
                            <button type="button" class="btn-toggle" onclick="togglePassword()" title="Show/Hide Password">
                                <i class="fas fa-eye" id="passwordToggleIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="info-note">
                    <i class="fas fa-info-circle"></i>
                    <span>Informasi login bersifat rahasia. Jangan bagikan kepada orang lain.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<script>
    // Password Toggle - Fixed Implementation
    let isPasswordVisible = false;
    
    function togglePassword() {
        const passwordField = document.getElementById('passwordField');
        const toggleIcon = document.getElementById('passwordToggleIcon');
        const realPassword = passwordField.getAttribute('data-password');
        
        isPasswordVisible = !isPasswordVisible;
        
        if (isPasswordVisible) {
            passwordField.textContent = realPassword || '-';
            passwordField.classList.remove('password-hidden');
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.textContent = '••••••••';
            passwordField.classList.add('password-hidden');
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // Copy to Clipboard
    function copyToClipboard(type) {
        let textToCopy = '';
        
        if (type === 'username') {
            textToCopy = document.getElementById('usernameField').textContent.trim();
        }
        
        if (!textToCopy || textToCopy === '-') {
            showToast('Tidak ada data untuk disalin', 'error');
            return;
        }
        
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(textToCopy).then(() => {
                showToast('Username disalin!', 'success');
            }).catch(() => {
                fallbackCopy(textToCopy);
            });
        } else {
            fallbackCopy(textToCopy);
        }
    }
    
    function fallbackCopy(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-9999px';
        document.body.appendChild(textArea);
        textArea.select();
        
        try {
            document.execCommand('copy');
            showToast('Username disalin!', 'success');
        } catch (err) {
            showToast('Gagal menyalin', 'error');
        }
        
        document.body.removeChild(textArea);
    }

    // Toast Notification
    function showToast(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        
        const colors = type === 'success' 
            ? { border: '#059669', bg: 'rgba(5, 150, 105, 0.2)', icon: '#34d399', iconClass: 'fa-check-circle' }
            : { border: '#dc2626', bg: 'rgba(220, 38, 38, 0.2)', icon: '#f87171', iconClass: 'fa-exclamation-circle' };
        
        toast.style.cssText = `
            background: rgba(20, 30, 48, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-left: 4px solid ${colors.border};
            border-radius: 16px;
            padding: 16px 20px;
            min-width: 300px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            animation: slideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            color: white;
        `;
        
        toast.innerHTML = `
            <div style="width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; background: ${colors.bg}; color: ${colors.icon};">
                <i class="fas ${colors.iconClass}"></i>
            </div>
            <div>
                <div style="font-weight: 700; font-size: 14px;">${type === 'success' ? 'Berhasil' : 'Error'}</div>
                <div style="font-size: 13px; color: rgba(255,255,255,0.6);">${message}</div>
            </div>
        `;
        
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(100%) scale(0.9); }
            to { opacity: 1; transform: translateX(0) scale(1); }
        }
        @keyframes slideOut {
            from { opacity: 1; transform: translateX(0) scale(1); }
            to { opacity: 0; transform: translateX(100%) scale(0.9); }
        }
    `;
    document.head.appendChild(style);
</script>

<?php $this->stop() ?>