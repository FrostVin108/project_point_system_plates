<?php $this->layout('layouts::app', ['title' => 'Dashboard']) ?>
<?php $this->start('main') ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    /* Liquid Glass Variables */
    --liquid-bg: rgba(255, 255, 255, 0.05);
    --liquid-bg-hover: rgba(255, 255, 255, 0.08);
    --liquid-border: rgba(255, 255, 255, 0.15);
    --liquid-border-strong: rgba(255, 255, 255, 0.25);
    --liquid-shadow: rgba(0, 0, 0, 0.4);
    --liquid-blur: blur(20px) saturate(180%);
    
    --primary: #3b82f6;
    --primary-light: #60a5fa;
    --primary-dark: #1d4ed8;
    --accent: #8b5cf6;
    --accent-light: #a78bfa;
    --success: #10b981;
    --success-light: #34d399;
    --warning: #f59e0b;
    --warning-light: #fbbf24;
    --danger: #ef4444;
    --danger-light: #f87171;
    --info: #06b6d4;
    --info-light: #22d3ee;
    
    --text-primary: #ffffff;
    --text-secondary: rgba(255, 255, 255, 0.85);
    --text-muted: rgba(255, 255, 255, 0.6);
    
    --radius: 20px;
    --radius-sm: 12px;
    --radius-lg: 28px;
    
    font-family: 'Plus Jakarta Sans', sans-serif;
}

body { 
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
    color: var(--text-primary);
    min-height: 100vh;
}

/* ── LAYOUT ── */
.dash-wrap { 
    padding: 28px 32px; 
    max-width: 1600px; 
    margin: 0 auto; 
}

/* ── TOP BAR ── */
.topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 32px;
    gap: 16px;
    flex-wrap: wrap;
}

.topbar-left h1 {
    font-size: 2rem;
    font-weight: 800;
    letter-spacing: -0.5px;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 12px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
}

.topbar-left h1 i {
    color: var(--primary-light);
    filter: drop-shadow(0 0 15px rgba(59, 130, 246, 0.6));
    font-size: 1.4rem;
}

.topbar-left p { 
    font-size: 0.9rem; 
    color: var(--text-muted); 
    margin-top: 6px;
    font-weight: 500;
}

/* ── USER CARD (top right) ── */
.user-pill {
    display: flex;
    align-items: center;
    gap: 14px;
    background: var(--liquid-bg);
    backdrop-filter: var(--liquid-blur);
    border: 1px solid var(--liquid-border);
    border-radius: 50px;
    padding: 10px 20px 10px 10px;
    box-shadow: 0 8px 32px var(--liquid-shadow);
    transition: all 0.3s ease;
}

.user-pill:hover {
    background: var(--liquid-bg-hover);
    border-color: var(--liquid-border-strong);
    transform: translateY(-2px);
}

.user-pill .avatar {
    width: 42px; 
    height: 42px;
    border-radius: 50%;
    display: flex; 
    align-items: center; 
    justify-content: center;
    font-size: 1rem; 
    font-weight: 700; 
    color: #fff;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    border: 2px solid rgba(255,255,255,0.2);
}

.user-pill .uinfo { line-height: 1.4; }
.user-pill .uname { 
    font-weight: 700; 
    font-size: 0.95rem; 
    color: var(--text-primary); 
}
.user-pill .urole {
    font-size: 0.75rem; 
    font-weight: 600; 
    letter-spacing: 0.5px;
    text-transform: uppercase; 
    color: var(--text-muted);
}

.user-pill .role-badge {
    font-size: 0.7rem; 
    font-weight: 700;
    padding: 3px 10px; 
    border-radius: 20px;
    letter-spacing: 0.3px;
    border: 1px solid rgba(255,255,255,0.2);
}

.role-admin  { 
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.3), rgba(109, 40, 217, 0.2));
    color: #c4b5fd; 
    border-color: rgba(139, 92, 246, 0.4);
}
.role-guru   { 
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(37, 99, 235, 0.2));
    color: #93c5fd; 
    border-color: rgba(59, 130, 246, 0.4);
}
.role-siswa  { 
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.3), rgba(5, 150, 105, 0.2));
    color: #6ee7b7; 
    border-color: rgba(16, 185, 129, 0.4);
}

/* ── DATE BADGE ── */
.date-badge {
    font-size: 0.85rem; 
    color: var(--text-secondary);
    background: var(--liquid-bg);
    backdrop-filter: var(--liquid-blur);
    border: 1px solid var(--liquid-border);
    border-radius: var(--radius-sm);
    padding: 10px 18px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

.date-badge i {
    color: var(--primary-light);
}

/* ── STAT CARDS ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 28px;
}

.stat-card {
    background: var(--liquid-bg);
    backdrop-filter: var(--liquid-blur);
    border: 1px solid var(--liquid-border);
    border-radius: var(--radius);
    padding: 24px;
    box-shadow: 0 8px 32px var(--liquid-shadow);
    display: flex;
    align-items: center;
    gap: 18px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute; 
    top: 0; 
    left: 0;
    width: 100%; 
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--card-color), transparent);
    opacity: 0.8;
}

.stat-card:hover { 
    transform: translateY(-4px); 
    box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    border-color: var(--liquid-border-strong);
    background: var(--liquid-bg-hover);
}

.stat-card.blue { --card-color: var(--primary-light); }
.stat-card.purple { --card-color: var(--accent-light); }
.stat-card.green { --card-color: var(--success-light); }
.stat-card.red { --card-color: var(--danger-light); }
.stat-card.orange { --card-color: var(--warning-light); }
.stat-card.cyan { --card-color: var(--info-light); }

.stat-icon {
    width: 56px; 
    height: 56px;
    border-radius: var(--radius-sm);
    display: flex; 
    align-items: center; 
    justify-content: center;
    font-size: 1.4rem; 
    flex-shrink: 0;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.blue  .stat-icon { color: var(--primary-light); }
.purple .stat-icon { color: var(--accent-light); }
.green  .stat-icon { color: var(--success-light); }
.red    .stat-icon { color: var(--danger-light); }
.orange .stat-icon { color: var(--warning-light); }
.cyan   .stat-icon { color: var(--info-light); }

.stat-body { flex: 1; }
.stat-value {
    font-size: 2.2rem; 
    font-weight: 800;
    line-height: 1; 
    letter-spacing: -1px;
    font-family: 'JetBrains Mono', monospace;
    color: var(--text-primary);
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
}
.stat-label { 
    font-size: 0.85rem; 
    color: var(--text-muted); 
    margin-top: 6px; 
    font-weight: 500;
}

/* ── TOP OFFENDER BOX ── */
.offender-wrap {
    margin-bottom: 28px;
}

.offender-box {
    background: linear-gradient(135deg, rgba(220, 38, 38, 0.15) 0%, rgba(239, 68, 68, 0.08) 100%);
    backdrop-filter: var(--liquid-blur);
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: var(--radius);
    padding: 20px 24px;
    display: flex; 
    align-items: center; 
    gap: 18px;
    box-shadow: 0 8px 32px rgba(220, 38, 38, 0.15);
    position: relative;
    overflow: hidden;
}

.offender-box::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, var(--danger-light), var(--danger));
}

.offender-box .icon { 
    font-size: 2rem; 
    color: var(--danger-light);
    filter: drop-shadow(0 0 10px rgba(239, 68, 68, 0.5));
    animation: pulse-fire 2s ease-in-out infinite;
}

@keyframes pulse-fire {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.offender-box .content { flex: 1; }
.offender-box .name { 
    font-weight: 700; 
    font-size: 1.1rem; 
    color: var(--text-primary);
    margin-bottom: 4px;
}
.offender-box .sub { 
    font-size: 0.85rem; 
    color: var(--text-muted); 
}

.offender-box .point-badge {
    background: linear-gradient(135deg, rgba(220, 38, 38, 0.3), rgba(239, 68, 68, 0.2));
    border: 1px solid rgba(239, 68, 68, 0.4);
    color: #fca5a5;
    padding: 8px 16px;
    border-radius: var(--radius-sm);
    font-family: 'JetBrains Mono', monospace;
    font-weight: 700;
    font-size: 1.1rem;
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.2);
}

/* ── GRID LAYOUT FOR CHARTS + TABLES ── */
.main-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
    margin-bottom: 24px;
}
.bottom-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

/* ── CARD ── */
.card {
    background: var(--liquid-bg);
    backdrop-filter: var(--liquid-blur);
    border: 1px solid var(--liquid-border);
    border-radius: var(--radius-lg);
    box-shadow: 0 8px 32px var(--liquid-shadow);
    overflow: hidden;
    transition: all 0.3s ease;
}

.card:hover {
    border-color: var(--liquid-border-strong);
    box-shadow: 0 12px 40px rgba(0,0,0,0.35);
}

.card-head {
    display: flex; 
    align-items: center; 
    justify-content: space-between;
    padding: 22px 26px 18px;
    border-bottom: 1px solid var(--liquid-border);
    background: rgba(0,0,0,0.1);
}

.card-head h3 {
    font-size: 1rem; 
    font-weight: 700;
    display: flex; 
    align-items: center; 
    gap: 12px;
    letter-spacing: -0.2px;
    color: var(--text-primary);
}

.card-head .icon-badge {
    width: 36px; 
    height: 36px; 
    border-radius: var(--radius-sm);
    display: flex; 
    align-items: center; 
    justify-content: center;
    font-size: 0.9rem;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.card-head .icon-badge.blue { color: var(--primary-light); }
.card-head .icon-badge.purple { color: var(--accent-light); }
.card-head .icon-badge.red { color: var(--danger-light); }
.card-head .icon-badge.orange { color: var(--warning-light); }

.card-head .meta-label {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 600;
    background: rgba(255,255,255,0.05);
    padding: 6px 14px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.1);
}

.card-head .count-badge {
    font-size: 0.75rem;
    font-weight: 700;
    background: linear-gradient(135deg, rgba(220, 38, 38, 0.3), rgba(239, 68, 68, 0.2));
    color: #fca5a5;
    padding: 4px 12px;
    border-radius: 20px;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.card-body { 
    padding: 24px 26px; 
}
.card-body.p0 { padding: 0; }

/* ── CHART WRAPPER ── */
.chart-wrap { 
    position: relative; 
    height: 280px; 
}

.chart-wrap.small {
    height: 240px;
}

/* ── TABLE ── */
.dash-table { 
    width: 100%; 
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.85rem; 
}

.dash-table thead th {
    background: rgba(0,0,0,0.2);
    padding: 14px 18px;
    font-weight: 700; 
    font-size: 0.75rem;
    text-transform: uppercase; 
    letter-spacing: 0.8px;
    color: var(--text-muted);
    border-bottom: 1px solid var(--liquid-border);
    text-align: left;
}

.dash-table tbody tr {
    border-bottom: 1px solid var(--liquid-border);
    transition: all 0.2s ease;
}

.dash-table tbody tr:last-child { border-bottom: none; }
.dash-table tbody tr:hover { 
    background: rgba(255,255,255,0.05);
}

.dash-table td { 
    padding: 14px 18px; 
    vertical-align: middle;
    color: var(--text-secondary);
}

.siswa-name { 
    font-weight: 600; 
    font-size: 0.9rem; 
    color: var(--text-primary);
}
.siswa-nis { 
    font-size: 0.75rem; 
    color: var(--text-muted); 
    font-family: 'JetBrains Mono', monospace;
    margin-top: 4px;
}

.kelas-badge {
    font-size: 0.75rem; 
    font-weight: 600;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(37, 99, 235, 0.1));
    color: #93c5fd;
    border: 1px solid rgba(59, 130, 246, 0.3);
    border-radius: 8px; 
    padding: 4px 10px;
    display: inline-block;
}

.pt-badge {
    font-family: 'JetBrains Mono', monospace;
    font-weight: 700; 
    font-size: 0.8rem;
    background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(239, 68, 68, 0.1));
    color: #fca5a5;
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: 8px; 
    padding: 4px 10px;
    display: inline-block;
}

.jenis-tag {
    font-size: 0.8rem; 
    font-weight: 600;
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(109, 40, 217, 0.1));
    color: #c4b5fd;
    border: 1px solid rgba(139, 92, 246, 0.3);
    border-radius: 8px; 
    padding: 4px 10px;
    white-space: nowrap;
    display: inline-block;
}

.guru-name { 
    font-size: 0.8rem; 
    color: var(--text-muted); 
}
.time-str { 
    font-size: 0.75rem; 
    color: var(--text-muted); 
    font-family: 'JetBrains Mono', monospace; 
}

/* Status badges */
.badge-status {
    font-size: 0.7rem; 
    font-weight: 700; 
    border-radius: 20px;
    padding: 4px 12px; 
    letter-spacing: 0.3px; 
    text-transform: uppercase;
    border: 1px solid;
    display: inline-block;
}

.bs-proses  { 
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.2), rgba(251, 191, 36, 0.1));
    color: #fcd34d;
    border-color: rgba(245, 158, 11, 0.3);
}
.bs-selesai { 
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(52, 211, 153, 0.1));
    color: #6ee7b7;
    border-color: rgba(16, 185, 129, 0.3);
}
.bs-pending { 
    background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(239, 68, 68, 0.1));
    color: #fca5a5;
    border-color: rgba(220, 38, 38, 0.3);
}

/* ── TODAY EMPTY / LOADING ── */
.empty-state {
    text-align: center; 
    padding: 50px 20px;
    color: var(--text-muted); 
    font-size: 0.9rem;
}

.empty-state i { 
    font-size: 2.5rem; 
    margin-bottom: 16px; 
    opacity: 0.4; 
    display: block; 
    color: var(--text-muted);
}

.empty-state.success i {
    color: var(--success-light);
    opacity: 0.8;
}

/* ── SCROLLABLE TABLE ── */
.table-scroll { 
    max-height: 340px; 
    overflow-y: auto;
}

.table-scroll::-webkit-scrollbar { 
    width: 6px; 
}
.table-scroll::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.05);
    border-radius: 3px;
}
.table-scroll::-webkit-scrollbar-thumb { 
    background: rgba(255,255,255,0.2); 
    border-radius: 3px; 
}
.table-scroll::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.3);
}

/* ── JENIS LEGEND ── */
.jenis-legend {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid var(--liquid-border);
}

.legend-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    padding: 8px 12px;
    background: rgba(255,255,255,0.03);
    border-radius: var(--radius-sm);
    border: 1px solid rgba(255,255,255,0.05);
    transition: all 0.2s ease;
}

.legend-item:hover {
    background: rgba(255,255,255,0.06);
    border-color: rgba(255,255,255,0.1);
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 10px;
    box-shadow: 0 0 10px currentColor;
}

.legend-label {
    display: flex;
    align-items: center;
    font-weight: 600;
    font-size: 0.85rem;
    color: var(--text-secondary);
}

.legend-count {
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--text-muted);
    background: rgba(0,0,0,0.2);
    padding: 4px 10px;
    border-radius: 8px;
}

/* ── SKELETON LOADER ── */
@keyframes shimmer {
    0%   { background-position: -600px 0; }
    100% { background-position: 600px 0; }
}
.skeleton {
    background: linear-gradient(90deg, rgba(255,255,255,0.05) 25%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.05) 75%);
    background-size: 600px 100%;
    animation: shimmer 1.4s infinite;
    border-radius: 8px;
    display: inline-block;
}

/* ── RESPONSIVE ── */
@media (max-width: 1100px) {
    .main-grid   { grid-template-columns: 1fr; }
    .bottom-grid { grid-template-columns: 1fr; }
}

@media (max-width: 768px) {
    .dash-wrap { padding: 20px; }
    .stats-grid { grid-template-columns: 1fr; }
    .topbar-left h1 { font-size: 1.5rem; }
    .stat-value { font-size: 1.8rem; }
    .offender-box { flex-direction: column; text-align: center; gap: 12px; }
    .offender-box .point-badge { margin-top: 8px; }
}
</style>

<div class="dash-wrap">

    <!-- ── TOP BAR ── -->
    <div class="topbar">
        <div class="topbar-left">
            <h1><i class="fas fa-chart-line"></i>Dashboard</h1>
            <p id="dateStr">Memuat tanggal...</p>
        </div>
        <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
            <div class="date-badge">
                <i class="fas fa-calendar-alt"></i>
                <span id="todayLabel">—</span>
            </div>
            <!-- USER PILL -->
            <div class="user-pill" id="userPill">
                <div class="avatar skeleton" style="width:42px;height:42px;">&nbsp;</div>
                <div class="uinfo">
                    <div class="uname skeleton" style="width:100px;height:14px;">&nbsp;</div>
                    <div class="urole skeleton" style="width:70px;height:10px;margin-top:4px;">&nbsp;</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── STAT CARDS ── -->
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="statSiswa"><span class="skeleton" style="width:60px;height:32px;">&nbsp;</span></div>
                <div class="stat-label">Total Siswa</div>
            </div>
        </div>
        <div class="stat-card purple">
            <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="statGuru"><span class="skeleton" style="width:60px;height:32px;">&nbsp;</span></div>
                <div class="stat-label">Total Guru</div>
            </div>
        </div>
        <div class="stat-card red">
            <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="statBulanIni"><span class="skeleton" style="width:60px;height:32px;">&nbsp;</span></div>
                <div class="stat-label">Pelanggaran Bulan Ini</div>
            </div>
        </div>
        <div class="stat-card orange">
            <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="statHariIni"><span class="skeleton" style="width:60px;height:32px;">&nbsp;</span></div>
                <div class="stat-label">Pelanggaran Hari Ini</div>
            </div>
        </div>
        <div class="stat-card cyan">
            <div class="stat-icon"><i class="fas fa-star-half-alt"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="statPoint"><span class="skeleton" style="width:60px;height:32px;">&nbsp;</span></div>
                <div class="stat-label">Total Point Bulan Ini</div>
            </div>
        </div>
    </div>

    <!-- ── TOP OFFENDER (conditional) ── -->
    <div class="offender-wrap" id="topOffenderWrap" style="display:none;">
        <div class="offender-box">
            <div class="icon"><i class="fas fa-fire-alt"></i></div>
            <div class="content">
                <div class="name" id="offenderName">—</div>
                <div class="sub">Siswa dengan point pelanggaran tertinggi bulan ini</div>
            </div>
            <div class="point-badge" id="offenderPoint">0 pt</div>
        </div>
    </div>

    <!-- ── MAIN GRID ── -->
    <div class="main-grid">
        <!-- Chart perbandingan -->
        <div class="card">
            <div class="card-head">
                <h3>
                    <div class="icon-badge blue"><i class="fas fa-chart-bar"></i></div>
                    Perbandingan Pelanggaran
                </h3>
                <div class="meta-label" id="chartMonthLabel">—</div>
            </div>
            <div class="card-body">
                <div class="chart-wrap">
                    <canvas id="chartMonthly"></canvas>
                </div>
            </div>
        </div>

        <!-- Pie jenis pelanggaran -->
        <div class="card">
            <div class="card-head">
                <h3>
                    <div class="icon-badge purple"><i class="fas fa-chart-pie"></i></div>
                    Jenis Pelanggaran Bulan Ini
                </h3>
            </div>
            <div class="card-body">
                <div class="chart-wrap small">
                    <canvas id="chartJenis"></canvas>
                </div>
                <div class="jenis-legend" id="jenisLegend"></div>
            </div>
        </div>
    </div>

    <!-- ── BOTTOM GRID ── -->
    <div class="bottom-grid">

        <!-- Latest pelanggaran -->
        <div class="card">
            <div class="card-head">
                <h3>
                    <div class="icon-badge red"><i class="fas fa-list-ul"></i></div>
                    Pelanggaran Terbaru
                </h3>
                <span class="meta-label">8 terakhir</span>
            </div>
            <div class="card-body p0">
                <div class="table-scroll">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Jenis</th>
                                <th>Point</th>
                                <th>Guru</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="latestBody">
                            <tr><td colspan="6"><div class="empty-state"><i class="fas fa-spinner fa-spin"></i>Memuat data...</div></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pelanggaran hari ini -->
        <div class="card">
            <div class="card-head">
                <h3>
                    <div class="icon-badge orange"><i class="fas fa-calendar-check"></i></div>
                    Pelanggaran Hari Ini
                </h3>
                <span class="count-badge" id="todayCount">0</span>
            </div>
            <div class="card-body p0">
                <div class="table-scroll">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Kelas</th>
                                <th>Jenis</th>
                                <th>Point</th>
                                <th>Guru</th>
                            </tr>
                        </thead>
                        <tbody id="todayBody">
                            <tr><td colspan="5"><div class="empty-state"><i class="fas fa-spinner fa-spin"></i>Memuat data...</div></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// ── UTILITIES ─────────────────────────────────────────────────
const COLORS = [
    '#60a5fa', '#a78bfa', '#34d399', '#f87171', 
    '#fbbf24', '#22d3ee', '#f472b6', '#4ade80'
];

function fmtDate(str) {
    if (!str) return '—';
    const d = new Date(str);
    return d.toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' });
}

function statusBadge(s) {
    if (!s) return '<span class="badge-status bs-proses">Proses</span>';
    const map = {
        'selesai':'bs-selesai','done':'bs-selesai',
        'proses':'bs-proses','process':'bs-proses',
        'pending':'bs-pending'
    };
    const key = (map[s.toLowerCase()] || 'bs-proses');
    return `<span class="badge-status ${key}">${s}</span>`;
}

function kelasStr(row) {
    const parts = [row.tingkat, row.jurusan, row.kelas_nama].filter(Boolean);
    return parts.length ? parts.join(' ') : '—';
}

// ── DATE ──────────────────────────────────────────────────────
const now = new Date();
document.getElementById('dateStr').textContent =
    now.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
document.getElementById('todayLabel').textContent =
    now.toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' });

// ── LOAD USER INFO ────────────────────────────────────────────
$.get('action_dashboard.php?action=me')
    .done(function(u) {
        if (!u || u.error) return;
        const avatarColors = { admin:'#8b5cf6', guru:'#3b82f6', siswa:'#10b981' };
        const bg = avatarColors[u.role] || '#6b7280';
        const initials = (u.name || 'U').split(' ').slice(0,2).map(w=>w[0]).join('').toUpperCase();
        const roleClass = 'role-' + (u.role || 'admin');
        $('#userPill').html(`
            <div class="avatar" style="background:${bg};">${initials}</div>
            <div class="uinfo">
                <div class="uname">${u.name}</div>
                <div class="urole"><span class="role-badge ${roleClass}">${u.role || '—'}</span></div>
            </div>
        `);
    });

// ── LOAD STATS ────────────────────────────────────────────────
$.get('action_dashboard.php?action=stats')
    .done(function(d) {
        $('#statSiswa').text(d.total_siswa ?? '0');
        $('#statGuru').text(d.total_guru ?? '0');
        $('#statBulanIni').text(d.pelanggaran_bulan_ini ?? '0');
        $('#statHariIni').text(d.pelanggaran_hari_ini ?? '0');
        $('#statPoint').text(d.total_point_bulan_ini ?? '0');

        if (d.top_siswa && d.top_siswa.total > 0) {
            $('#offenderName').text(d.top_siswa.name);
            $('#offenderPoint').text(d.top_siswa.total + ' pt');
            $('#topOffenderWrap').show();
        }
    });

// ── CHART: Monthly comparison ─────────────────────────────────
let chartMonthly = null;
$.get('action_dashboard.php?action=chart_monthly')
    .done(function(d) {
        $('#chartMonthLabel').text(d.last_month_name + ' vs ' + d.this_month_name);

        const makeDayMap = arr => {
            const m = {};
            arr.forEach(r => { m[parseInt(r.day)] = parseInt(r.count); });
            return m;
        };

        const allDays = new Set([
            ...d.this_month.map(r => parseInt(r.day)),
            ...d.last_month.map(r => parseInt(r.day))
        ]);
        const maxDay = allDays.size ? Math.max(...allDays) : 31;
        const labels = Array.from({length: maxDay}, (_,i) => i+1);

        const thisMap = makeDayMap(d.this_month);
        const lastMap = makeDayMap(d.last_month);

        const thisData = labels.map(day => thisMap[day] || 0);
        const lastData = labels.map(day => lastMap[day] || 0);

        const ctx = document.getElementById('chartMonthly').getContext('2d');
        chartMonthly = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.map(d => d),
                datasets: [
                    {
                        label: d.last_month_name,
                        data: lastData,
                        backgroundColor: 'rgba(167, 139, 250, 0.25)',
                        borderColor: 'rgba(167, 139, 250, 0.8)',
                        borderWidth: 2,
                        borderRadius: 6,
                        borderSkipped: false,
                    },
                    {
                        label: d.this_month_name,
                        data: thisData,
                        backgroundColor: 'rgba(96, 165, 250, 0.35)',
                        borderColor: 'rgba(96, 165, 250, 0.9)',
                        borderWidth: 2,
                        borderRadius: 6,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: true, 
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'top', 
                        labels: { 
                            font: { family:'Plus Jakarta Sans', size:12, weight: '600' }, 
                            color: 'rgba(255,255,255,0.7)',
                            boxWidth: 12,
                            padding: 20
                        } 
                    },
                    tooltip: { 
                        mode:'index', 
                        intersect:false,
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: '#fff',
                        bodyColor: 'rgba(255,255,255,0.8)',
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 10
                    }
                },
                scales: {
                    x: { 
                        grid: { display:false, color: 'rgba(255,255,255,0.05)' }, 
                        ticks: { 
                            font: {size:11, family: 'JetBrains Mono'}, 
                            color: 'rgba(255,255,255,0.5)' 
                        } 
                    },
                    y: { 
                        beginAtZero:true, 
                        grid:{ color:'rgba(255,255,255,0.08)' }, 
                        ticks:{ 
                            stepSize:1, 
                            font:{size:11, family: 'JetBrains Mono'},
                            color: 'rgba(255,255,255,0.5)'
                        },
                        border: { display: false }
                    }
                }
            }
        });
    });

// ── CHART: Jenis Pelanggaran ──────────────────────────────────
let chartJenis = null;
$.get('action_dashboard.php?action=chart_jenis')
    .done(function(data) {
        if (!data.length) {
            $('#jenisLegend').html('<div class="empty-state" style="padding:20px;"><i class="fas fa-inbox"></i>Belum ada data</div>');
            return;
        }

        const labels = data.map(d => d.name);
        const counts = data.map(d => parseInt(d.count));
        const colors = COLORS.slice(0, data.length);

        const ctx = document.getElementById('chartJenis').getContext('2d');
        chartJenis = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    backgroundColor: colors,
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true, 
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: { display: false },
                    tooltip: { 
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: '#fff',
                        bodyColor: 'rgba(255,255,255,0.8)',
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: ctx => ` ${ctx.label}: ${ctx.raw} kasus`
                        }
                    }
                }
            }
        });

        let legend = '';
        data.forEach((d, i) => {
            legend += `
                <div class="legend-item">
                    <div class="legend-label">
                        <span class="legend-color" style="background:${colors[i]};color:${colors[i]}"></span>
                        ${d.name}
                    </div>
                    <span class="legend-count">${d.count}x</span>
                </div>`;
        });
        $('#jenisLegend').html(legend);
    });

// ── LATEST PELANGGARAN ────────────────────────────────────────
$.get('action_dashboard.php?action=latest&limit=8')
    .done(function(data) {
        if (!data.length) {
            $('#latestBody').html('<tr><td colspan="6"><div class="empty-state success"><i class="fas fa-check-circle"></i>Belum ada pelanggaran</div></td></tr>');
            return;
        }
        let html = '';
        data.forEach(function(r) {
            html += `<tr>
                <td>
                    <div class="siswa-name">${r.siswa_name}</div>
                    <div class="siswa-nis">${r.nis || '—'}</div>
                </td>
                <td><span class="jenis-tag">${r.jenis_name}</span></td>
                <td><span class="pt-badge">${r.total_point} pt</span></td>
                <td><div class="guru-name">${r.guru_name}</div></td>
                <td><div class="time-str">${fmtDate(r.date)}</div></td>
                <td>${statusBadge(r.status)}</td>
            </tr>`;
        });
        $('#latestBody').html(html);
    })
    .fail(function() {
        $('#latestBody').html('<tr><td colspan="6"><div class="empty-state"><i class="fas fa-exclamation-circle"></i>Gagal memuat data</div></td></tr>');
    });

// ── TODAY ─────────────────────────────────────────────────────
$.get('action_dashboard.php?action=today')
    .done(function(data) {
        $('#todayCount').text(data.length);
        if (!data.length) {
            $('#todayBody').html('<tr><td colspan="5"><div class="empty-state success"><i class="fas fa-check-circle"></i>Tidak ada pelanggaran hari ini</div></td></tr>');
            return;
        }
        let html = '';
        data.forEach(function(r) {
            html += `<tr>
                <td>
                    <div class="siswa-name">${r.siswa_name}</div>
                    <div class="siswa-nis">${r.nis || '—'}</div>
                </td>
                <td><span class="kelas-badge">${kelasStr(r)}</span></td>
                <td><span class="jenis-tag">${r.jenis_name}</span></td>
                <td><span class="pt-badge">${r.total_point} pt</span></td>
                <td><div class="guru-name">${r.guru_name}</div></td>
            </tr>`;
        });
        $('#todayBody').html(html);
    })
    .fail(function() {
        $('#todayBody').html('<tr><td colspan="5"><div class="empty-state"><i class="fas fa-exclamation-circle"></i>Gagal memuat data</div></td></tr>');
    });
</script>

<?php $this->stop() ?>