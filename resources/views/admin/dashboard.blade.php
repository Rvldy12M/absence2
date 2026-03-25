@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
:root {
    --bg: #f0f2f8;
    --surface: #ffffff;
    --surface-2: #f7f8fc;
    --border: #e4e8f2;
    --border-strong: #cdd4e8;
    --text-primary: #0f172a;
    --text-secondary: #4b5a7a;
    --text-muted: #8896b3;
    --accent: #3b5bdb;
    --accent-light: #eef2ff;
    --font: 'Plus Jakarta Sans', sans-serif;
    --font-mono: 'JetBrains Mono', monospace;
    --radius: 14px;
    --radius-sm: 8px;
    --shadow: 0 2px 12px rgba(15,23,42,0.07), 0 1px 3px rgba(15,23,42,0.05);
    --shadow-md: 0 4px 20px rgba(15,23,42,0.09), 0 1px 4px rgba(15,23,42,0.06);
}

.db-wrap {
    font-family: var(--font);
    background: var(--bg);
    min-height: 100vh;
    padding: 2rem 1.25rem 4rem;
    color: var(--text-primary);
}
.db-inner { max-width: 1200px; margin: 0 auto; }

/* ── Welcome Banner ── */
.db-banner {
    background: linear-gradient(135deg, #1e3a8a 0%, #1e293b 60%, #0f172a 100%);
    border-radius: var(--radius);
    padding: 1.75rem 2rem;
    margin-bottom: 1.75rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 6px 28px rgba(30,58,138,0.28);
    animation: fadeUp 0.5s ease both;
}
.db-banner::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 260px; height: 260px;
    background: radial-gradient(circle, rgba(59,91,219,0.25) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.db-banner::after {
    content: '';
    position: absolute;
    bottom: -80px; left: 30%;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.db-banner-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    flex-wrap: wrap;
}
.db-banner-left h2 {
    font-size: 1.6rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 0.4rem;
    letter-spacing: -0.02em;
}
.db-banner-left p {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.82rem;
    color: rgba(147,197,253,0.9);
    margin: 0;
    font-weight: 500;
}
.db-banner-right {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}
.db-banner-stat {
    text-align: center;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 10px;
    padding: 0.65rem 1.1rem;
    min-width: 80px;
}
.db-banner-stat .bstat-val {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
    font-family: var(--font-mono);
}
.db-banner-stat .bstat-label {
    font-size: 0.67rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: rgba(147,197,253,0.75);
    margin-top: 0.25rem;
}

/* ── Stat Cards ── */
.db-stats {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 1rem;
    margin-bottom: 1.75rem;
}
@media (max-width: 1024px) { .db-stats { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 640px)  { .db-stats { grid-template-columns: repeat(2, 1fr); } }

.stat-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    padding: 1.2rem 1.25rem;
    box-shadow: var(--shadow);
    display: flex;
    align-items: flex-start;
    gap: 0.85rem;
    transition: transform 0.18s, box-shadow 0.18s;
    animation: fadeUp 0.5s ease both;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
.stat-card:nth-child(1) { animation-delay: 0.05s; }
.stat-card:nth-child(2) { animation-delay: 0.10s; }
.stat-card:nth-child(3) { animation-delay: 0.15s; }
.stat-card:nth-child(4) { animation-delay: 0.20s; }
.stat-card:nth-child(5) { animation-delay: 0.25s; }

.stat-icon {
    width: 44px; height: 44px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.stat-icon.blue   { background: #dbeafe; color: #2563eb; }
.stat-icon.green  { background: #dcfce7; color: #16a34a; }
.stat-icon.yellow { background: #fef9c3; color: #ca8a04; }
.stat-icon.purple { background: #f3e8ff; color: #9333ea; }
.stat-icon.red    { background: #fee2e2; color: #dc2626; }
.stat-icon.indigo { background: #e0e7ff; color: #4f46e5; }

.stat-body { flex: 1; min-width: 0; }
.stat-label {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: var(--text-muted);
    margin-bottom: 0.2rem;
}
.stat-value {
    font-size: 1.65rem;
    font-weight: 800;
    color: var(--text-primary);
    line-height: 1.1;
    font-family: var(--font-mono);
    letter-spacing: -0.02em;
}
.stat-sub {
    font-size: 0.72rem;
    color: var(--text-muted);
    margin-top: 0.2rem;
}

/* ── Cards generic ── */
.db-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    animation: fadeUp 0.5s ease both;
}
.db-card-head {
    padding: 1.1rem 1.25rem 0.75rem;
    border-bottom: 1px solid var(--border);
    background: var(--surface-2);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
}
.db-card-head-left h3 {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}
.db-card-head-left p {
    font-size: 0.73rem;
    color: var(--text-muted);
    margin: 0.15rem 0 0;
}
.db-card-body { padding: 1.25rem; }

/* ── Charts Row ── */
.db-charts {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 1rem;
    margin-bottom: 1.75rem;
}
@media (max-width: 900px) { .db-charts { grid-template-columns: 1fr; } }

.chart-donut-wrap {
    position: relative;
    width: 180px;
    height: 180px;
    margin: 0 auto 1rem;
}
.chart-donut-center {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    pointer-events: none;
}
.chart-donut-center .dc-val {
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--text-primary);
    font-family: var(--font-mono);
    line-height: 1;
}
.chart-donut-center .dc-label {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--text-muted);
    margin-top: 0.2rem;
}

.legend-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.4rem 1rem;
    margin-top: 0.25rem;
}
.legend-item {
    display: flex;
    align-items: center;
    gap: 0.45rem;
    font-size: 0.8rem;
    color: var(--text-secondary);
}
.legend-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}

/* ── Bottom Row ── */
.db-bottom {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.75rem;
}
@media (max-width: 860px) { .db-bottom { grid-template-columns: 1fr; } }

/* ── Attendance Rate Bar ── */
.rate-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.85rem;
}
.rate-row:last-child { margin-bottom: 0; }
.rate-label {
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--text-secondary);
    min-width: 52px;
}
.rate-bar-wrap {
    flex: 1;
    height: 8px;
    background: var(--surface-2);
    border-radius: 99px;
    overflow: hidden;
    border: 1px solid var(--border);
}
.rate-bar {
    height: 100%;
    border-radius: 99px;
    transition: width 1s cubic-bezier(.22,.68,0,1.1);
}
.rate-val {
    font-size: 0.78rem;
    font-weight: 700;
    font-family: var(--font-mono);
    color: var(--text-primary);
    min-width: 32px;
    text-align: right;
}

/* ── Quick Links ── */
.quick-links {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.6rem;
}
.ql-item {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.75rem 0.9rem;
    background: var(--surface-2);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    text-decoration: none;
    color: var(--text-primary);
    font-size: 0.82rem;
    font-weight: 600;
    transition: all 0.16s;
}
.ql-item:hover {
    background: var(--accent-light);
    border-color: var(--accent);
    color: var(--accent);
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(59,91,219,0.12);
}
.ql-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 1rem;
}

/* ── Recent Table ── */
.db-recent { margin-bottom: 1.75rem; animation-delay: 0.3s; }
.recent-tbl {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.845rem;
    font-family: var(--font);
}
.recent-tbl thead tr {
    background: var(--surface-2);
    border-bottom: 1.5px solid var(--border-strong);
}
.recent-tbl thead th {
    padding: 0.7rem 1rem;
    text-align: left;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    color: var(--text-muted);
    white-space: nowrap;
}
.recent-tbl tbody tr { transition: background 0.1s; }
.recent-tbl tbody tr:hover { background: #f4f6fd; }
.recent-tbl tbody td {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
    color: var(--text-primary);
}
.recent-tbl tbody tr:last-child td { border-bottom: none; }

.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.22rem 0.6rem;
    border-radius: 99px;
    font-size: 0.72rem;
    font-weight: 700;
    white-space: nowrap;
}
.badge-status::before {
    content: ''; display: block;
    width: 5px; height: 5px;
    border-radius: 50%; flex-shrink: 0;
}
.s-Hadir  { background: #e8faf0; color: #166534; }
.s-Hadir::before  { background: #22c55e; }
.s-Telat  { background: #fffbeb; color: #92400e; }
.s-Telat::before  { background: #f59e0b; }
.s-Izin   { background: #eef2ff; color: #3730a3; }
.s-Izin::before   { background: #6366f1; }
.s-Sakit  { background: #fff1f2; color: #9f1239; }
.s-Sakit::before  { background: #f43f5e; }
.s-Alpha  { background: #f1f5f9; color: #475569; }
.s-Alpha::before  { background: #94a3b8; }

.cell-muted { color: var(--text-muted); font-size: 0.78rem; }
.cell-mono  { font-family: var(--font-mono); font-size: 0.78rem; color: var(--text-secondary); }

/* ── Animations ── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

@media (max-width: 640px) {
    .db-banner-left h2 { font-size: 1.25rem; }
    .db-banner-right { display: none; }
    .db-charts { grid-template-columns: 1fr; }
    .quick-links { grid-template-columns: 1fr; }
}
</style>

<div class="db-wrap">
<div class="db-inner">

    {{-- ── Welcome Banner ── --}}
    <div class="db-banner">
        <div class="db-banner-content">
            <div class="db-banner-left">
                <h2>Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
                <p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    {{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div class="db-banner-right">
                @php $totalToday = array_sum($attendanceStats); @endphp
                <div class="db-banner-stat">
                    <div class="bstat-val">{{ $totalStudents }}</div>
                    <div class="bstat-label">Siswa</div>
                </div>
                <div class="db-banner-stat">
                    <div class="bstat-val">{{ $attendanceStats['Hadir'] }}</div>
                    <div class="bstat-label">Hadir Hari Ini</div>
                </div>
                <div class="db-banner-stat">
                    <div class="bstat-val">{{ $totalStudents > 0 ? round(($attendanceStats['Hadir'] ?? 0) / $totalStudents * 100) : 0 }}%</div>
                    <div class="bstat-label">Rate Hadir</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="db-stats">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-label">Total Siswa</div>
                <div class="stat-value">{{ $totalStudents }}</div>
                <div class="stat-sub">terdaftar</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-label">Hadir</div>
                <div class="stat-value" style="color:#16a34a">{{ $attendanceStats['Hadir'] ?? 0 }}</div>
                <div class="stat-sub">hari ini</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-label">Telat</div>
                <div class="stat-value" style="color:#ca8a04">{{ $attendanceStats['Telat'] ?? 0 }}</div>
                <div class="stat-sub">hari ini</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-label">Sakit</div>
                <div class="stat-value" style="color:#9333ea">{{ $attendanceStats['Sakit'] ?? 0 }}</div>
                <div class="stat-sub">hari ini</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon red">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-label">Alpha</div>
                <div class="stat-value" style="color:#dc2626">{{ $attendanceStats['Alpha'] ?? 0 }}</div>
                <div class="stat-sub">hari ini</div>
            </div>
        </div>
    </div>

    {{-- ── Charts ── --}}
    <div class="db-charts" style="animation-delay:0.2s">
        {{-- Donut --}}
        <div class="db-card">
            <div class="db-card-head">
                <div class="db-card-head-left">
                    <h3>Kehadiran Hari Ini</h3>
                    <p>Status per siswa</p>
                </div>
            </div>
            <div class="db-card-body">
                <div class="chart-donut-wrap">
                    <canvas id="attendanceChart"></canvas>
                    <div class="chart-donut-center">
                        <span class="dc-val">{{ $totalStudents }}</span>
                        <span class="dc-label">Siswa</span>
                    </div>
                </div>
                <div class="legend-grid">
                    <div class="legend-item"><span class="legend-dot" style="background:#22c55e"></span>Hadir: <strong>{{ $attendanceStats['Hadir'] ?? 0 }}</strong></div>
                    <div class="legend-item"><span class="legend-dot" style="background:#f59e0b"></span>Telat: <strong>{{ $attendanceStats['Telat'] ?? 0 }}</strong></div>
                    <div class="legend-item"><span class="legend-dot" style="background:#6366f1"></span>Izin: <strong>{{ $attendanceStats['Izin'] ?? 0 }}</strong></div>
                    <div class="legend-item"><span class="legend-dot" style="background:#a855f7"></span>Sakit: <strong>{{ $attendanceStats['Sakit'] ?? 0 }}</strong></div>
                    <div class="legend-item"><span class="legend-dot" style="background:#ef4444"></span>Alpha: <strong>{{ $attendanceStats['Alpha'] ?? 0 }}</strong></div>
                </div>
            </div>
        </div>

        {{-- Bar Chart --}}
        <div class="db-card">
            <div class="db-card-head">
                <div class="db-card-head-left">
                    <h3>Kehadiran per Kelas</h3>
                    <p>Rincian status per kelas hari ini</p>
                </div>
            </div>
            <div class="db-card-body">
                <div style="position:relative;height:240px;">
                    <canvas id="classChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Bottom Row ── --}}
    <div class="db-bottom">

        {{-- Attendance Rate --}}
        <div class="db-card" style="animation-delay:0.3s">
            <div class="db-card-head">
                <div class="db-card-head-left">
                    <h3>Distribusi Status</h3>
                    <p>Persentase dari total siswa</p>
                </div>
            </div>
            <div class="db-card-body">
                @php
                    $statuses = [
                        'Hadir'  => ['color' => '#22c55e', 'val' => $attendanceStats['Hadir']  ?? 0],
                        'Telat'  => ['color' => '#f59e0b', 'val' => $attendanceStats['Telat']  ?? 0],
                        'Izin'   => ['color' => '#6366f1', 'val' => $attendanceStats['Izin']   ?? 0],
                        'Sakit'  => ['color' => '#a855f7', 'val' => $attendanceStats['Sakit']  ?? 0],
                        'Alpha'  => ['color' => '#ef4444', 'val' => $attendanceStats['Alpha']  ?? 0],
                    ];
                @endphp
                @foreach($statuses as $label => $s)
                    @php $pct = $totalStudents > 0 ? round($s['val'] / $totalStudents * 100) : 0; @endphp
                    <div class="rate-row">
                        <span class="rate-label">{{ $label }}</span>
                        <div class="rate-bar-wrap">
                            <div class="rate-bar" style="width:{{ $pct }}%;background:{{ $s['color'] }}"></div>
                        </div>
                        <span class="rate-val">{{ $pct }}%</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="db-card" style="animation-delay:0.35s">
            <div class="db-card-head">
                <div class="db-card-head-left">
                    <h3>Menu Cepat</h3>
                    <p>Akses halaman admin</p>
                </div>
            </div>
            <div class="db-card-body">
                <div class="quick-links">
                    <a href="{{ route('admin.attendances') }}" class="ql-item">
                        <span class="ql-icon" style="background:#eef2ff">📋</span>
                        Data Kehadiran
                    </a>
                    <a href="{{ route('admin.students') }}" class="ql-item">
                        <span class="ql-icon" style="background:#dcfce7">🎓</span>
                        List Siswa
                    </a>
                    <a href="{{ route('admin.classrooms.index') }}" class="ql-item">
                        <span class="ql-icon" style="background:#fef9c3">🏫</span>
                        Manajemen Kelas
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="ql-item">
                        <span class="ql-icon" style="background:#f3e8ff">👤</span>
                        Manajemen User
                    </a>
                    <a href="{{ route('admin.roles.index') }}" class="ql-item">
                        <span class="ql-icon" style="background:#fee2e2">🔐</span>
                        Manajemen Role
                    </a>
                    <a href="{{ route('admin.attendances.export') }}" class="ql-item">
                        <span class="ql-icon" style="background:#dcfce7">📥</span>
                        Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!--{{-- ── Recent Attendance ── --}}
    <div class="db-card db-recent">
        <div class="db-card-head">
            <div class="db-card-head-left">
                <h3>Absensi Terbaru</h3>
                <p>10 data kehadiran terakhir hari ini</p>
            </div>
            <a href="{{ route('admin.attendances') }}" style="font-size:0.78rem;font-weight:700;color:var(--accent);text-decoration:none;">
                Lihat Semua →
            </a>
        </div>
        <div style="overflow-x:auto;">
            <table class="recent-tbl">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Metode</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAttendances ?? [] as $att)
                    <tr>
                        <td style="font-weight:600;">{{ $att->user->name ?? '—' }}</td>
                        <td class="cell-muted">{{ $att->user->student->classroom->name ?? '—' }}</td>
                        <td class="cell-mono">{{ $att->time ?? $att->check_in_time ?? '—' }}</td>
                        <td><span class="badge-status s-{{ $att->status }}">{{ $att->status }}</span></td>
                        <td class="cell-muted">{{ ucfirst($att->method ?? '—') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-muted);font-size:0.875rem;">
                            Belum ada absensi hari ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>>
    </div>-->

</div>
</div>

<script>
// ── Donut Chart ──
new Chart(document.getElementById('attendanceChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($attendanceStats)) !!},
        datasets: [{
            data: {!! json_encode(array_values($attendanceStats)) !!},
            backgroundColor: [
                'rgba(34,197,94,0.88)',
                'rgba(245,158,11,0.88)',
                'rgba(99,102,241,0.88)',
                'rgba(168,85,247,0.88)',
                'rgba(239,68,68,0.88)',
            ],
            borderColor: '#ffffff',
            borderWidth: 3,
            hoverOffset: 12,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '68%',
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(15,23,42,0.9)',
                padding: 10,
                cornerRadius: 8,
                callbacks: {
                    label: function(ctx) {
                        const total = {{ $totalStudents }};
                        const pct = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                        return ' ' + ctx.parsed + ' siswa (' + pct + '%)';
                    }
                }
            }
        },
        animation: { animateScale: true, animateRotate: true, duration: 900 }
    }
});

// ── Bar Chart ──
new Chart(document.getElementById('classChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($classData)) !!},
        datasets: [
            { label: 'Hadir', backgroundColor: 'rgba(34,197,94,0.82)',  borderRadius: 4, data: {!! json_encode(array_column($classData, 'Hadir')) !!} },
            { label: 'Telat', backgroundColor: 'rgba(245,158,11,0.82)', borderRadius: 4, data: {!! json_encode(array_column($classData, 'Telat')) !!} },
            { label: 'Izin',  backgroundColor: 'rgba(99,102,241,0.82)', borderRadius: 4, data: {!! json_encode(array_column($classData, 'Izin'))  !!} },
            { label: 'Sakit', backgroundColor: 'rgba(168,85,247,0.82)', borderRadius: 4, data: {!! json_encode(array_column($classData, 'Sakit')) !!} },
            { label: 'Alpha', backgroundColor: 'rgba(239,68,68,0.82)',  borderRadius: 4, data: {!! json_encode(array_column($classData, 'Alpha')) !!} },
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 12,
                    font: { size: 11, family: "'Plus Jakarta Sans', sans-serif" },
                    usePointStyle: true,
                    pointStyleWidth: 8,
                }
            },
            tooltip: {
                backgroundColor: 'rgba(15,23,42,0.9)',
                padding: 10,
                cornerRadius: 8,
            }
        },
        scales: {
            x: {
                stacked: true,
                grid: { display: false },
                ticks: { font: { size: 11, family: "'Plus Jakarta Sans', sans-serif" } }
            },
            y: {
                stacked: true,
                beginAtZero: true,
                grid: { color: 'rgba(148,163,184,0.12)' },
                ticks: {
                    callback: v => Number.isInteger(v) ? v : '',
                    font: { size: 11, family: "'Plus Jakarta Sans', sans-serif" }
                }
            }
        },
        animation: { duration: 900 }
    }
});
</script>

@endsection