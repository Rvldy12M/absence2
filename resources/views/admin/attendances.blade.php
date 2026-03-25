@extends('layouts.app')

@section('title', 'Kehadiran')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

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
}

.adm-wrap {
    font-family: var(--font);
    background: var(--bg);
    min-height: 100vh;
    padding: 2.5rem 1.25rem 4rem;
    color: var(--text-primary);
}
.adm-inner { max-width: 1200px; margin: 0 auto; }

/* ── Header ── */
.adm-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}
.adm-eyebrow {
    display: inline-block;
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--accent);
    background: var(--accent-light);
    padding: 0.18rem 0.6rem;
    border-radius: 4px;
    margin-bottom: 0.4rem;
}
.adm-title {
    font-size: 1.9rem;
    font-weight: 700;
    letter-spacing: -0.03em;
    color: var(--text-primary);
    margin: 0;
    line-height: 1.15;
}

/* ── Card ── */
.adm-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}

/* ── Controls ── */
.adm-controls {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    gap: 0.75rem;
    padding: 1.25rem 1.25rem 1rem;
    border-bottom: 1.5px solid var(--border);
    background: var(--surface-2);
}
.adm-field {
    display: flex;
    flex-direction: column;
    gap: 0.28rem;
    min-width: 150px;
}
.adm-field.wide { flex: 2; min-width: 240px; }
.adm-label {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--text-muted);
}
.adm-input-wrap { position: relative; }
.adm-input-wrap svg {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    pointer-events: none;
}
.adm-input, .adm-select {
    height: 40px;
    width: 100%;
    padding: 0 0.85rem;
    border: 1.5px solid var(--border-strong);
    border-radius: var(--radius-sm);
    background: var(--surface);
    font-family: var(--font);
    font-size: 0.855rem;
    color: var(--text-primary);
    outline: none;
    transition: border-color 0.18s, box-shadow 0.18s;
    box-shadow: 0 1px 3px rgba(15,23,42,0.05);
    box-sizing: border-box;
}
.adm-input { padding-left: 2.35rem; }
.adm-input::placeholder { color: var(--text-muted); }
.adm-input:focus, .adm-select:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(59,91,219,0.1);
}

/* ── Export Button ── */
.btn-export {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    height: 40px;
    padding: 0 1.1rem;
    background: #16a34a;
    color: #fff;
    border: none;
    border-radius: var(--radius-sm);
    font-family: var(--font);
    font-size: 0.855rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.18s;
    white-space: nowrap;
    box-shadow: 0 2px 8px rgba(22,163,74,0.22);
    align-self: flex-end;
}
.btn-export:hover {
    background: #15803d;
    transform: translateY(-1px);
    box-shadow: 0 5px 14px rgba(22,163,74,0.28);
}

/* ── DataTables overrides ── */
.adm-table-wrap { padding: 0; }

#attendanceTable_wrapper .dataTables_length,
#attendanceTable_wrapper .dataTables_filter,
#attendanceTable_wrapper .dataTables_info,
#attendanceTable_wrapper .dataTables_paginate {
    font-family: var(--font);
    font-size: 0.78rem;
    color: var(--text-muted);
    padding: 0.75rem 1.25rem;
}
#attendanceTable_wrapper .dataTables_length select,
#attendanceTable_wrapper .dataTables_filter input {
    font-family: var(--font);
    font-size: 0.8rem;
    border: 1.5px solid var(--border-strong);
    border-radius: 6px;
    padding: 0.25rem 0.6rem;
    outline: none;
    color: var(--text-primary);
    background: var(--surface);
}
#attendanceTable_wrapper .dataTables_filter input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 2px rgba(59,91,219,0.1);
}

/* hide default search since we have our own */
#attendanceTable_wrapper .dataTables_filter { display: none; }

#attendanceTable_wrapper .dataTables_length,
#attendanceTable_wrapper .dataTables_info {
    padding-left: 1.25rem;
}
#attendanceTable_wrapper .dataTables_paginate {
    padding-right: 1.25rem;
}

/* Top row (length) */
#attendanceTable_wrapper > .dataTables_length { border-bottom: 1px solid var(--border); background: var(--surface-2); }

/* Bottom row */
.adm-dt-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1.5px solid var(--border);
    background: var(--surface-2);
    flex-wrap: wrap;
    gap: 0.5rem;
}

/* pagination buttons */
#attendanceTable_wrapper .dataTables_paginate .paginate_button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 30px;
    height: 30px;
    padding: 0 0.45rem;
    border: 1.5px solid var(--border-strong) !important;
    border-radius: 6px !important;
    background: var(--surface) !important;
    color: var(--text-secondary) !important;
    font-family: var(--font);
    font-size: 0.78rem !important;
    font-weight: 600;
    cursor: pointer;
    margin: 0 2px;
    transition: all 0.15s;
}
#attendanceTable_wrapper .dataTables_paginate .paginate_button:hover {
    background: var(--accent-light) !important;
    color: var(--accent) !important;
    border-color: var(--accent) !important;
}
#attendanceTable_wrapper .dataTables_paginate .paginate_button.current,
#attendanceTable_wrapper .dataTables_paginate .paginate_button.current:hover {
    background: var(--accent) !important;
    color: #fff !important;
    border-color: var(--accent) !important;
}
#attendanceTable_wrapper .dataTables_paginate .paginate_button.disabled,
#attendanceTable_wrapper .dataTables_paginate .paginate_button.disabled:hover {
    opacity: 0.35;
    cursor: not-allowed;
    background: var(--surface) !important;
    color: var(--text-muted) !important;
    border-color: var(--border) !important;
}

/* ── Table Core ── */
table#attendanceTable {
    width: 100% !important;
    border-collapse: collapse !important;
    font-size: 0.855rem;
    font-family: var(--font);
}
table#attendanceTable thead tr {
    background: var(--surface-2);
    border-bottom: 2px solid var(--border-strong);
}
table#attendanceTable thead th {
    padding: 0.85rem 1rem !important;
    text-align: left !important;
    font-size: 0.67rem !important;
    font-weight: 700 !important;
    letter-spacing: 0.09em !important;
    text-transform: uppercase;
    color: var(--text-muted) !important;
    white-space: nowrap;
    background: var(--surface-2) !important;
    border-bottom: none !important;
}
table#attendanceTable thead th.sorting::after,
table#attendanceTable thead th.sorting_asc::after,
table#attendanceTable thead th.sorting_desc::after {
    color: var(--accent) !important;
}
table#attendanceTable tbody tr { transition: background 0.1s; }
table#attendanceTable tbody tr:hover { background: #f4f6fd !important; }
table#attendanceTable tbody tr:nth-child(odd) { background: var(--surface); }
table#attendanceTable tbody tr:nth-child(even) { background: var(--surface-2); }
table#attendanceTable tbody td {
    padding: 0.85rem 1rem !important;
    vertical-align: middle !important;
    border-bottom: 1px solid var(--border) !important;
    color: var(--text-primary);
    text-align: left !important;
}
table#attendanceTable tbody tr:last-child td { border-bottom: none !important; }

/* ── Cell Styles ── */
.cell-id {
    font-family: var(--font-mono);
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 500;
}
.cell-name { font-weight: 600; color: var(--text-primary); }
.cell-email { font-size: 0.78rem; color: var(--text-secondary); }

.chip-time {
    display: inline-flex;
    align-items: center;
    gap: 0.28rem;
    font-family: var(--font-mono);
    font-size: 0.78rem;
    font-weight: 500;
    color: var(--text-secondary);
    background: var(--surface-2);
    border: 1px solid var(--border-strong);
    border-radius: 6px;
    padding: 0.2rem 0.5rem;
    white-space: nowrap;
}

.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.26rem 0.65rem;
    border-radius: 99px;
    font-size: 0.73rem;
    font-weight: 700;
    white-space: nowrap;
}
.badge-status::before {
    content: '';
    display: block;
    width: 6px; height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
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

.badge-method {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.2rem 0.55rem;
    border-radius: 6px;
    font-size: 0.73rem;
    font-weight: 600;
    background: var(--accent-light);
    color: var(--accent);
    border: 1px solid rgba(59,91,219,0.14);
}
.badge-qr {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.2rem 0.55rem;
    border-radius: 6px;
    font-size: 0.73rem;
    font-weight: 700;
    background: #f3e8ff;
    color: #7c3aed;
    border: 1px solid rgba(124,58,237,0.15);
}

.cell-loc-name { font-weight: 500; font-size: 0.82rem; color: var(--text-primary); }
.cell-loc-link {
    font-size: 0.73rem;
    color: var(--accent);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.2rem;
    margin-top: 2px;
}
.cell-loc-link:hover { text-decoration: underline; }
.cell-muted { font-size: 0.78rem; color: var(--text-muted); font-style: italic; }

.cell-photo img {
    width: 48px;
    height: 48px;
    object-fit: cover;
    border-radius: 8px;
    border: 1.5px solid var(--border-strong);
    display: block;
}
.cell-notes { font-size: 0.8rem; color: var(--text-secondary); font-style: italic; max-width: 140px; }

/* processing overlay */
#attendanceTable_processing {
    background: rgba(255,255,255,0.85) !important;
    border: 1.5px solid var(--border) !important;
    border-radius: var(--radius-sm) !important;
    color: var(--accent) !important;
    font-family: var(--font) !important;
    font-size: 0.85rem !important;
    font-weight: 600 !important;
    padding: 0.6rem 1.4rem !important;
    box-shadow: var(--shadow) !important;
}

@media (max-width: 640px) {
    .adm-title { font-size: 1.5rem; }
    table#attendanceTable thead th,
    table#attendanceTable tbody td { padding: 0.7rem 0.7rem !important; }
}
</style>

<div class="adm-wrap">
<div class="adm-inner">

    {{-- Header --}}
    <div class="adm-header">
        <div>
            <span class="adm-eyebrow">👥 Data Absensi</span>
            <h1 class="adm-title">Kehadiran Siswa</h1>
        </div>
    </div>

    {{-- Card --}}
    <div class="adm-card">

        {{-- Controls --}}
        <div class="adm-controls">
            <div class="adm-field wide">
                <span class="adm-label">Cari Siswa</span>
                <div class="adm-input-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <input type="text" id="searchFilter" class="adm-input" placeholder="Cari nama siswa, email, atau keterangan...">
                </div>
            </div>

            <div class="adm-field">
                <span class="adm-label">Tanggal</span>
                <input type="date" id="dateFilter" class="adm-select">
            </div>

            <div class="adm-field">
                <span class="adm-label">Kelas</span>
                <select id="classFilter" class="adm-select">
                    <option value="">Semua Kelas</option>
                    @foreach(\App\Models\Classroom::all() as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="adm-field">
                <span class="adm-label">Status</span>
                <select id="statusFilter" class="adm-select">
                    <option value="">Semua Status</option>
                    <option value="Hadir">Hadir</option>
                    <option value="Telat">Telat</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                </select>
            </div>

            <button id="exportExcel" class="btn-export">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export Excel
            </button>
        </div>

        {{-- Table --}}
        <div class="adm-table-wrap">
            <table id="attendanceTable" class="display w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Metode</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="10" class="text-center" style="padding:2rem;color:var(--text-muted);font-family:var(--font);">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
</div>

<!-- jQuery + DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
// ✅ Setup CSRF Token biar aman di hosting
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

$(document).ready(function () {
    // ✅ Inisialisasi DataTables
    const table = $('#attendanceTable').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: {
            url: "/admin/attendances/data",
            type: "GET",
            data: function (d) {
                d.date = $('#dateFilter').val();
                d.class_id = $('#classFilter').val();
                d.status = $('#statusFilter').val();
                d.search = $('#searchFilter').val();
            },
            error: function(xhr, status, error) {
                console.error("⚠️ Gagal memuat data:", error);
                console.error("Response:", xhr.responseText);
                alert('Gagal memuat data: ' + error);
            }
        },
        order: [[4, 'desc'], [5, 'desc']],
        columns: [
            {
                data: 'id',
                name: 'attendances.id',
                render: function(data) {
                    return `<span class="cell-id">${data}</span>`;
                }
            },
            {
                data: 'student_name',
                name: 'users.name',
                render: function(data) {
                    return `<span class="cell-name">${data}</span>`;
                }
            },
            {
                data: 'email',
                name: 'users.email',
                render: function(data) {
                    return `<span class="cell-email">${data}</span>`;
                }
            },
            { data: 'class_name', name: 'classrooms.name' },
            { data: 'date', name: 'attendances.date' },
            {
                data: 'time',
                name: 'attendances.time',
                render: function(data) {
                    if (!data) return '<span class="cell-muted">—</span>';
                    return `<span class="chip-time">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        ${data}
                    </span>`;
                }
            },
            {
                data: 'status',
                name: 'attendances.status',
                render: function(data) {
                    if (!data) return '<span class="cell-muted">—</span>';
                    return `<span class="badge-status s-${data}">${data}</span>`;
                }
            },
            {
                data: 'method',
                name: 'attendances.method',
                render: function(data) {
                    if (!data) return '<span class="cell-muted">—</span>';
                    if (data === 'qr') return `<span class="badge-qr">QR</span>`;
                    return `<span class="badge-method">${data}</span>`;
                }
            },
            {
                data: 'location',
                name: 'attendances.location',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    try {
                        const location = row.location;
                        const latitude = row.latitude;
                        const longitude = row.longitude;
                        
                        if (!location && !latitude && !longitude) {
                            return '<span class="cell-muted">—</span>';
                        }
                        
                        let html = '';
                        
                        if (location) {
                            html += `<span class="cell-loc-name">${location}</span>`;
                        } else {
                            html += '<span class="cell-muted">—</span>';
                        }
                        
                        if (latitude && longitude) {
                            const lat = parseFloat(latitude);
                            const lon = parseFloat(longitude);
                            
                            if (!isNaN(lat) && !isNaN(lon)) {
                                html += `<br/><a href="https://maps.google.com/?q=${lat},${lon}" 
                                       target="_blank" 
                                       class="cell-loc-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                        ${lat.toFixed(4)}, ${lon.toFixed(4)}
                                    </a>`;
                            }
                        }
                        
                        return html;
                    } catch (e) {
                        console.error('Error rendering location row:', row, 'Error:', e);
                        return '<span class="cell-muted">Error</span>';
                    }
                }
            },
            {
                data: 'photo',
                name: 'attendances.photo',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    const method = row.method;
                    const photo = row.photo;
                    const notes = row.notes;

                    if (method === 'qr') {
                        return '<span class="badge-qr">QR Verified</span>';
                    } else if (photo) {
                        return `
                            <a href="/storage/${photo}" target="_blank" class="cell-photo">
                                <img src="/storage/${photo}" alt="Foto absensi">
                            </a>`;
                    } else if (method === 'Form' && notes) {
                        return `<span class="cell-notes">${notes}</span>`;
                    } else {
                        return '<span class="cell-muted">No evidence</span>';
                    }
                }
            }
        ]
    });

    // ✅ Filter realtime (otomatis reload saat user ubah filter)
    $('#dateFilter, #statusFilter, #classFilter').on('change', function () {
        table.ajax.reload();
    });
    
    // ✅ Search dengan debounce (tunggu user selesai ketik)
    let searchTimeout;
    $('#searchFilter').on('keyup', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function () {
            table.ajax.reload();
        }, 300); // Tunggu 300ms setelah user berhenti ketik
    });

    // ✅ Export Excel sesuai filter aktif
    $('#exportExcel').on('click', function() {
        const date = $('#dateFilter').val();
        const status = $('#statusFilter').val();
        const class_id = $('#classFilter').val();
        
        // Build query string
        let params = new URLSearchParams();
        if (date) params.append('date', date);
        if (status) params.append('status', status);
        if (class_id) params.append('class_id', class_id);
        
        const queryString = params.toString();
        const url = '/admin/attendances/export' + (queryString ? '?' + queryString : '');
        
        console.log('🔗 Exporting with URL:', url);
        window.location.href = url;
    });
});
</script>
@endsection