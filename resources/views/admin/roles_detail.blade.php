@extends('layouts.app')

@section('title', 'Detail Role - ' . $role->name)

@section('content')
<div class="max-w-6xl mx-auto py-8 px-6">
    <!-- Breadcrumb & Header -->
    <div class="mb-6">
        <a href="{{ route('admin.roles.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
            &larr; Kembali ke Daftar Role
        </a>
        <h1 class="text-3xl font-bold text-slate-900 mt-3">Role: {{ $role->name }}</h1>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <!-- Card 1: Total User -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-md p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-sm font-semibold">Total User</p>
                    <p class="text-3xl font-bold text-blue-900 mt-2">{{ $users->count() }}</p>
                </div>
                <div class="bg-blue-200 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM12 14a8 8 0 00-8 8v2h16v-2a8 8 0 00-8-8z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 2: Created Date -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-md p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-sm font-semibold">Dibuat Pada</p>
                    <p class="text-lg font-bold text-green-900 mt-2">{{ $role->created_at->format('d/m/Y') }}</p>
                    <p class="text-green-700 text-xs mt-1">{{ $role->created_at->format('H:i') }}</p>
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
                <a href="{{ route('admin.roles.edit', $role->id) }}" 
                   class="w-full block text-center px-4 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition-colors">
                    Edit Role
                </a>
                <button type="button" onclick="document.getElementById('deleteRoleModal').classList.remove('hidden')" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors">Hapus Role</button>
                
                <div id="deleteRoleModal" class="fixed inset-0 bg-black/40 z-40 hidden flex items-center justify-center">
                    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-5">
                        <h3 class="text-xl font-bold text-slate-900">Konfirmasi Hapus Role</h3>
                        <p class="mt-2 text-slate-600">Anda akan menghapus role ini. Semua pengguna dengan role ini akan kehilangan role.</p>
                        <div class="mt-5 flex justify-end gap-2">
                            <button type="button" onclick="document.getElementById('deleteRoleModal').classList.add('hidden')" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-100">Batal</button>
                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Deskripsi -->
    @if($role->description)
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6 mb-8">
            <h2 class="text-lg font-bold text-slate-900 mb-3">Deskripsi</h2>
            <p class="text-slate-600 leading-relaxed">{{ $role->description }}</p>
        </div>
    @endif

    <!-- Daftar User Section -->
    <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-900 to-slate-800 px-6 py-4">
            <h2 class="text-xl font-bold text-white">Daftar User dengan Role: {{ $role->name }}</h2>
        </div>

        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b-2 border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Nama User</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Kelas</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Bergabung</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                            <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                                <td class="px-6 py-3 text-sm text-slate-600">{{ $index + 1 }}</td>
                                <td class="px-6 py-3 text-sm text-slate-900 font-medium">{{ $user->name }}</td>
                                <td class="px-6 py-3 text-sm text-slate-600">{{ $user->email }}</td>
                                <td class="px-6 py-3 text-sm text-slate-600">
                                    {{ $user->classroom ? $user->classroom->name : '-' }}
                                </td>
                                <td class="px-6 py-3 text-sm text-slate-600">
                                    {{ $user->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-3 text-sm text-center">
                                    @if($user->role === 'student')
                                        <a href="{{ route('admin.students.show', $user->id) }}" 
                                           class="inline-block px-3 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition">
                                            Lihat
                                        </a>
                                    @else
                                        <a href="{{ route('admin.users.show', $user->id) }}" 
                                           class="inline-block px-3 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition">
                                            Lihat
                                        </a>
                                    @endif
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
                <p class="text-slate-600 font-medium">Belum ada user dengan role ini</p>
            </div>
        @endif
    </div>
</div>
@endsection
