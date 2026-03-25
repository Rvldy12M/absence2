@extends('layouts.app')

@section('title', 'Detail Kelas - ' . $classroom->name)

@section('content')
<div class="max-w-6xl mx-auto py-8 px-6">
    <!-- Breadcrumb & Header -->
    <div class="mb-6">
        <a href="{{ route('admin.classrooms.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
            &larr; Kembali ke Daftar Kelas
        </a>
        <h1 class="text-3xl font-bold text-slate-900 mt-3">Kelas: {{ $classroom->name }}</h1>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <!-- Card 1: Total Siswa -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-md p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-sm font-semibold">Total Siswa</p>
                    <p class="text-3xl font-bold text-blue-900 mt-2">{{ $students->count() }}</p>
                </div>
                <div class="bg-blue-200 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM12 14a8 8 0 00-8 8v2h16v-2a8 8 0 00-8-8z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 2: Dibuat -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-md p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-sm font-semibold">Dibuat Pada</p>
                    <p class="text-lg font-bold text-green-900 mt-2">{{ $classroom->created_at->format('d/m/Y') }}</p>
                    <p class="text-green-700 text-xs mt-1">{{ $classroom->created_at->format('H:i') }}</p>
                </div>
                <div class="bg-green-200 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 3: Action -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl shadow-md p-6 border border-purple-200">
            <div class="space-y-2">
                <a href="{{ route('admin.classrooms.edit', $classroom->id) }}" 
                   class="w-full block text-center px-4 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition-colors">
                    Edit Kelas
                </a>
                <button type="button" onclick="document.getElementById('deleteClassroomModal').classList.remove('hidden')" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors">Hapus Kelas</button>
            </div>
        </div>
    </div>

    <!-- Delete Classroom Modal -->
    <div id="deleteClassroomModal" class="fixed inset-0 bg-black/40 z-40 hidden flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-5">
            <h3 class="text-xl font-bold text-slate-900">Konfirmasi Hapus Kelas</h3>
            <p class="mt-2 text-slate-600">Yakin ingin menghapus kelas ini? Semua relasi bisa terpengaruh.</p>
            <div class="mt-5 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('deleteClassroomModal').classList.add('hidden')" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-100">Batal</button>
                <form action="{{ route('admin.classrooms.destroy', $classroom->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Daftar Siswa Section -->
    <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-900 to-slate-800 px-6 py-4">
            <h2 class="text-xl font-bold text-white">Daftar Siswa</h2>
        </div>

        @if($students->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b-2 border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Nama Siswa</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Bergabung</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $index => $student)
                            <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                                <td class="px-6 py-3 text-sm text-slate-600">{{ $index + 1 }}</td>
                                <td class="px-6 py-3 text-sm text-slate-900 font-medium">{{ $student->name }}</td>
                                <td class="px-6 py-3 text-sm text-slate-600">{{ $student->email }}</td>
                                <td class="px-6 py-3 text-sm text-slate-600">
                                    {{ $student->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-3 text-sm text-center">
                                    <a href="{{ route('admin.students.show', $student->id) }}" 
                                       class="inline-block px-3 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="w-16 h-16 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0h6" />
                </svg>
                <p class="text-slate-600 font-medium">Belum ada siswa di kelas ini</p>
                <p class="text-slate-500 text-sm mt-1">Tambahkan siswa melalui menu Manajemen Siswa</p>
            </div>
        @endif
    </div>
</div>
@endsection
