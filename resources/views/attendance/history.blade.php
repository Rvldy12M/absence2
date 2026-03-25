@extends('layouts.app')

@section('title', 'Riwayat Kehadiran')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

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

.att-wrap {
    font-family: var(--font);
    background: var(--bg);
    min-height: 100vh;
    padding: 2.5rem 1.25rem 4rem;
    color: var(--text-primary);
}
.att-inner { max-width: 1080px; margin: 0 auto; }

/* ── Header ── */
.att-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}
.att-eyebrow {
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
.att-title {
    font-size: 1.9rem;
    font-weight: 700;
    letter-spacing: -0.03em;
    color: var(--text-primary);
    margin: 0;
    line-height: 1.15;
}
.att-back {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.55rem 1.1rem;
    background: var(--surface);
    border: 1.5px solid var(--border-strong);
    border-radius: var(--radius-sm);
    color: var(--text-secondary);
    font-size: 0.85rem;
    font-weight: 600;
    font-family: var(--font);
    text-decoration: none;
    transition: all 0.18s;
    box-shadow: var(--shadow);
    cursor: pointer;
    margin-top: 6px;
}
.att-back:hover {
    background: var(--accent);
    color: #fff;
    border-color: var(--accent);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(59,91,219,0.22);
}

/* ── Controls ── */
.att-controls {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 1.1rem;
    flex-wrap: wrap;
}
.att-field {
    display: flex;
    flex-direction: column;
    gap: 0.28rem;
    flex: 1;
    min-width: 180px;
}
.att-label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--text-muted);
}
.att-search-box {
    position: relative;
    flex: 2;
    min-width: 220px;
    display: flex;
    flex-direction: column;
    gap: 0.28rem;
}
.att-input-wrap { position: relative; }
.att-input-wrap svg {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    pointer-events: none;
}
.att-input, .att-select {
    height: 41px;
    width: 100%;
    padding: 0 0.85rem;
    border: 1.5px solid var(--border-strong);
    border-radius: var(--radius-sm);
    background: var(--surface);
    font-family: var(--font);
    font-size: 0.875rem;
    color: var(--text-primary);
    outline: none;
    transition: border-color 0.18s, box-shadow 0.18s;
    box-shadow: var(--shadow);
    box-sizing: border-box;
}
.att-input { padding-left: 2.4rem; }
.att-input::placeholder { color: var(--text-muted); }
.att-input:focus, .att-select:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(59,91,219,0.1);
}

/* ── Card ── */
.att-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}
.att-table-scroll { overflow-x: auto; }

/* ── Table ── */
.att-tbl {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.865rem;
}
.att-tbl thead tr {
    background: var(--surface-2);
    border-bottom: 2px solid var(--border-strong);
}
.att-tbl th {
    padding: 0.85rem 1rem;
    text-align: left;
    font-size: 0.67rem;
    font-weight: 700;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    color: var(--text-muted);
    white-space: nowrap;
    cursor: pointer;
    user-select: none;
}
.att-tbl th.sortable:hover { color: var(--accent); }
.att-tbl th.sort-asc::after  { content: ' ↑'; color: var(--accent); }
.att-tbl th.sort-desc::after { content: ' ↓'; color: var(--accent); }
.att-tbl th.no-sort { cursor: default; }

.att-tbl tbody tr { transition: background 0.1s; }
.att-tbl tbody tr:hover { background: #f4f6fd; }
.att-tbl td {
    padding: 0.85rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid var(--border);
    color: var(--text-primary);
}
.att-tbl tbody tr:last-child td { border-bottom: none; }

/* ── Cells ── */
.cell-num {
    font-family: var(--font-mono);
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 500;
    min-width: 30px;
}
.cell-date .d-main { font-weight: 600; font-size: 0.875rem; }
.cell-date .d-year { font-size: 0.72rem; color: var(--text-muted); margin-top: 1px; }

.chip-time {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-family: var(--font-mono);
    font-size: 0.78rem;
    font-weight: 500;
    color: var(--text-secondary);
    background: var(--surface-2);
    border: 1px solid var(--border-strong);
    border-radius: 6px;
    padding: 0.22rem 0.55rem;
    white-space: nowrap;
}

.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 0.32rem;
    padding: 0.26rem 0.7rem;
    border-radius: 99px;
    font-size: 0.74rem;
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
    gap: 0.28rem;
    padding: 0.22rem 0.6rem;
    border-radius: 6px;
    font-size: 0.74rem;
    font-weight: 600;
    background: var(--accent-light);
    color: var(--accent);
    border: 1px solid rgba(59,91,219,0.14);
}

.cell-loc, .cell-notes {
    max-width: 150px;
    font-size: 0.8rem;
    color: var(--text-secondary);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: block;
}
.cell-muted { font-size: 0.78rem; color: var(--text-muted); }

.btn-photo {
    display: inline-flex;
    align-items: center;
    gap: 0.28rem;
    padding: 0.25rem 0.65rem;
    background: var(--accent-light);
    color: var(--accent);
    border: 1px solid rgba(59,91,219,0.16);
    border-radius: 6px;
    font-size: 0.78rem;
    font-weight: 600;
    font-family: var(--font);
    cursor: pointer;
    transition: all 0.15s;
}
.btn-photo:hover { background: var(--accent); color: #fff; border-color: var(--accent); }

/* ── Footer Pagination ── */
.att-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.8rem 1rem;
    border-top: 1.5px solid var(--border);
    background: var(--surface-2);
    gap: 1rem;
    flex-wrap: wrap;
}
.page-info { font-size: 0.78rem; color: var(--text-muted); }
.page-btns { display: flex; gap: 0.28rem; }
.page-btn {
    min-width: 32px;
    height: 32px;
    border: 1.5px solid var(--border-strong);
    border-radius: 6px;
    background: var(--surface);
    color: var(--text-secondary);
    font-family: var(--font);
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
    padding: 0 0.5rem;
}
.page-btn:hover:not(:disabled) { background: var(--accent-light); color: var(--accent); border-color: var(--accent); }
.page-btn.active { background: var(--accent); color: #fff; border-color: var(--accent); }
.page-btn:disabled { opacity: 0.35; cursor: not-allowed; }

/* ── No Results ── */
#noResultsRow { display: none; }
#noResultsRow td { text-align: center; padding: 2.5rem; color: var(--text-muted); font-size: 0.875rem; }

/* ── Empty State ── */
.att-empty { padding: 4rem 1rem; text-align: center; }
.att-empty-icon { font-size: 2.5rem; margin-bottom: 0.75rem; }
.att-empty h3 { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0 0 0.35rem; }
.att-empty p { font-size: 0.85rem; color: var(--text-muted); margin: 0; }

/* ── Photo Modal ── */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(8,14,30,0.6);
    backdrop-filter: blur(5px);
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.modal-overlay.open { display: flex; animation: mfade 0.2s; }
@keyframes mfade { from { opacity: 0; } to { opacity: 1; } }
.modal-box {
    background: var(--surface);
    border-radius: var(--radius);
    box-shadow: 0 24px 60px rgba(8,14,30,0.25);
    overflow: hidden;
    max-width: 660px;
    width: 100%;
    animation: mslide 0.22s cubic-bezier(.22,.68,0,1.1);
}
@keyframes mslide { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.modal-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.9rem 1.2rem;
    border-bottom: 1.5px solid var(--border);
}
.modal-head h3 { font-size: 0.95rem; font-weight: 700; margin: 0; color: var(--text-primary); }
.modal-head p { font-size: 0.72rem; color: var(--text-muted); margin: 0.12rem 0 0; }
.modal-close {
    width: 30px; height: 30px;
    border: 1.5px solid var(--border-strong);
    border-radius: 6px;
    background: var(--surface-2);
    color: var(--text-secondary);
    font-size: 1rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.15s;
    font-family: var(--font);
    line-height: 1;
}
.modal-close:hover { background: #fee2e2; border-color: #fca5a5; color: #dc2626; }
.modal-body { padding: 1.2rem; background: var(--surface-2); }
.modal-body img {
    width: 100%;
    max-height: 430px;
    object-fit: contain;
    border-radius: 10px;
    border: 1.5px solid var(--border);
    background: var(--bg);
}

@media (max-width: 640px) {
    .att-title { font-size: 1.5rem; }
    .att-tbl th, .att-tbl td { padding: 0.7rem 0.7rem; }
}
</style>

<div class="att-wrap">
<div class="att-inner">

    {{-- Header --}}
    <div class="att-header">
        <div>
            <span class="att-eyebrow">📋 Rekap Absensi</span>
            <h1 class="att-title">Riwayat Kehadiran</h1>
        </div>
        <a href="{{ route('attendance.index') }}" class="att-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Kembali ke Kamera
        </a>
    </div>

    @if($attendances->count() > 0)

    {{-- Controls --}}
    <div class="att-controls">
        <div class="att-search-box">
            <span class="att-label">Cari Data</span>
            <div class="att-input-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input id="searchInput" class="att-input" type="text" placeholder="Cari nama, lokasi, keterangan...">
            </div>
        </div>
        <div class="att-field" style="max-width:200px">
            <span class="att-label">Filter Status</span>
            <select id="statusFilter" class="att-select">
                <option value="">Semua Status</option>
                <option value="Hadir">Hadir</option>
                <option value="Telat">Telat</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
                <option value="Alpha">Alpha</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="att-card">
        <div class="att-table-scroll">
            <table class="att-tbl">
                <thead>
                    <tr>
                        <th class="no-sort">#</th>
                        <th class="no-sort">Tanggal</th>
                        <th class="no-sort">Waktu</th>
                        <th class="no-sort">Status</th>
                        <th class="no-sort">Metode</th>
                        <th class="no-sort">Lokasi</th>
                        <th class="no-sort">Foto</th>
                        <th class="no-sort">Keterangan</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($attendances as $index => $attendance)
                    <tr
                        data-date="{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}"
                        data-status="{{ $attendance->status }}"
                        data-ts="{{ \Carbon\Carbon::parse($attendance->date)->timestamp }}"
                        data-search="{{ strtolower(\Carbon\Carbon::parse($attendance->date)->format('d M Y') . ' ' . ($attendance->location ?? '') . ' ' . ($attendance->notes ?? '') . ' ' . $attendance->status . ' ' . ($attendance->method ?? '')) }}"
                    >
                        <td class="cell-num">{{ $index + 1 }}</td>
                        <td>
                            <div class="cell-date">
                                <div class="d-main">{{ \Carbon\Carbon::parse($attendance->date)->format('d M') }}</div>
                                <div class="d-year">{{ \Carbon\Carbon::parse($attendance->date)->format('Y') }}</div>
                            </div>
                        </td>
                        <td>
                            @php $t = $attendance->time ?? $attendance->check_in_time ?? null; @endphp
                            @if($t)
                                <span class="chip-time">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    {{ $t }}
                                </span>
                            @else
                                <span class="cell-muted">—</span>
                            @endif
                        </td>
                        <td><span class="badge-status s-{{ $attendance->status }}">{{ $attendance->status }}</span></td>
                        <td>
                            @if($attendance->method)
                                <span class="badge-method">{{ ucfirst($attendance->method) }}</span>
                            @else
                                <span class="cell-muted">—</span>
                            @endif
                        </td>
                        <td><span class="cell-loc" title="{{ $attendance->location ?? '' }}">{{ $attendance->location ?? '—' }}</span></td>
                        <td>
                            @if($attendance->photo)
                                <button type="button" class="btn-photo" onclick="openModal('{{ asset('storage/' . $attendance->photo) }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                    Lihat
                                </button>
                            @else
                                <span class="cell-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td><span class="cell-notes" title="{{ $attendance->notes ?? '' }}">{{ $attendance->notes ?? '—' }}</span></td>
                    </tr>
                    @endforeach

                    <tr id="noResultsRow">
                        <td colspan="8">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 0.6rem;color:#94a3b8"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                            Tidak ada data yang sesuai pencarian.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="att-footer">
            <span class="page-info" id="pageInfo"></span>
            <div class="page-btns" id="pageBtns"></div>
        </div>
    </div>

    @else
    <div class="att-card">
        <div class="att-empty">
            <div class="att-empty-icon">📭</div>
            <h3>Belum Ada Data</h3>
            <p>Riwayat kehadiran akan muncul setelah absensi pertama.</p>
        </div>
    </div>
    @endif

</div>
</div>

{{-- Photo Modal --}}
<div id="photoModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-head">
            <div>
                <h3>Foto Absensi</h3>
                <p>Klik di luar atau tekan Esc untuk menutup.</p>
            </div>
            <button type="button" class="modal-close" onclick="closeModal()">✕</button>
        </div>
        <div class="modal-body">
            <img id="modalImg" src="" alt="Foto Absensi">
        </div>
    </div>
</div>

<script>
(function(){
    window.openModal = function(url){
        document.getElementById('modalImg').src = url;
        document.getElementById('photoModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    };
    window.closeModal = function(){
        document.getElementById('photoModal').classList.remove('open');
        document.getElementById('modalImg').src = '';
        document.body.style.overflow = '';
    };
    document.getElementById('photoModal').addEventListener('click', function(e){
        if(e.target === this) closeModal();
    });
    document.addEventListener('keydown', function(e){
        if(e.key === 'Escape') closeModal();
    });

    const PER_PAGE = 10;
    let page = 1, sortCol = 1, sortDir = 'desc', filtered = [];

    const tbody    = document.getElementById('tableBody');
    const searchEl = document.getElementById('searchInput');
    const statusEl = document.getElementById('statusFilter');

    if(!tbody || !searchEl) return;

    const allRows = Array.from(tbody.querySelectorAll('tr[data-date]'));
    const noRow   = document.getElementById('noResultsRow');

    function sortVal(row, col){
        if(col === 1) return parseInt(row.dataset.ts || '0');
        if(col === 3) return (row.dataset.status || '').toLowerCase();
        return '';
    }

    function doSort(rows){
        return rows.slice().sort((a,b)=>{
            const va = sortVal(a, sortCol), vb = sortVal(b, sortCol);
            if(typeof va === 'number') return sortDir === 'asc' ? va-vb : vb-va;
            return sortDir === 'asc' ? va.localeCompare(vb) : vb.localeCompare(va);
        });
    }

    function filter(){
        const q = (searchEl.value||'').toLowerCase();
        const s = (statusEl.value||'').toLowerCase();
        filtered = allRows.filter(r=>{
            const ms  = !q || (r.dataset.search||'').includes(q);
            const mst = !s || (r.dataset.status||'').toLowerCase() === s;
            return ms && mst;
        });
        page = 1;
        render();
    }

    function render(){
        const sorted = doSort(filtered);
        const total  = sorted.length;
        const pages  = Math.max(1, Math.ceil(total/PER_PAGE));
        if(page > pages) page = pages;

        const from  = (page-1)*PER_PAGE;
        const slice = sorted.slice(from, from+PER_PAGE);

        allRows.forEach(r => r.style.display = 'none');
        slice.forEach((r,i)=>{
            r.style.display = '';
            r.querySelector('.cell-num').textContent = from+i+1;
        });
        noRow.style.display = total === 0 ? '' : 'none';

        document.getElementById('pageInfo').textContent = total > 0
            ? 'Menampilkan '+(from+1)+'–'+Math.min(from+PER_PAGE,total)+' dari '+total+' data'
            : 'Tidak ada data';

        const btnWrap = document.getElementById('pageBtns');
        btnWrap.innerHTML = '';
        const mk = (label, p, disabled, active) => {
            const b = document.createElement('button');
            b.className = 'page-btn' + (active ? ' active' : '');
            b.innerHTML = label;
            b.disabled = disabled;
            b.addEventListener('click', ()=>{ page = p; render(); });
            return b;
        };
        btnWrap.appendChild(mk('‹', page-1, page===1, false));
        let ps = Math.max(1, page-2), pe = Math.min(pages, ps+4);
        if(pe-ps < 4) ps = Math.max(1, pe-4);
        for(let p=ps; p<=pe; p++) btnWrap.appendChild(mk(p, p, false, p===page));
        btnWrap.appendChild(mk('›', page+1, page===pages, false));

        document.querySelectorAll('.att-tbl th.sortable').forEach(th=>{
            th.classList.remove('sort-asc','sort-desc');
            if(parseInt(th.dataset.col)===sortCol)
                th.classList.add(sortDir==='asc'?'sort-asc':'sort-desc');
        });
    }

    document.querySelectorAll('.att-tbl th.sortable').forEach(th=>{
        th.addEventListener('click',()=>{
            const c = parseInt(th.dataset.col);
            sortDir = sortCol===c ? (sortDir==='asc'?'desc':'asc') : 'desc';
            sortCol = c;
            render();
        });
    });

    searchEl.addEventListener('input', filter);
    statusEl.addEventListener('change', filter);

    filtered = allRows.slice();
    render();
})();
</script>

@endsection