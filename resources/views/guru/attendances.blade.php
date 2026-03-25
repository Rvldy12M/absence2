@extends('layouts.app')

@section('title', 'Kehadiran')

@section('content')
<style>
/* Styling tabel biar lebih rapi */
table.dataTable {
    width: 100% !important;
    border-collapse: separate !important;
    border-spacing: 0 8px !important;
}

table.dataTable thead th {
    background-color: #f8fafc;
    padding: 12px 16px !important;
    text-align: center;
    font-weight: 600;
}

table.dataTable tbody td {
    background: #fff;
    padding: 12px 16px !important;
    border: none;
    vertical-align: middle;
    text-align: center;
}

table.dataTable tbody tr:hover {
    background-color: #f1f5f9;
}

table.dataTable tbody img {
    max-height: 60px;
    border-radius: 6px;
    object-fit: cover;
}
</style>

<div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200">
    <!-- 🔹 Filter Area -->
    <div class="flex flex-wrap items-center gap-3 mb-4">
        <div class="flex-1 min-w-[250px]">
            <input type="text" id="searchFilter" placeholder="🔍 Cari nama siswa, email, atau keterangan..." 
                   class="w-full border border-gray-300 rounded-lg px-3 py-2">
        </div>
        
        <input type="date" id="dateFilter" class="form-control border border-gray-300 rounded-lg px-3 py-2">
        
        <select id="classFilter" class="border border-gray-300 rounded-lg px-3 py-2">
            <option value="">Semua Kelas</option>
            @foreach(\App\Models\Classroom::all() as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
        </select>

        <select id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-2">
            <option value="">Semua Status</option>
            <option value="Hadir">Hadir</option>
            <option value="Telat">Telat</option>
            <option value="Izin">Izin</option>
            <option value="Sakit">Sakit</option>
        </select>

        <button id="exportExcel" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition whitespace-nowrap">
            Export Excel
        </button>
    </div>

    <!-- 🔹 Table Area -->
    <table id="attendanceTable" class="display w-full">
        <thead class="bg-slate-50">
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
                <td colspan="9" class="text-center">Memuat data...</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- jQuery + DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
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
            { data: 'id', name: 'attendances.id' },
            { data: 'student_name', name: 'users.name' },
            { data: 'email', name: 'users.email' },
            { data: 'class_name', name: 'classrooms.name' },
            { data: 'date', name: 'attendances.date' },
            { data: 'time', name: 'attendances.time' },
            { data: 'status', name: 'attendances.status' },
            { data: 'method', name: 'attendances.method' },
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
                        
                        // Handle null/undefined
                        if (!location && !latitude && !longitude) {
                            return '<span class="text-slate-400 italic">-</span>';
                        }
                        
                        let html = '';
                        
                        // Display location name if exists
                        if (location) {
                            html += `<span class="font-medium text-slate-800">${location}</span>`;
                        } else {
                            html += '<span class="text-slate-400 italic">-</span>';
                        }
                        
                        // Add map link if coordinates exist
                        if (latitude && longitude) {
                            const lat = parseFloat(latitude);
                            const lon = parseFloat(longitude);
                            
                            if (!isNaN(lat) && !isNaN(lon)) {
                                html += `<br/><a href="https://maps.google.com/?q=${lat},${lon}" 
                                       target="_blank" 
                                       class="text-xs text-blue-600 hover:text-blue-800 hover:underline">
                                        Tampilkan di Maps (${lat.toFixed(4)}, ${lon.toFixed(4)})
                                    </a>`;
                            }
                        }
                        
                        return html;
                    } catch (e) {
                        console.error('Error rendering location row:', row, 'Error:', e);
                        return '<span class="text-slate-400 italic">Error</span>';
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
                        return '<span style="color:purple;font-weight:bold;">QR Verified</span>';
                    } else if (photo) {
                        return `
                            <a href="/storage/${photo}" target="_blank">
                                <img src="/storage/${photo}" width="60" height="60" style="border-radius:8px">
                            </a>`;
                    } else if (method === 'Form' && notes) {
                        return `<span class="italic text-slate-700">${notes}</span>`;
                    } else {
                        return '<em>No evidence</em>';
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
