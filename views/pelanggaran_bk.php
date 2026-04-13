<?php $this->layout('layouts::app', ['title' => 'Dashboard BK']) ?>

<?php $this->start('main') ?>

<!-- 1. FontAwesome HARUS PALING ATAS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- 2. Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- 3. DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<style>
/* ═══════════════════════════════════════════════════════════════════════════
   FIX: FontAwesome icons inside gradient text elements
   ═══════════════════════════════════════════════════════════════════════════ */

/* Force icon to use solid color, not gradient */
.dashboard-title i,
.glass-card-title i {
    font-family: "Font Awesome 6 Free", "Font Awesome 5 Free" !important;
    font-weight: 900 !important;
    font-style: normal !important;
    
    /* CRITICAL: Reset gradient text effect */
    -webkit-text-fill-color: currentColor !important;
    -webkit-background-clip: initial !important;
    background: none !important;
    background-clip: initial !important;
    
    /* Ensure visibility */
    display: inline-block !important;
    color: #fbbf24 !important; /* Force yellow color */
    text-shadow: 0 0 15px rgba(251, 191, 36, 0.5) !important;
    
    /* Prevent inheritance issues */
    font-variant: normal !important;
    text-rendering: auto !important;
    -webkit-font-smoothing: antialiased !important;
    -moz-osx-font-smoothing: grayscale !important;
}

/* Alternative: wrap icon in separate container */
.dashboard-title {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
}

.dashboard-title-text {
    background: linear-gradient(135deg, #fff 0%, rgba(255,255,255,0.7) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.dashboard-title-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fbbf24;
    filter: drop-shadow(0 0 15px rgba(251, 191, 36, 0.5));
}

/* ═══════════════════════════════════════════════════════════════════════════
   DASHBOARD BK - LIQUID GLASS THEME
   ═══════════════════════════════════════════════════════════════════════════ */

:root {
    --liquid-bg: rgba(255, 255, 255, 0.05);
    --liquid-border: rgba(255, 255, 255, 0.15);
    --liquid-shadow: rgba(0, 0, 0, 0.4);
    --liquid-blur: blur(20px) saturate(180%);
    --primary: #3b82f6;
    --primary-light: #60a5fa;
    --danger: #dc2626;
    --danger-light: #ef4444;
    --success: #059669;
    --success-light: #10b981;
    --warning: #eab308;
    --warning-light: #f59e0b;
    --purple: #8b5cf6;
    --purple-light: #a78bfa;
    --orange: #f97316;
    --orange-light: #fb923c;
    --text-primary: #ffffff;
    --text-muted: rgba(255, 255, 255, 0.6);
    --text-dim: rgba(255, 255, 255, 0.4);
}

.dashboard-container { position: relative; z-index: 1; padding-bottom: 40px; }

/* ─── HEADER ─────────────────────────────────────────────────────────────── */
.dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap: 16px; }
.dashboard-title { font-size: 32px; font-weight: 800; margin: 0; background: linear-gradient(135deg, #fff 0%, rgba(255,255,255,0.7) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
.dashboard-title i { color: var(--warning-light); margin-right: 12px; filter: drop-shadow(0 0 15px rgba(251, 191, 36, 0.5)); }
.dashboard-subtitle { color: var(--text-muted); font-size: 14px; margin-top: 4px; }
.header-actions { display: flex; gap: 12px; }

.btn-dashboard-action {
    background: linear-gradient(135deg, var(--liquid-bg), rgba(255,255,255,0.08));
    border: 1px solid var(--liquid-border); color: white; padding: 12px 20px;
    border-radius: 14px; font-weight: 600; font-size: 14px;
    display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;
    backdrop-filter: blur(10px); box-shadow: 0 4px 15px rgba(0,0,0,0.2); cursor: pointer;
}
.btn-dashboard-action:hover { transform: translateY(-2px); border-color: rgba(255,255,255,0.3); box-shadow: 0 8px 25px rgba(0,0,0,0.3); }
.btn-dashboard-action.primary { background: linear-gradient(135deg, var(--danger), var(--orange)); border: 1px solid rgba(255,255,255,0.2); }
.btn-dashboard-action.primary:hover { box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4); }

/* ─── STATS GRID ─────────────────────────────────────────────────────────── */
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px; }
.stat-card { background: var(--liquid-bg); backdrop-filter: var(--liquid-blur); border: 1px solid var(--liquid-border); border-radius: 24px; padding: 24px; position: relative; overflow: hidden; transition: all 0.3s ease; }
.stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--primary), var(--purple)); opacity: 0.8; }
.stat-card:hover { transform: translateY(-5px); border-color: rgba(255,255,255,0.25); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
.stat-card.danger::before  { background: linear-gradient(90deg, var(--danger), var(--orange)); }
.stat-card.success::before { background: linear-gradient(90deg, var(--success), var(--primary)); }
.stat-card.warning::before { background: linear-gradient(90deg, var(--warning), var(--orange)); }
.stat-card.purple::before  { background: linear-gradient(90deg, var(--purple), var(--primary-light)); }
.stat-icon { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 16px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); }
.stat-card.danger .stat-icon  { color: var(--danger-light);  box-shadow: 0 0 20px rgba(239, 68, 68, 0.3); }
.stat-card.success .stat-icon { color: var(--success-light); box-shadow: 0 0 20px rgba(16, 185, 129, 0.3); }
.stat-card.warning .stat-icon { color: var(--warning-light); box-shadow: 0 0 20px rgba(251, 191, 36, 0.3); }
.stat-card.purple .stat-icon  { color: var(--purple-light);  box-shadow: 0 0 20px rgba(167, 139, 250, 0.3); }
.stat-value { font-size: 36px; font-weight: 800; color: white; margin-bottom: 4px; line-height: 1; }
.stat-label { font-size: 14px; color: var(--text-muted); font-weight: 500; }
.stat-trend { display: flex; align-items: center; gap: 6px; margin-top: 12px; font-size: 13px; font-weight: 600; }
.stat-trend.up      { color: var(--success-light); }
.stat-trend.down    { color: var(--danger-light); }
.stat-trend.neutral { color: var(--text-muted); }

/* ─── GRIDS ──────────────────────────────────────────────────────────────── */
.dashboard-grid   { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 28px; }
.dashboard-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px; }

/* ─── GLASS CARDS ────────────────────────────────────────────────────────── */
.glass-card { background: var(--liquid-bg); backdrop-filter: var(--liquid-blur); border: 1px solid var(--liquid-border); border-radius: 24px; overflow: hidden; }
.glass-card-header { padding: 20px 24px; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }
.glass-card-title { font-size: 18px; font-weight: 700; color: white; display: flex; align-items: center; gap: 10px; }
.glass-card-title i { color: var(--primary-light); }
.glass-card-body { padding: 24px; }
.glass-card-footer { padding: 16px 24px; border-top: 1px solid rgba(255,255,255,0.08); display: flex; justify-content: center; }

/* ─── CHART DATE FILTER ──────────────────────────────────────────────────── */
.chart-filter-group {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.chart-filter-btn {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.7);
    padding: 6px 14px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    white-space: nowrap;
}
.chart-filter-btn:hover { background: rgba(255,255,255,0.12); color: white; }
.chart-filter-btn.active {
    background: linear-gradient(135deg, var(--danger), var(--orange));
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
}

/* Custom date range inline */
.chart-date-range {
    display: none;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}
.chart-date-range.visible { display: flex; }
.chart-date-input {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 10px;
    color: white;
    padding: 5px 10px;
    font-size: 12px;
    outline: none;
    transition: border-color 0.2s;
    width: 130px;
}
.chart-date-input:focus { border-color: var(--primary-light); }
.chart-date-sep { color: var(--text-dim); font-size: 12px; }
.chart-apply-btn {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    border: none;
    color: white;
    padding: 5px 12px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
}
.chart-apply-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(59,130,246,0.4); }

/* ─── CHARTS ─────────────────────────────────────────────────────────────── */
.chart-container { position: relative; height: 300px; width: 100%; }
.chart-container.small { height: 250px; }

/* ─── ACTIVITY ───────────────────────────────────────────────────────────── */
.activity-list { display: flex; flex-direction: column; gap: 16px; }
.activity-item { display: flex; align-items: flex-start; gap: 14px; padding: 16px; background: rgba(255,255,255,0.03); border-radius: 16px; border: 1px solid rgba(255,255,255,0.05); transition: all 0.3s ease; }
.activity-item:hover { background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.1); transform: translateX(5px); }
.activity-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.activity-icon.danger { background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(239, 68, 68, 0.1)); color: var(--danger-light); border: 1px solid rgba(220, 38, 38, 0.3); }
.activity-content { flex: 1; min-width: 0; }
.activity-title { font-weight: 600; color: white; font-size: 14px; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.activity-desc { color: var(--text-muted); font-size: 13px; margin-bottom: 6px; }
.activity-meta { display: flex; align-items: center; gap: 12px; font-size: 12px; }
.activity-time { color: var(--text-dim); }
.activity-points { background: linear-gradient(135deg, rgba(220,38,38,0.3), rgba(239,68,68,0.2)); color: #fca5a5; padding: 2px 10px; border-radius: 20px; font-weight: 700; font-size: 11px; border: 1px solid rgba(220,38,38,0.4); }

/* ─── VIOLATORS ──────────────────────────────────────────────────────────── */
.violator-list { display: flex; flex-direction: column; gap: 12px; }
.violator-item { display: flex; align-items: center; gap: 14px; padding: 14px 16px; background: rgba(255,255,255,0.03); border-radius: 16px; border: 1px solid rgba(255,255,255,0.05); transition: all 0.3s ease; }
.violator-item:hover { background: rgba(255,255,255,0.06); transform: translateX(5px); }
.violator-rank { width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; flex-shrink: 0; }
.violator-rank.gold   { background: linear-gradient(135deg, #ffd700, #ffb700); color: #000; box-shadow: 0 4px 15px rgba(255,215,0,0.4); }
.violator-rank.silver { background: linear-gradient(135deg, #c0c0c0, #a0a0a0); color: #000; }
.violator-rank.bronze { background: linear-gradient(135deg, #cd7f32, #b87333); color: #fff; }
.violator-rank.normal { background: rgba(255,255,255,0.1); color: var(--text-muted); }
.violator-info { flex: 1; min-width: 0; }
.violator-name { font-weight: 600; color: white; font-size: 14px; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.violator-class { color: var(--text-dim); font-size: 12px; }
.violator-points { text-align: right; }
.violator-points-value { font-size: 20px; font-weight: 800; color: var(--danger-light); }
.violator-points-label { font-size: 11px; color: var(--text-dim); }

.violator-rank.rank-green  { background: linear-gradient(135deg, #16a34a, #22c55e); color: white; box-shadow: 0 4px 15px rgba(34,197,94,0.4); }
.violator-rank.rank-yellow { background: linear-gradient(135deg, #ca8a04, #eab308); color: white; box-shadow: 0 4px 15px rgba(234,179,8,0.4); }
.violator-rank.rank-red    { background: linear-gradient(135deg, #b91c1c, #ef4444); color: white; box-shadow: 0 4px 15px rgba(239,68,68,0.4); }

/* ─── TABLE ──────────────────────────────────────────────────────────────── */
.compact-table-wrapper { padding: 0; }
#dashboardTable { width: 100% !important; border-collapse: separate; border-spacing: 0; }
#dashboardTable thead th { background: rgba(0,0,0,0.2); color: var(--text-muted); font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; border: none; border-bottom: 1px solid rgba(255,255,255,0.08); }
#dashboardTable tbody td { padding: 14px 16px; border: none; border-bottom: 1px solid rgba(255,255,255,0.05); color: rgba(255,255,255,0.9); font-size: 14px; vertical-align: middle; }
#dashboardTable tbody tr:hover td { background: rgba(255,255,255,0.03); }
.badge-dashboard { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
.badge-dashboard.siswa { background: linear-gradient(135deg, rgba(59,130,246,0.2), rgba(96,165,250,0.1)); border: 1px solid rgba(59,130,246,0.3); color: #93c5fd; }
.badge-dashboard.jenis { background: linear-gradient(135deg, rgba(220,38,38,0.2), rgba(239,68,68,0.1)); border: 1px solid rgba(220,38,38,0.3); color: #fca5a5; }
.badge-dashboard.point { background: linear-gradient(135deg, rgba(147,51,234,0.2), rgba(168,85,247,0.1)); border: 1px solid rgba(147,51,234,0.3); color: #d8b4fe; font-weight: 700; }

/* ─── MODAL ──────────────────────────────────────────────────────────────── */
.modal-portal-container {
    position: relative;
    z-index: 1;
}

.liquid-modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 99999;
    opacity: 0;
    transition: opacity 0.3s ease;
    background: rgba(0, 0, 0, 0.54);
    backdrop-filter: blur(50px);
    align-items: flex-start;
    justify-content: center;
    overflow-y: auto;
}

.liquid-modal-overlay.active {
    display: flex;
    opacity: 1;
}

.liquid-modal {
    padding: 20px;
    box-sizing: border-box;
    margin-bottom: 40px;
    background: rgba(20, 30, 48, 0.1);
    backdrop-filter: blur(60px) saturate(250%);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 28px;
    width: 90%;
    max-width: 480px;
    box-shadow: 0 32px 64px rgba(0, 0, 0, 0.28);
    transform: scale(0.9) translateY(-20px);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    flex-shrink: 0;
}

.liquid-modal.large {
    max-width: 700px;
}

.liquid-modal-overlay.active .liquid-modal {
    transform: scale(1) translateY(0);
}

.liquid-modal-header {
    padding: 22px 26px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.32);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.liquid-modal-header.primary { background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(96, 165, 250, 0.05)); }
.liquid-modal-header.warning { background: linear-gradient(135deg, rgba(234, 179, 8, 0.2), rgba(251, 191, 36, 0.05)); }
.liquid-modal-header.danger { background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(239, 68, 68, 0.05)); }
.liquid-modal-header.success { background: linear-gradient(135deg, rgba(5, 150, 105, 0.2), rgba(52, 211, 153, 0.05)); }

.liquid-modal-title {
    font-weight: 700;
    font-size: 18px;
    color: white;
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
}

.liquid-modal-close {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: white;
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.liquid-modal-close:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: rotate(90deg);
}

.liquid-modal-body {
    padding: 26px;
    max-height: 60vh;
    overflow-y: auto;
}

.liquid-modal-footer {
    padding: 18px 26px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    background: rgba(0, 0, 0, 0.1);
}
/* ─── FORM ───────────────────────────────────────────────────────────────── */
.form-group-pelanggaran { margin-bottom: 20px; }
.form-group-pelanggaran label { display: block; font-weight: 600; font-size: 14px; margin-bottom: 8px; color: rgba(255,255,255,0.9); }
.required { color: #ff6b6b; margin-left: 4px; }
.form-select-pelanggaran, .form-input-pelanggaran { width: 100%; padding: 12px 16px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; color: white; font-size: 14px; transition: all 0.3s ease; box-sizing: border-box; }
.form-select-pelanggaran { appearance: auto; }
.form-select-pelanggaran:focus, .form-input-pelanggaran:focus { outline: none; border-color: var(--primary-light); box-shadow: 0 0 0 3px rgba(59,130,246,0.15); background: rgba(255,255,255,0.1); }
.form-select-pelanggaran option { background: #1a2744; color: white; }
.form-input-pelanggaran[readonly] { background: rgba(255,255,255,0.04); color: rgba(255,255,255,0.5); cursor: not-allowed; }
.form-hint { color: rgba(255,255,255,0.45); font-size: 12px; margin-top: 6px; display: block; }
.preview-box-liquid { background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 16px; margin-top: 16px; }
.preview-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px dashed rgba(255,255,255,0.08); }
.preview-row:last-child { border-bottom: none; }
.preview-label { color: rgba(255,255,255,0.6); font-size: 14px; }
.preview-value { color: white; font-weight: 600; }
.shortcut-container { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px; }
.shortcut-btn { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); color: rgba(255,255,255,0.8); padding: 7px 14px; border-radius: 10px; font-size: 13px; cursor: pointer; transition: all 0.3s ease; }
.shortcut-btn:hover { background: rgba(255,255,255,0.12); transform: translateY(-2px); }
.shortcut-btn.active { background: var(--success) !important; border-color: var(--success) !important; color: white !important; box-shadow: 0 4px 12px rgba(5,150,105,0.35); }
.btn-modal-cancel { background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.8); padding: 11px 22px; border-radius: 12px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; font-size: 14px; }
.btn-modal-cancel:hover { background: rgba(255,255,255,0.13); color: white; }
.btn-modal-submit { background: linear-gradient(135deg, rgba(59,130,246,0.9), rgba(5,150,105,0.9)); border: 1px solid rgba(255,255,255,0.2); color: white; padding: 11px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(59,130,246,0.3); font-size: 14px; }
.btn-modal-submit:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(59,130,246,0.4); }
.btn-modal-submit:disabled { opacity: 0.45; cursor: not-allowed; }
.btn-modal-submit.danger  { background: linear-gradient(135deg, rgba(220,38,38,0.9), rgba(239,68,68,0.9)); box-shadow: 0 6px 20px rgba(220,38,38,0.3); }
.btn-modal-submit.success { background: linear-gradient(135deg, rgba(5,150,105,0.9), rgba(52,211,153,0.9)); box-shadow: 0 6px 20px rgba(5,150,105,0.3); }

/* ─── TOAST ──────────────────────────────────────────────────────────────── */
.toast-pelanggaran { position: fixed; top: 24px; right: 24px; min-width: 300px; z-index: 999999; border-radius: 14px; backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.15) !important; box-shadow: 0 16px 40px rgba(0,0,0,0.35); animation: toastSlideIn 0.4s ease; }
@keyframes toastSlideIn { from { opacity:0; transform: translateX(100%) translateY(-10px); } to { opacity:1; transform: translateX(0) translateY(0); } }
.toast-pelanggaran.success { background: rgba(5,150,105,0.92) !important; color: white !important; }
.toast-pelanggaran.error   { background: rgba(220,38,38,0.92) !important; color: white !important; }

/* ─── RESPONSIVE ─────────────────────────────────────────────────────────── */
@media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } .dashboard-grid { grid-template-columns: 1fr; } .dashboard-grid-2 { grid-template-columns: 1fr; } }
@media (max-width: 768px) { .stats-grid { grid-template-columns: 1fr; } .dashboard-header { flex-direction: column; align-items: stretch; } .header-actions { justify-content: stretch; } .btn-dashboard-action { flex: 1; justify-content: center; } .liquid-modal.large { max-width: 100%; } .liquid-modal-body { max-height: 55vh; } }
</style>

<!-- ═══ MODALS ══════════════════════════════════════════════════════════════ -->

<!-- EXPORT MODAL -->
<div class="liquid-modal-overlay" id="exportModal">
    <div class="liquid-modal">
        <div class="liquid-modal-header success">
            <h5 class="liquid-modal-title"><i class="fas fa-file-word"></i>Export Laporan</h5>
            <button type="button" class="liquid-modal-close" onclick="closeModal('exportModal')"><i class="fas fa-times"></i></button>
        </div>
        <div class="liquid-modal-body">
            <div style="display:flex;gap:16px;margin-bottom:20px;">
                <div style="flex:1;">
                    <label style="display:block;font-weight:600;font-size:14px;margin-bottom:8px;color:rgba(255,255,255,0.9);">Dari Tanggal <span style="color:#ff6b6b;">*</span></label>
                    <input type="date" class="form-input-pelanggaran" id="exportDateStart">
                </div>
                <div style="flex:1;">
                    <label style="display:block;font-weight:600;font-size:14px;margin-bottom:8px;color:rgba(255,255,255,0.9);">Sampai Tanggal <span style="color:#ff6b6b;">*</span></label>
                    <input type="date" class="form-input-pelanggaran" id="exportDateEnd">
                </div>
            </div>
            <div class="form-group-pelanggaran">
                <label>Shortcut Periode</label>
                <div class="shortcut-container">
                    <button type="button" class="shortcut-btn active" data-months-ago="0" onclick="setShortcut(0)">Bulan Ini</button>
                    <button type="button" class="shortcut-btn" data-months-ago="1" onclick="setShortcut(1)">1 Bln Lalu</button>
                    <button type="button" class="shortcut-btn" data-months-ago="2" onclick="setShortcut(2)">2 Bln Lalu</button>
                    <button type="button" class="shortcut-btn" data-months-ago="3" onclick="setShortcut(3)">3 Bln Lalu</button>
                </div>
            </div>
            <div class="preview-box-liquid" id="exportPreview">
                <div style="text-align:center;color:rgba(255,255,255,0.5);padding:20px;"><i class="fas fa-spinner fa-spin"></i> Memuat preview...</div>
            </div>
        </div>
        <div class="liquid-modal-footer">
            <button type="button" class="btn-modal-cancel" onclick="closeModal('exportModal')"><i class="fas fa-times"></i> Batal</button>
            <button type="button" class="btn-modal-submit success" id="btnExportDownload" disabled onclick="downloadExport()"><i class="fas fa-download"></i> Download Word</button>
        </div>
    </div>
</div>

<!-- ADD MODAL -->
<div class="liquid-modal-overlay" id="addModal">
    <div class="liquid-modal large">
        <div class="liquid-modal-header danger">
            <h5 class="liquid-modal-title"><i class="fas fa-plus-circle"></i>Tambah Pelanggaran</h5>
            <button type="button" class="liquid-modal-close" onclick="closeModal('addModal')"><i class="fas fa-times"></i></button>
        </div>
        <form id="addForm">
            <div class="liquid-modal-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div class="form-group-pelanggaran">
                        <label>Siswa <span class="required">*</span></label>
                        <select class="form-select-pelanggaran" id="add_id_siswa" required><option value="">Pilih Siswa</option></select>
                    </div>
                    <div class="form-group-pelanggaran">
                        <label>Guru <span class="required">*</span></label>
                        <select class="form-select-pelanggaran" id="add_id_guru" required><option value="">Pilih Guru</option></select>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div class="form-group-pelanggaran">
                        <label>Jenis Pelanggaran <span class="required">*</span></label>
                        <select class="form-select-pelanggaran" id="add_id_jenis_pelanggaran" required><option value="">Pilih Jenis</option></select>
                    </div>
                    <div class="form-group-pelanggaran">
                        <label>Alasan Pelanggaran <span class="required">*</span></label>
                        <select class="form-select-pelanggaran" id="add_id_alasan_pelanggaran" required disabled><option value="">Pilih Jenis Dulu</option></select>
                    </div>
                </div>
                <div class="form-group-pelanggaran" style="max-width:50%;">
                    <label>Total Point</label>
                    <input type="number" class="form-input-pelanggaran" id="add_total_point" readonly value="0">
                    <small class="form-hint">Otomatis dari Jenis Pelanggaran</small>
                </div>
            </div>
            <div class="liquid-modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('addModal')"><i class="fas fa-times"></i> Batal</button>
                <button type="submit" class="btn-modal-submit danger" id="addSubmitBtn" disabled><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ═══ MAIN CONTENT ════════════════════════════════════════════════════════ -->
<div class="dashboard-container">

    <!-- HEADER -->
    <div class="dashboard-header">
        <h1 class="dashboard-title">
            <span class="dashboard-title-icon"><i class="fas fa-chart-area"></i></span>
            <span class="dashboard-title-text">Dashboard BK</span>
        </h1>
        <div class="header-actions">
            <button class="btn-dashboard-action" onclick="openModal('exportModal')">
                <i class="fas fa-file-word"></i>Export Laporan
            </button>
            <button class="btn-dashboard-action primary" onclick="openModal('addModal')">
                <i class="fas fa-plus"></i>Tambah Pelanggaran
            </button>
        </div>
    </div>

    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card danger">
            <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="stat-value" id="statTotalPelanggaran">0</div>
            <div class="stat-label">Total Pelanggaran Bulan Ini</div>
            <!-- <div class="stat-trend up"><i class="fas fa-arrow-up"></i><span>+12% dari bulan lalu</span></div> -->
        </div>
        <div class="stat-card warning">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-value" id="statTotalSiswa">0</div>
            <div class="stat-label">Siswa Melanggar</div>
            <!-- <div class="stat-trend neutral"><i class="fas fa-minus"></i><span>Status stabil</span></div> -->
        </div>
        <div class="stat-card purple">
            <div class="stat-icon"><i class="fas fa-star"></i></div>
            <div class="stat-value" id="statTotalPoints">0</div>
            <div class="stat-label">Total Point Pelanggaran Siswa</div>
            <!-- <div class="stat-trend down"><i class="fas fa-arrow-down"></i><span>-5% dari bulan lalu</span></div> -->
        </div>
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div class="stat-value" id="statTotalGuru">0</div>
            <div class="stat-label">Guru Aktif Melaporkan</div>
            <!-- <div class="stat-trend up"><i class="fas fa-arrow-up"></i><span>+3 guru baru</span></div> -->
        </div>
    </div>

    <!-- CHARTS -->
    <div class="dashboard-grid">

        <!-- TREND CHART -->
        <div class="glass-card">
            <div class="glass-card-header">
                <h3 class="glass-card-title">
                    <i class="fas fa-chart-area"></i>
                    <span id="trendChartTitle">Pelanggaran Minggu Ini</span>
                </h3>
                <!-- Filter Controls -->
                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px;">
                    <div class="chart-filter-group">
                        <button class="chart-filter-btn active" data-range="7d" onclick="setTrendRange('7d', this)">7 Hari</button>
                        <button class="chart-filter-btn" data-range="30d" onclick="setTrendRange('30d', this)">30 Hari</button>
                        <button class="chart-filter-btn" data-range="month" onclick="setTrendRange('month', this)">Bulan Ini</button>
                        <button class="chart-filter-btn" data-range="custom" onclick="setTrendRange('custom', this)">Custom</button>
                    </div>
                    <!-- Custom date range, hidden by default -->
                    <div class="chart-date-range" id="trendCustomRange">
                        <input type="date" class="chart-date-input" id="trendDateFrom">
                        <span class="chart-date-sep">—</span>
                        <input type="date" class="chart-date-input" id="trendDateTo">
                        <button class="chart-apply-btn" onclick="applyTrendCustomRange()">Terapkan</button>
                    </div>
                </div>
            </div>
            <div class="glass-card-body">
                <div class="chart-container"><canvas id="trendChart"></canvas></div>
            </div>
        </div>

        <!-- JENIS PIE CHART (legend hidden) -->
        <div class="glass-card">
            <div class="glass-card-header">
                <h3 class="glass-card-title"><i class="fas fa-chart-pie"></i>Distribusi Jenis Pelanggaran</h3>
            </div>
            <div class="glass-card-body">
                <!-- Extra height to compensate for no legend -->
                <div class="chart-container" style="height:280px;"><canvas id="jenisChart"></canvas></div>
            </div>
        </div>

    </div>

    <!-- TOP VIOLATORS + RECENT ACTIVITY -->
    <div class="dashboard-grid-2">
        <div class="glass-card">
            <div class="glass-card-header">
                <h3 class="glass-card-title"><i class="fa-solid fa-triangle-exclamation"></i>Point Pelanggaran Tertinggi</h3>
            </div>
            <div class="glass-card-body">
                <div class="violator-list" id="topViolatorsList"></div>
            </div>
            <div class="glass-card-footer">
                <a href="?page=pelanggaran" class="btn-dashboard-action" style="padding:10px 20px;font-size:13px;text-decoration:none;">
                    <i class="fas fa-external-link-alt"></i>Lihat Semua Data
                </a>
            </div>
        </div>
        <div class="glass-card">
            <div class="glass-card-header">
                <h3 class="glass-card-title"><i class="fas fa-clock"></i>Aktivitas Terbaru</h3>
            </div>
            <div class="glass-card-body">
                <div class="activity-list" id="recentActivityList"></div>
            </div>
            <div class="glass-card-footer">
                <a href="?page=pelanggaran" class="btn-dashboard-action" style="padding:10px 20px;font-size:13px;text-decoration:none;">
                    <i class="fas fa-list"></i>Lihat Semua
                </a>
            </div>
        </div>
    </div>

    <!-- DATA TABLE -->
    <div class="glass-card">
        <div class="glass-card-header">
            <h3 class="glass-card-title"><i class="fas fa-table"></i>Data Pelanggaran Terbaru</h3>
        </div>
        <div class="glass-card-body compact-table-wrapper">
            <table id="dashboardTable" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Tanggal</th><th>Siswa</th><th>Kelas</th>
                        <th>Jenis</th><th>Point</th><th>Guru</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</div><!-- /dashboard-container -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// ═══════════════════════════════════════════════════════════════════════════
// MODAL
// ═══════════════════════════════════════════════════════════════════════════

function openModal(id) {
    var o = document.getElementById(id);
    if (!o) return;
    o.scrollTop = 0;
    o.classList.add('active');
    document.body.style.overflow = 'hidden';
    if (id === 'exportModal') setTimeout(function(){ var r=getMonthRange(0); setExportPeriode(r.start,r.end); }, 50);
}

function closeModal(id) {
    var o = document.getElementById(id);
    if (!o) return;
    o.classList.remove('active');
    document.body.style.overflow = '';
    if (id === 'addModal') {
        setTimeout(function(){
            document.getElementById('addForm').reset();
            document.getElementById('add_id_alasan_pelanggaran').innerHTML = '<option value="">Pilih Jenis Dulu</option>';
            document.getElementById('add_id_alasan_pelanggaran').disabled = true;
            document.getElementById('add_total_point').value = 0;
            document.getElementById('addSubmitBtn').disabled = true;
        }, 300);
    }
}

document.querySelectorAll('.liquid-modal-overlay').forEach(function(o){
    o.addEventListener('click', function(e){ if (e.target===this) closeModal(this.id); });
});
document.addEventListener('keydown', function(e){
    if (e.key==='Escape') document.querySelectorAll('.liquid-modal-overlay.active').forEach(function(m){ closeModal(m.id); });
}); 

// ═══════════════════════════════════════════════════════════════════════════
// TREND CHART — DATE RANGE FILTER
// ═══════════════════════════════════════════════════════════════════════════

var trendChart, jenisChart;
var currentTrendRange = '7d';

// Map range key → human-readable title
var rangeTitles = {
    '7d'    : 'Pelanggaran Minggu Ini',
    '30d'   : 'Pelanggaran 30 Hari Terakhir',
    'month' : 'Pelanggaran Bulan Ini',
    'custom': 'Pelanggaran (Periode Custom)'
};

function pad(n){ return String(n).padStart(2,'0'); }
function fmtDate(d){ return d.getFullYear()+'-'+pad(d.getMonth()+1)+'-'+pad(d.getDate()); }

function getRangeDates(range) {
    var now = new Date();
    var end = fmtDate(now);
    var start;
    if (range === '7d') {
        var s = new Date(now); s.setDate(s.getDate()-6); start = fmtDate(s);
    } else if (range === '30d') {
        var s = new Date(now); s.setDate(s.getDate()-29); start = fmtDate(s);
    } else if (range === 'month') {
        start = now.getFullYear()+'-'+pad(now.getMonth()+1)+'-01';
    }
    return { start: start, end: end };
}

function setTrendRange(range, btnEl) {
    currentTrendRange = range;

    // Toggle active class on filter buttons
    document.querySelectorAll('.chart-filter-btn').forEach(function(b){ b.classList.remove('active'); });
    if (btnEl) btnEl.classList.add('active');

    // Show/hide custom range inputs
    var customDiv = document.getElementById('trendCustomRange');
    if (range === 'custom') {
        customDiv.classList.add('visible');
        // Pre-fill with last 7 days as starting point
        var r = getRangeDates('7d');
        document.getElementById('trendDateFrom').value = r.start;
        document.getElementById('trendDateTo').value   = r.end;
        return; // Don't load yet — wait for "Terapkan"
    } else {
        customDiv.classList.remove('visible');
    }

    // Update title
    document.getElementById('trendChartTitle').textContent = rangeTitles[range] || 'Tren Pelanggaran';

    var dates = getRangeDates(range);
    loadTrendChart(dates.start, dates.end);
}

function applyTrendCustomRange() {
    var from = document.getElementById('trendDateFrom').value;
    var to   = document.getElementById('trendDateTo').value;
    if (!from || !to) { showToast('Pilih tanggal dari dan sampai terlebih dahulu.', 'error'); return; }
    if (from > to)    { showToast('Tanggal awal tidak boleh lebih besar dari tanggal akhir.', 'error'); return; }

    // Build custom title
    var bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    function fmtDisp(s){ var p=s.split('-'); return parseInt(p[2])+' '+bulan[parseInt(p[1])-1]+' '+p[0]; }
    document.getElementById('trendChartTitle').textContent = 'Pelanggaran ' + fmtDisp(from) + ' – ' + fmtDisp(to);

    loadTrendChart(from, to);
}

function loadTrendChart(dateStart, dateEnd) {
    if (!trendChart) return;

    // Show loading state
    trendChart.data.labels = [];
    trendChart.data.datasets[0].data = [];
    trendChart.update();

    $.get('action_dashboard_bk.php', { action: 'trend', date_start: dateStart, date_end: dateEnd })
        .done(function(d) {
            trendChart.data.labels              = d.labels || [];
            trendChart.data.datasets[0].data    = d.values || [];
            trendChart.update();
        })
        .fail(function(){ showToast('Gagal memuat data chart.', 'error'); });
}

// ═══════════════════════════════════════════════════════════════════════════
// CHART INIT
// ═══════════════════════════════════════════════════════════════════════════

function initCharts() {
    // TREND — line chart
    var tCtx = document.getElementById('trendChart').getContext('2d');
    trendChart = new Chart(tCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Pelanggaran',
                data: [],
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239,68,68,0.1)',
                borderWidth: 3,
                fill: true, tension: 0.4,
                pointBackgroundColor: '#ef4444',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5, pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: 'rgba(255,255,255,0.6)' } },
                y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: 'rgba(255,255,255,0.6)' }, beginAtZero: true }
            }
        }
    });

    // JENIS — doughnut, legend HIDDEN
    var jCtx = document.getElementById('jenisChart').getContext('2d');
    jenisChart = new Chart(jCtx, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: ['#ef4444','#f97316','#eab308','#22c55e','#3b82f6','#8b5cf6','#ec4899'],
                borderWidth: 0, hoverOffset: 10
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '65%',
            plugins: {
                legend: { display: false },   // ← legend hidden
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            var label = ctx.label || '';
                            var val   = ctx.parsed || 0;
                            var total = ctx.dataset.data.reduce(function(a,b){ return a+b; }, 0);
                            var pct   = total ? Math.round(val/total*100) : 0;
                            return ' ' + label + ': ' + val + ' (' + pct + '%)';
                        }
                    }
                }
            }
        }
    });
}

// ═══════════════════════════════════════════════════════════════════════════
// DATA LOADING
// ═══════════════════════════════════════════════════════════════════════════

var dtTable;

function loadDashboardData() {
    $.get('action_dashboard_bk.php?action=stats').done(function(d) {
        $('#statTotalPelanggaran').text(d.total_pelanggaran || 0);
        $('#statTotalSiswa').text(d.total_siswa || 0);
        $('#statTotalPoints').text(d.total_points || 0);
        $('#statTotalGuru').text(d.total_guru || 0);
    });

    // Load trend with current active range
    var r = getRangeDates(currentTrendRange === 'custom' ? '7d' : currentTrendRange);
    loadTrendChart(r.start, r.end);

    $.get('action_dashboard_bk.php?action=jenis_dist').done(function(d) {
        if (jenisChart) {
            jenisChart.data.labels           = d.labels || [];
            jenisChart.data.datasets[0].data = d.values || [];
            jenisChart.update();
        }
    });

    $.get('action_dashboard_bk.php?action=top_violators').done(renderTopViolators);
    $.get('action_dashboard_bk.php?action=recent').done(renderRecentActivity);
}

function renderTopViolators(data) {
    var c = $('#topViolatorsList'); c.empty();
    if (!data || !data.length) { c.html('<div style="text-align:center;color:rgba(255,255,255,0.5);padding:40px;"><i class="fas fa-trophy" style="font-size:48px;opacity:0.3;display:block;margin-bottom:12px;"></i>Belum ada data</div>'); return; }
    data.slice(0,5).forEach(function(item,i) {
        var point = item.total_point || 0;
var rank = point >= 60 ? 'rank-red' : point >= 35 ? 'rank-yellow' : 'rank-green';
var pointColor = point >= 60 ? 'point-red' : point >= 35 ? 'point-yellow' : 'point-green';
        c.append('<div class="violator-item">'+
            '<div class="violator-rank '+rank+'">'+(i+1)+'</div>'+
            '<div class="violator-info"><div class="violator-name">'+(item.siswa_name||'-')+'</div><div class="violator-class">'+(item.kelas||'-')+'</div></div>'+
            '<div class="violator-points"><div class="violator-points-value">'+(item.total_point||0)+'</div><div class="violator-points-label">POINT</div></div>'+
        '</div>');
    });
}

function renderRecentActivity(data) {
    var c = $('#recentActivityList'); c.empty();
    if (!data || !data.length) { c.html('<div style="text-align:center;color:rgba(255,255,255,0.5);padding:40px;"><i class="fas fa-clock" style="font-size:48px;opacity:0.3;display:block;margin-bottom:12px;"></i>Belum ada aktivitas</div>'); return; }
    data.slice(0,5).forEach(function(item) {
        var ago = getTimeAgo(item.date);
        c.append('<div class="activity-item">'+
            '<div class="activity-icon danger"><i class="fas fa-exclamation"></i></div>'+
            '<div class="activity-content">'+
                '<div class="activity-title">'+(item.siswa_name||'-')+'</div>'+
                '<div class="activity-desc">'+(item.jenis_pelanggaran||'-')+' - '+(item.alasan_pelanggaran||'-')+'</div>'+
                '<div class="activity-meta"><span class="activity-time"><i class="fas fa-clock me-1"></i>'+ago+'</span><span class="activity-points">'+(item.total_point||0)+' PT</span></div>'+
            '</div>'+
        '</div>');
    });
}

function getTimeAgo(dateStr) {
    if (!dateStr) return '-';
    var diff = new Date()-new Date(dateStr), m=Math.floor(diff/60000), h=Math.floor(diff/3600000), d=Math.floor(diff/86400000);
    if (m<1) return 'Baru saja'; if (m<60) return m+' menit lalu'; if (h<24) return h+' jam lalu'; if (d===1) return 'Kemarin'; return d+' hari lalu';
}

// ═══════════════════════════════════════════════════════════════════════════
// EXPORT
// ═══════════════════════════════════════════════════════════════════════════

function getMonthRange(monthsAgo) {
    var now=new Date(), year=now.getFullYear(), month=now.getMonth()-monthsAgo;
    while(month<0){month+=12;year--;}
    var first=new Date(year,month,1), last=new Date(year,month+1,0);
    return { start: fmtDate(first), end: fmtDate(last) };
}

function fmtDisplay(s) {
    if (!s) return '-';
    var b=['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'], p=s.split('-');
    return parseInt(p[2])+' '+b[parseInt(p[1])-1]+' '+p[0];
}

function setShortcut(n) {
    var r=getMonthRange(n); setExportPeriode(r.start,r.end);
    document.querySelectorAll('.shortcut-btn').forEach(function(b){ b.classList.toggle('active',parseInt(b.dataset.monthsAgo)===n); });
}

var previewTimer=null;
function setExportPeriode(s,e) { document.getElementById('exportDateStart').value=s; document.getElementById('exportDateEnd').value=e; loadExportPreview(); }

function loadExportPreview() {
    var start=document.getElementById('exportDateStart').value, end=document.getElementById('exportDateEnd').value;
    var box=document.getElementById('exportPreview'), btn=document.getElementById('btnExportDownload');
    if (!start||!end){ box.innerHTML='<div style="text-align:center;color:rgba(255,255,255,0.5);padding:20px;">Pilih tanggal terlebih dahulu</div>'; btn.disabled=true; return; }
    if (start>end){ box.innerHTML='<div style="text-align:center;color:#ff6b6b;padding:20px;"><i class="fas fa-exclamation-triangle"></i> Tanggal awal tidak valid</div>'; btn.disabled=true; return; }
    box.innerHTML='<div style="text-align:center;color:rgba(255,255,255,0.5);padding:20px;"><i class="fas fa-spinner fa-spin"></i> Memuat...</div>'; btn.disabled=true;
    $.get('action_pelanggaran.php',{action:'count_range',date_start:start,date_end:end}).done(function(d){
        var total=parseInt(d.total||0), label=(start===end)?fmtDisplay(start):fmtDisplay(start)+' – '+fmtDisplay(end);
        var html='<div class="preview-row"><span class="preview-label">Periode</span><span class="preview-value">'+label+'</span></div>'+
            '<div class="preview-row"><span class="preview-label">Jumlah pelanggaran</span><span class="preview-value" style="color:#fca5a5;">'+total+' data</span></div>';
        if (!total) html+='<div style="margin-top:12px;padding-top:12px;border-top:1px dashed rgba(255,255,255,0.1);color:rgba(255,255,255,0.5);font-size:13px;text-align:center;"><i class="fas fa-info-circle"></i> Tidak ada data pada periode ini</div>';
        box.innerHTML=html; btn.disabled=false;
    }).fail(function(){ box.innerHTML='<div style="text-align:center;color:#ff6b6b;padding:20px;">Gagal memuat preview</div>'; });
}

function downloadExport() {
    var s=document.getElementById('exportDateStart').value, e=document.getElementById('exportDateEnd').value;
    if (!s||!e) return;
    var btn=document.getElementById('btnExportDownload'); btn.disabled=true; btn.innerHTML='<i class="fas fa-spinner fa-spin"></i> Membuat file...';
    window.open('export_pelanggaran.php?date_start='+s+'&date_end='+e,'_blank');
    setTimeout(function(){ btn.disabled=false; btn.innerHTML='<i class="fas fa-download"></i> Download Word'; },2000);
}

$(document).on('change','#exportDateStart',function(){
    var val=$(this).val();
    if (val){ var p=val.split('-'),yr=parseInt(p[0]),mo=parseInt(p[1])-1,ld=new Date(yr,mo+1,0); $('#exportDateEnd').val(yr+'-'+pad(ld.getMonth()+1)+'-'+pad(ld.getDate())); }
    document.querySelectorAll('.shortcut-btn').forEach(function(b){b.classList.remove('active');}); clearTimeout(previewTimer); previewTimer=setTimeout(loadExportPreview,400);
});
$(document).on('change','#exportDateEnd',function(){
    document.querySelectorAll('.shortcut-btn').forEach(function(b){b.classList.remove('active');}); clearTimeout(previewTimer); previewTimer=setTimeout(loadExportPreview,400);
});

// ═══════════════════════════════════════════════════════════════════════════
// TOAST
// ═══════════════════════════════════════════════════════════════════════════

function showToast(msg,type){
    type=type||'success'; var icon=type==='success'?'fa-check-circle':'fa-exclamation-triangle';
    var html='<div class="toast toast-pelanggaran align-items-center '+type+' border-0" role="alert"><div class="d-flex"><div class="toast-body"><i class="fas '+icon+' me-2"></i>'+msg+'</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div>';
    $('body').append(html); var el=$('.toast').last(); new bootstrap.Toast(el[0],{delay:4000}).show(); el.on('hidden.bs.toast',function(){$(this).remove();});
}

// ═══════════════════════════════════════════════════════════════════════════
// DATATABLE - HANYA 6 HARI TERAKHIR
// ═══════════════════════════════════════════════════════════════════════════

function getDate6DaysAgo() {
    var d = new Date();
    d.setDate(d.getDate() - 6);
    return d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
}

function initDataTable() {
    dtTable = $('#dashboardTable').DataTable({
        ajax: { 
            url: 'action_dashboard_bk.php?action=recent_table', 
            data: function(d) {
                // Kirim range 6 hari terakhir ke server
                d.date_start = getDate6DaysAgo();
                d.date_end = new Date().toISOString().split('T')[0];
            },
            dataSrc: '' 
        },
        columns: [
            { data:'date', render:function(d){ return new Date(d).toLocaleDateString('id-ID',{day:'numeric',month:'short'}); } },
            { data:null, render:function(d){ return '<span class="badge-dashboard siswa">'+(d.siswa_name||'-')+'</span>'; } },
            { data:'kelas' },
            { data:null, render:function(d){ return '<span class="badge-dashboard jenis">'+(d.jenis_pelanggaran||'-')+'</span>'; } },
            { data:null, className:'text-center', render:function(d){ return '<span class="badge-dashboard point">'+(d.total_point||0)+' pt</span>'; } },
            { data:'guru_name' }
        ],
        language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
        pageLength: 10, responsive: true, order: [[0,'desc']],
        searching: false, lengthChange: false, info: false
    });
}

// ═══════════════════════════════════════════════════════════════════════════
// FORM DROPDOWNS
// ═══════════════════════════════════════════════════════════════════════════

function loadDropdowns() {
    $.get('action_pelanggaran.php?action=siswa',function(d){ var h='<option value="">Pilih Siswa</option>'; d.forEach(function(s){h+='<option value="'+s.id+'">'+s.name+'</option>';}); $('#add_id_siswa').html(h); });
    $.get('action_pelanggaran.php?action=guru', function(d){ var h='<option value="">Pilih Guru</option>';  d.forEach(function(g){h+='<option value="'+g.id+'">'+g.name+'</option>';}); $('#add_id_guru').html(h); });
    $.get('action_pelanggaran.php?action=jenis',function(d){ var h='<option value="">Pilih Jenis</option>'; d.forEach(function(j){h+='<option value="'+j.id+'">'+j.name+'</option>';}); $('#add_id_jenis_pelanggaran').html(h); });
}

function updateAddSubmit() {
    var ok = $('#add_id_siswa').val() && $('#add_id_guru').val() && $('#add_id_jenis_pelanggaran').val() && $('#add_id_alasan_pelanggaran').val();
    $('#addSubmitBtn').prop('disabled', !ok);
}

// ═══════════════════════════════════════════════════════════════════════════
// READY
// ═══════════════════════════════════════════════════════════════════════════

$(document).ready(function() {
    initCharts();
    loadDropdowns();
    initDataTable();
    loadDashboardData(); // loads trend with default 7d

    $('#add_id_jenis_pelanggaran').on('change', function() {
        var id=$(this).val(), alasan=$('#add_id_alasan_pelanggaran'), point=$('#add_total_point');
        if (!id){ alasan.html('<option value="">Pilih Jenis Dulu</option>').prop('disabled',true); point.val(0); return; }
        $.get('action_pelanggaran.php?action=alasan&id_jenis='+id,function(d){ var h='<option value="">Pilih Alasan</option>'; d.forEach(function(a){h+='<option value="'+a.id+'">'+a.detail+'</option>';}); alasan.html(h).prop('disabled',false); });
        $.get('action_pelanggaran.php?action=jenis_point&id_jenis='+id,function(d){ point.val(d.point); updateAddSubmit(); });
    });

    $('#add_id_siswa,#add_id_guru,#add_id_alasan_pelanggaran').on('change', updateAddSubmit);

    $('#addForm').submit(function(e) {
        e.preventDefault();
        var $b=$('#addSubmitBtn'); $b.prop('disabled',true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        $.post('action_pelanggaran.php',{action:'add',id_siswa:$('#add_id_siswa').val(),id_guru:$('#add_id_guru').val(),id_jenis_pelanggaran:$('#add_id_jenis_pelanggaran').val(),id_alasan_pelanggaran:$('#add_id_alasan_pelanggaran').val(),total_point:$('#add_total_point').val()})
            .done(function(r){ if(r.success){closeModal('addModal');loadDashboardData();dtTable.ajax.reload(null,false);showToast('Pelanggaran berhasil disimpan!','success');}else showToast(r.message||'Gagal simpan!','error'); })
            .fail(function(){ showToast('Server error!','error'); })
            .always(function(){ $b.prop('disabled',false).html('<i class="fas fa-save"></i> Simpan'); });
    });

    setInterval(loadDashboardData, 30000);
});
</script>

<?php $this->stop() ?>