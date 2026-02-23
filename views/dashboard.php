<?php $this->layout('layouts::app', ['title' => 'Dashboard']) ?>
<?php $this->start('main') ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --bg:        #f0f2f7;
    --surface:   #ffffff;
    --surface2:  #f8f9fc;
    --border:    #e4e8f0;
    --text:      #0f1724;
    --muted:     #6b7a99;
    --accent:    #2563eb;
    --accent2:   #7c3aed;
    --success:   #059669;
    --warning:   #d97706;
    --danger:    #dc2626;
    --info:      #0891b2;
    --radius:    14px;
    --shadow:    0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.06);
    --shadow-lg: 0 8px 32px rgba(0,0,0,.10);
    font-family: 'Plus Jakarta Sans', sans-serif;
}

body { background: var(--bg); color: var(--text); }

/* ── LAYOUT ── */
.dash-wrap { padding: 28px 32px; max-width: 1600px; margin: 0 auto; }

/* ── TOP BAR ── */
.topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
    gap: 16px;
    flex-wrap: wrap;
}
.topbar-left h1 {
    font-size: 1.55rem;
    font-weight: 800;
    letter-spacing: -.4px;
    color: var(--text);
}
.topbar-left p { font-size: .85rem; color: var(--muted); margin-top: 2px; }

/* ── USER CARD (top right) ── */
.user-pill {
    display: flex;
    align-items: center;
    gap: 12px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 50px;
    padding: 8px 18px 8px 8px;
    box-shadow: var(--shadow);
}
.user-pill .avatar {
    width: 38px; height: 38px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem; font-weight: 700; color: #fff;
    flex-shrink: 0;
}
.user-pill .uinfo { line-height: 1.3; }
.user-pill .uname { font-weight: 700; font-size: .88rem; color: var(--text); }
.user-pill .urole {
    font-size: .72rem; font-weight: 600; letter-spacing: .5px;
    text-transform: uppercase; color: var(--muted);
}
.user-pill .role-badge {
    font-size: .7rem; font-weight: 700;
    padding: 2px 8px; border-radius: 20px;
    letter-spacing: .3px;
}
.role-admin  { background:#ede9fe; color:#6d28d9; }
.role-guru   { background:#dbeafe; color:#1d4ed8; }
.role-siswa  { background:#dcfce7; color:#15803d; }

/* ── DATE BADGE ── */
.date-badge {
    font-size: .78rem; color: var(--muted);
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 6px 14px;
    font-weight: 600;
}

/* ── STAT CARDS ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px 22px;
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform .18s, box-shadow .18s;
    position: relative;
    overflow: hidden;
}
.stat-card::before {
    content: '';
    position: absolute; top: 0; left: 0;
    width: 4px; height: 100%;
    border-radius: 4px 0 0 4px;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }
.stat-card.blue::before  { background: var(--accent); }
.stat-card.purple::before{ background: var(--accent2); }
.stat-card.green::before { background: var(--success); }
.stat-card.red::before   { background: var(--danger); }
.stat-card.orange::before{ background: var(--warning); }
.stat-card.cyan::before  { background: var(--info); }

.stat-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; flex-shrink: 0;
}
.blue  .stat-icon { background:#eff6ff; color: var(--accent); }
.purple .stat-icon{ background:#f5f3ff; color: var(--accent2); }
.green  .stat-icon{ background:#f0fdf4; color: var(--success); }
.red    .stat-icon{ background:#fef2f2; color: var(--danger); }
.orange .stat-icon{ background:#fffbeb; color: var(--warning); }
.cyan   .stat-icon{ background:#ecfeff; color: var(--info); }

.stat-body { flex: 1; }
.stat-value {
    font-size: 1.8rem; font-weight: 800;
    line-height: 1; letter-spacing: -.5px;
    font-family: 'JetBrains Mono', monospace;
}
.stat-label { font-size: .78rem; color: var(--muted); margin-top: 4px; font-weight: 500; }

/* ── GRID LAYOUT FOR CHARTS + TABLES ── */
.main-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}
.bottom-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* ── CARD ── */
.card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 22px 14px;
    border-bottom: 1px solid var(--border);
}
.card-head h3 {
    font-size: .92rem; font-weight: 700;
    display: flex; align-items: center; gap: 8px;
    letter-spacing: -.2px;
}
.card-head .icon-badge {
    width: 28px; height: 28px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem;
}
.card-body { padding: 20px 22px; }
.card-body.p0 { padding: 0; }

/* ── CHART WRAPPER ── */
.chart-wrap { position: relative; height: 260px; }

/* ── TABLE ── */
.dash-table { width: 100%; border-collapse: collapse; font-size: .8rem; }
.dash-table thead th {
    background: var(--surface2);
    padding: 9px 14px;
    font-weight: 700; font-size: .72rem;
    text-transform: uppercase; letter-spacing: .6px;
    color: var(--muted);
    border-bottom: 1px solid var(--border);
    text-align: left;
}
.dash-table tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background .12s;
}
.dash-table tbody tr:last-child { border-bottom: none; }
.dash-table tbody tr:hover { background: var(--surface2); }
.dash-table td { padding: 10px 14px; vertical-align: middle; }

.siswa-name { font-weight: 600; font-size: .83rem; }
.siswa-nis  { font-size: .72rem; color: var(--muted); font-family: 'JetBrains Mono', monospace; }
.kelas-badge {
    font-size: .7rem; font-weight: 600;
    background: #eff6ff; color: #1d4ed8;
    border-radius: 6px; padding: 2px 8px;
}
.pt-badge {
    font-family: 'JetBrains Mono', monospace;
    font-weight: 700; font-size: .78rem;
    background: #fef2f2; color: var(--danger);
    border-radius: 6px; padding: 3px 8px;
}
.jenis-tag {
    font-size: .72rem; font-weight: 600;
    background: #f5f3ff; color: #6d28d9;
    border-radius: 6px; padding: 2px 8px;
    white-space: nowrap;
}
.guru-name { font-size: .75rem; color: var(--muted); }
.time-str  { font-size: .72rem; color: var(--muted); font-family: 'JetBrains Mono', monospace; }

/* Status badges */
.badge-status {
    font-size: .68rem; font-weight: 700; border-radius: 20px;
    padding: 2px 9px; letter-spacing: .3px; text-transform: uppercase;
}
.bs-proses  { background:#fef9c3; color:#a16207; }
.bs-selesai { background:#dcfce7; color:#166534; }
.bs-pending { background:#fef2f2; color:#991b1b; }

/* ── TODAY EMPTY / LOADING ── */
.empty-state {
    text-align: center; padding: 40px 20px;
    color: var(--muted); font-size: .83rem;
}
.empty-state i { font-size: 2rem; margin-bottom: 10px; opacity: .35; display: block; }

/* ── TOP OFFENDER BOX ── */
.offender-box {
    background: linear-gradient(135deg, #fef2f2 0%, #fff5f5 100%);
    border: 1px solid #fecaca;
    border-radius: 10px;
    padding: 14px 18px;
    display: flex; align-items: center; gap: 14px;
}
.offender-box .icon { font-size: 1.5rem; }
.offender-box .name { font-weight: 700; font-size: .9rem; }
.offender-box .sub  { font-size: .75rem; color: var(--muted); }

/* ── SCROLLABLE TABLE ── */
.table-scroll { max-height: 320px; overflow-y: auto; }
.table-scroll::-webkit-scrollbar { width: 4px; }
.table-scroll::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

/* ── RESPONSIVE ── */
@media (max-width: 1100px) {
    .main-grid   { grid-template-columns: 1fr; }
    .bottom-grid { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .dash-wrap { padding: 16px; }
    .stats-grid { grid-template-columns: 1fr 1fr; }
}

/* ── SKELETON LOADER ── */
@keyframes shimmer {
    0%   { background-position: -600px 0; }
    100% { background-position: 600px 0; }
}
.skeleton {
    background: linear-gradient(90deg, #e8ecf4 25%, #f3f5f9 50%, #e8ecf4 75%);
    background-size: 600px 100%;
    animation: shimmer 1.4s infinite;
    border-radius: 6px;
    display: inline-block;
}
</style>

<div class="dash-wrap">

    <!-- ── TOP BAR ── -->
    <div class="topbar">
        <div class="topbar-left">
            <h1><i class="fas fa-chart-line" style="color:var(--accent);margin-right:10px;font-size:1.3rem;"></i>Dashboard</h1>
            <p id="dateStr">Memuat tanggal...</p>
        </div>
        <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
            <div class="date-badge">
                <i class="fas fa-calendar-alt me-1"></i>
                <span id="todayLabel">—</span>
            </div>
            <!-- USER PILL -->
            <div class="user-pill" id="userPill">
                <div class="avatar skeleton" style="width:38px;height:38px;">&nbsp;</div>
                <div class="uinfo">
                    <div class="uname skeleton" style="width:90px;height:13px;">&nbsp;</div>
                    <div class="urole skeleton" style="width:60px;height:10px;margin-top:4px;">&nbsp;</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── STAT CARDS ── -->
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="statSiswa"><span class="skeleton" style="width:50px;height:28px;">&nbsp;</span></div>
                <div class="stat-label">Total Siswa</div>
            </div>
        </div>
        <div class="stat-card purple">
            <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="statGuru"><span class="skeleton" style="width:50px;height:28px;">&nbsp;</span></div>
                <div class="stat-label">Total Guru</div>
            </div>
        </div>
        <div class="stat-card red">
            <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="statBulanIni"><span class="skeleton" style="width:50px;height:28px;">&nbsp;</span></div>
                <div class="stat-label">Pelanggaran Bulan Ini</div>
            </div>
        </div>
        <div class="stat-card orange">
            <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="statHariIni"><span class="skeleton" style="width:50px;height:28px;">&nbsp;</span></div>
                <div class="stat-label">Pelanggaran Hari Ini</div>
            </div>
        </div>
        <div class="stat-card cyan">
            <div class="stat-icon"><i class="fas fa-star-half-alt"></i></div>
            <div class="stat-body">
                <div class="stat-value" id="statPoint"><span class="skeleton" style="width:50px;height:28px;">&nbsp;</span></div>
                <div class="stat-label">Total Point Bulan Ini</div>
            </div>
        </div>
    </div>

    <!-- ── TOP OFFENDER (conditional) ── -->
    <div id="topOffenderWrap" style="margin-bottom:20px;display:none;">
        <div class="offender-box">
            <div class="icon"><i class="fas fa-fire-alt" style="color:var(--danger);"></i></div>
            <div>
                <div class="name" id="offenderName">—</div>
                <div class="sub">Siswa dengan point pelanggaran tertinggi bulan ini</div>
            </div>
            <div style="margin-left:auto;">
                <span class="pt-badge" id="offenderPoint">0 pt</span>
            </div>
        </div>
    </div>

    <!-- ── MAIN GRID ── -->
    <div class="main-grid">
        <!-- Chart perbandingan -->
        <div class="card">
            <div class="card-head">
                <h3>
                    <div class="icon-badge" style="background:#eff6ff;color:var(--accent);"><i class="fas fa-chart-bar"></i></div>
                    Perbandingan Pelanggaran
                </h3>
                <div id="chartMonthLabel" style="font-size:.75rem;color:var(--muted);font-weight:600;"></div>
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
                    <div class="icon-badge" style="background:#f5f3ff;color:var(--accent2);"><i class="fas fa-chart-pie"></i></div>
                    Jenis Pelanggaran Bulan Ini
                </h3>
            </div>
            <div class="card-body">
                <div class="chart-wrap" style="height:220px;">
                    <canvas id="chartJenis"></canvas>
                </div>
                <div id="jenisLegend" style="margin-top:12px;font-size:.75rem;"></div>
            </div>
        </div>
    </div>

    <!-- ── BOTTOM GRID ── -->
    <div class="bottom-grid">

        <!-- Latest pelanggaran -->
        <div class="card">
            <div class="card-head">
                <h3>
                    <div class="icon-badge" style="background:#fef2f2;color:var(--danger);"><i class="fas fa-list-ul"></i></div>
                    Pelanggaran Terbaru
                </h3>
                <span style="font-size:.72rem;color:var(--muted);font-weight:600;">8 terakhir</span>
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
                    <div class="icon-badge" style="background:#fffbeb;color:var(--warning);"><i class="fas fa-calendar-check"></i></div>
                    Pelanggaran Hari Ini
                </h3>
                <span id="todayCount" style="font-size:.72rem;background:#fef2f2;color:var(--danger);font-weight:700;padding:3px 10px;border-radius:20px;">0</span>
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
const COLORS = ['#2563eb','#7c3aed','#059669','#dc2626','#d97706','#0891b2','#db2777','#16a34a'];

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
        const avatarColors = { admin:'#2563eb', guru:'#7c3aed', siswa:'#059669' };
        const bg = avatarColors[u.role] || '#6b7a99';
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

        // Build day 1-31 arrays
        const makeDayMap = arr => {
            const m = {};
            arr.forEach(r => { m[parseInt(r.day)] = parseInt(r.count); });
            return m;
        };

        // Get max days needed
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
                        backgroundColor: 'rgba(124,58,237,.18)',
                        borderColor: 'rgba(124,58,237,.7)',
                        borderWidth: 1.5,
                        borderRadius: 4,
                    },
                    {
                        label: d.this_month_name,
                        data: thisData,
                        backgroundColor: 'rgba(37,99,235,.22)',
                        borderColor: 'rgba(37,99,235,.85)',
                        borderWidth: 1.5,
                        borderRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { font: { family:'Plus Jakarta Sans', size:11 }, boxWidth:12 } },
                    tooltip: { mode:'index', intersect:false }
                },
                scales: {
                    x: { grid: { display:false }, ticks: { font:{size:10} } },
                    y: { beginAtZero:true, grid:{ color:'rgba(0,0,0,.05)' }, ticks:{ stepSize:1, font:{size:10} } }
                }
            }
        });
    });

// ── CHART: Jenis Pelanggaran ──────────────────────────────────
let chartJenis = null;
$.get('action_dashboard.php?action=chart_jenis')
    .done(function(data) {
        if (!data.length) {
            $('#jenisLegend').html('<div style="text-align:center;color:var(--muted);font-size:.78rem;padding:10px;">Belum ada data</div>');
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
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.raw} kasus`
                    }}
                }
            }
        });

        // Custom legend
        let legend = '';
        data.forEach((d, i) => {
            legend += `
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                    <div style="display:flex;align-items:center;gap:7px;">
                        <span style="width:10px;height:10px;border-radius:50%;background:${colors[i]};display:inline-block;flex-shrink:0;"></span>
                        <span style="font-weight:600;">${d.name}</span>
                    </div>
                    <span style="font-family:'JetBrains Mono',monospace;font-size:.75rem;font-weight:700;color:var(--muted);">${d.count}x</span>
                </div>`;
        });
        $('#jenisLegend').html(legend);
    });

// ── LATEST PELANGGARAN ────────────────────────────────────────
$.get('action_dashboard.php?action=latest&limit=8')
    .done(function(data) {
        if (!data.length) {
            $('#latestBody').html('<tr><td colspan="6"><div class="empty-state"><i class="fas fa-check-circle" style="color:var(--success);"></i>Belum ada pelanggaran</div></td></tr>');
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
        $('#latestBody').html('<tr><td colspan="6"><div class="empty-state">Gagal memuat data</div></td></tr>');
    });

// ── TODAY ─────────────────────────────────────────────────────
$.get('action_dashboard.php?action=today')
    .done(function(data) {
        $('#todayCount').text(data.length);
        if (!data.length) {
            $('#todayBody').html('<tr><td colspan="5"><div class="empty-state"><i class="fas fa-check-circle" style="color:var(--success);opacity:.6;"></i>Tidak ada pelanggaran hari ini</div></td></tr>');
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
        $('#todayBody').html('<tr><td colspan="5"><div class="empty-state">Gagal memuat data</div></td></tr>');
    });
</script>

<?php $this->stop() ?>