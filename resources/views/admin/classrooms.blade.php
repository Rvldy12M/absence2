@extends('layouts.app')

@section('title', 'Manajemen Kelas')

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

.cls-wrap {
    font-family: var(--font);
    background: var(--bg);
    min-height: 100vh;
    padding: 2.5rem 1.25rem 4rem;
    color: var(--text-primary);
}
.cls-inner { max-width: 1100px; margin: 0 auto; }

/* ── Header ── */
.cls-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}
.cls-eyebrow {
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
.cls-title {
    font-size: 1.9rem;
    font-weight: 700;
    letter-spacing: -0.03em;
    color: var(--text-primary);
    margin: 0;
    line-height: 1.15;
}
.cls-subtitle {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: 0.3rem 0 0;
}
.cls-actions { display: flex; gap: 0.6rem; align-items: flex-start; margin-top: 6px; flex-wrap: wrap; }

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
    text-decoration: none;
    cursor: pointer;
    transition: all 0.18s;
    white-space: nowrap;
    box-shadow: 0 2px 8px rgba(22,163,74,0.22);
}
.btn-export:hover {
    background: #15803d;
    transform: translateY(-1px);
    box-shadow: 0 5px 14px rgba(22,163,74,0.28);
    color: #fff;
}
.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    height: 40px;
    padding: 0 1.1rem;
    background: var(--accent);
    color: #fff;
    border: none;
    border-radius: var(--radius-sm);
    font-family: var(--font);
    font-size: 0.855rem;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.18s;
    white-space: nowrap;
    box-shadow: 0 2px 8px rgba(59,91,219,0.22);
}
.btn-add:hover {
    background: #2f4ac4;
    transform: translateY(-1px);
    box-shadow: 0 5px 14px rgba(59,91,219,0.28);
    color: #fff;
}

/* ── Alert ── */
.cls-alert {
    display: flex;
    align-items: flex-start;
    gap: 0.65rem;
    background: #f0fdf4;
    border: 1.5px solid #bbf7d0;
    border-radius: var(--radius-sm);
    padding: 0.75rem 1rem;
    margin-bottom: 1.25rem;
    font-size: 0.875rem;
    color: #166534;
    font-weight: 500;
}
.cls-alert svg { flex-shrink: 0; margin-top: 1px; }

/* ── Card ── */
.cls-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}

/* ── DataTables overrides ── */
#classroomsTable_wrapper .dataTables_length,
#classroomsTable_wrapper .dataTables_filter,
#classroomsTable_wrapper .dataTables_info,
#classroomsTable_wrapper .dataTables_paginate {
    font-family: var(--font);
    font-size: 0.78rem;
    color: var(--text-muted);
    padding: 0.75rem 1.25rem;
}
#classroomsTable_wrapper .dataTables_length {
    border-bottom: 1px solid var(--border);
    background: var(--surface-2);
}
#classroomsTable_wrapper .dataTables_length select,
#classroomsTable_wrapper .dataTables_filter input {
    font-family: var(--font);
    font-size: 0.8rem;
    border: 1.5px solid var(--border-strong);
    border-radius: 6px;
    padding: 0.22rem 0.55rem;
    outline: none;
    color: var(--text-primary);
    background: var(--surface);
}
#classroomsTable_wrapper .dataTables_length select:focus,
#classroomsTable_wrapper .dataTables_filter input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 2px rgba(59,91,219,0.1);
}
#classroomsTable_wrapper .dataTables_paginate {
    border-top: 1.5px solid var(--border);
    background: var(--surface-2);
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.25rem;
}
#classroomsTable_wrapper .dataTables_info {
    border-top: 1.5px solid var(--border);
    background: var(--surface-2);
}
#classroomsTable_wrapper .dataTables_paginate .paginate_button {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    min-width: 30px;
    height: 30px;
    padding: 0 0.45rem !important;
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
    box-shadow: none !important;
}
#classroomsTable_wrapper .dataTables_paginate .paginate_button:hover {
    background: var(--accent-light) !important;
    color: var(--accent) !important;
    border-color: var(--accent) !important;
}
#classroomsTable_wrapper .dataTables_paginate .paginate_button.current,
#classroomsTable_wrapper .dataTables_paginate .paginate_button.current:hover {
    background: var(--accent) !important;
    color: #fff !important;
    border-color: var(--accent) !important;
}
#classroomsTable_wrapper .dataTables_paginate .paginate_button.disabled,
#classroomsTable_wrapper .dataTables_paginate .paginate_button.disabled:hover {
    opacity: 0.35;
    cursor: not-allowed;
    background: var(--surface) !important;
    color: var(--text-muted) !important;
    border-color: var(--border) !important;
}

/* ── Table Core ── */
table#classroomsTable {
    width: 100% !important;
    border-collapse: collapse !important;
    font-size: 0.855rem;
    font-family: var(--font);
}
table#classroomsTable thead tr {
    background: var(--surface-2);
    border-bottom: 2px solid var(--border-strong);
}
table#classroomsTable thead th {
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
table#classroomsTable thead th.sorting_asc::after,
table#classroomsTable thead th.sorting_desc::after { color: var(--accent) !important; }

table#classroomsTable tbody tr { transition: background 0.1s; }
table#classroomsTable tbody tr:hover { background: #f4f6fd !important; }
table#classroomsTable tbody tr:nth-child(odd)  { background: var(--surface); }
table#classroomsTable tbody tr:nth-child(even) { background: var(--surface-2); }
table#classroomsTable tbody td {
    padding: 0.85rem 1rem !important;
    vertical-align: middle !important;
    border-bottom: 1px solid var(--border) !important;
    color: var(--text-primary);
    text-align: left !important;
}
table#classroomsTable tbody tr:last-child td { border-bottom: none !important; }

#classroomsTable_processing {
    background: rgba(255,255,255,0.88) !important;
    border: 1.5px solid var(--border) !important;
    border-radius: var(--radius-sm) !important;
    color: var(--accent) !important;
    font-family: var(--font) !important;
    font-size: 0.85rem !important;
    font-weight: 600 !important;
    padding: 0.6rem 1.4rem !important;
    box-shadow: var(--shadow) !important;
}

/* ── Delete Modal ── */
.del-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(8,14,30,0.55);
    backdrop-filter: blur(5px);
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.del-modal-overlay.open { display: flex; animation: mfade 0.2s; }
@keyframes mfade { from { opacity: 0; } to { opacity: 1; } }
.del-modal-box {
    background: var(--surface);
    border-radius: var(--radius);
    box-shadow: 0 24px 60px rgba(8,14,30,0.22);
    overflow: hidden;
    max-width: 440px;
    width: 100%;
    animation: mslide 0.22s cubic-bezier(.22,.68,0,1.1);
}
@keyframes mslide { from { transform: translateY(18px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.del-modal-head {
    background: #ef4444;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.del-modal-head-left { display: flex; align-items: center; gap: 0.65rem; }
.del-modal-head-icon {
    width: 34px; height: 34px;
    background: rgba(255,255,255,0.18);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.del-modal-head h3 { font-size: 0.95rem; font-weight: 700; color: #fff; margin: 0; }
.del-modal-head p  { font-size: 0.72rem; color: rgba(255,255,255,0.78); margin: 0.1rem 0 0; }
.del-modal-close {
    width: 28px; height: 28px;
    background: rgba(255,255,255,0.15);
    border: none;
    border-radius: 6px;
    color: rgba(255,255,255,0.85);
    font-size: 1rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.15s;
    font-family: var(--font);
}
.del-modal-close:hover { background: rgba(255,255,255,0.28); color: #fff; }
.del-modal-body { padding: 1.25rem; }
.del-modal-body p { font-size: 0.875rem; color: var(--text-secondary); margin: 0.35rem 0 0; }
.del-modal-body strong { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); }
.del-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    padding: 0 1.25rem 1.25rem;
}
.btn-cancel {
    height: 36px;
    padding: 0 1rem;
    border: 1.5px solid var(--border-strong);
    border-radius: var(--radius-sm);
    background: var(--surface);
    color: var(--text-secondary);
    font-family: var(--font);
    font-size: 0.855rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
}
.btn-cancel:hover { background: var(--surface-2); }
.btn-delete-confirm {
    height: 36px;
    padding: 0 1rem;
    border: none;
    border-radius: var(--radius-sm);
    background: #ef4444;
    color: #fff;
    font-family: var(--font);
    font-size: 0.855rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}
.btn-delete-confirm:hover { background: #dc2626; }

@media (max-width: 640px) {
    .cls-title { font-size: 1.5rem; }
    table#classroomsTable thead th,
    table#classroomsTable tbody td { padding: 0.7rem 0.7rem !important; }
}
</style>

<div class="cls-wrap">
<div class="cls-inner">

    {{-- Header --}}
    <div class="cls-header">
        <div>
            <span class="cls-eyebrow">🏫 Data Kelas</span>
            <h1 class="cls-title">Manajemen Kelas</h1>
            <p class="cls-subtitle">Kelola data master kelas dan siswa</p>
        </div>
        <div class="cls-actions">
            <a href="{{ route('admin.classrooms.export') }}" class="btn-export">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export Excel
            </a>
            <a href="{{ route('admin.classrooms.create') }}" class="btn-add">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Kelas
            </a>
        </div>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="cls-alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="cls-card">
        <div style="overflow-x:auto;">
            <table id="classroomsTable" class="display w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kelas</th>
                        <th>Jumlah Siswa</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>
</div>

{{-- Delete Modal --}}
<div id="deleteModal" class="del-modal-overlay">
    <div class="del-modal-box">
        <div class="del-modal-head">
            <div class="del-modal-head-left">
                <div class="del-modal-head-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                </div>
                <div>
                    <h3>Konfirmasi Hapus</h3>
                    <p>Hati-hati, aksi ini permanen.</p>
                </div>
            </div>
            <button type="button" id="closeDeleteModal" class="del-modal-close">✕</button>
        </div>
        <div class="del-modal-body">
            <strong>Apakah kamu yakin ingin menghapus data ini?</strong>
            <p>Data yang dihapus tidak dapat dikembalikan.</p>
        </div>
        <div class="del-modal-footer">
            <button id="cancelDeleteBtn" class="btn-cancel">Batal</button>
            <button type="button" id="confirmDeleteBtn" class="btn-delete-confirm">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                Hapus
            </button>
        </div>
    </div>
</div>

<!-- jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#classroomsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/admin/classrooms/data",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'student_count', name: 'student_count', orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at', orderable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        columnDefs: [
            { width: '10%', targets: 0 },
            { width: '25%', targets: 1 },
            { width: '15%', targets: 2 },
            { width: '20%', targets: 3 },
            { width: '30%', targets: 4 }
        ],
        language: {
            processing: "Memproses...",
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            emptyTable: "Tidak ada data",
            infoEmpty: "Tidak ada data",
            zeroRecords: "Tidak ada data yang cocok"
        }
    });

    let selectedDeleteForm = null;
    const modal = document.getElementById('deleteModal');
    const closeModalBtn = document.getElementById('closeDeleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

    function openDeleteModal() {
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }

    $(document).on('click', '.delete-btn', function () {
        selectedDeleteForm = $(this).closest('form');
        openDeleteModal();
    });

    $('#confirmDeleteBtn').on('click', function () {
        if (selectedDeleteForm) {
            selectedDeleteForm.submit();
        }
    });

    closeModalBtn?.addEventListener('click', closeDeleteModal);
    cancelDeleteBtn?.addEventListener('click', closeDeleteModal);
    modal?.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeDeleteModal();
        }
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
});
</script>
@endsection