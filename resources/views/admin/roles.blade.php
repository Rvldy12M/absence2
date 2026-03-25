@extends('layouts.app')

@section('title', 'Manajemen Role')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Manajemen Role</h1>
            <p class="text-slate-600 mt-1">Kelola role dan permission pengguna sistem</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-900 to-slate-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
           <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0h6" />
           </svg>
           + Tambah Role
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Table Section -->
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200">
        <div class="overflow-x-auto">
            <table id="rolesTable" class="display w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Nama Role</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Deskripsi</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Jumlah User</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Dibuat</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#rolesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/admin/roles/data",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'user_count', name: 'user_count', orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        columnDefs: [
            { width: '8%', targets: 0 },
            { width: '15%', targets: 1 },
            { width: '30%', targets: 2 },
            { width: '15%', targets: 3 },
            { width: '15%', targets: 4 },
            { width: '17%', targets: 5 }
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
});
</script>
@endsection
