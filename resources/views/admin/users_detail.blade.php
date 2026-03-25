@extends('layouts.app')

@section('title', 'Detail User - ' . $user->name)

@section('content')
<div class="max-w-6xl mx-auto py-8 px-6">
    <!-- Breadcrumb & Header -->
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
            &larr; Kembali ke Daftar User
        </a>
        <h1 class="text-3xl font-bold text-slate-900 mt-3">User: {{ $user->name }}</h1>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <!-- Card 1: ID -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-md p-6 border border-blue-200">
            <p class="text-blue-600 text-sm font-semibold">ID User</p>
            <p class="text-2xl font-bold text-blue-900 mt-2">#{{ $user->id }}</p>
        </div>

        <!-- Card 2: Email -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-md p-6 border border-green-200">
            <p class="text-green-600 text-sm font-semibold">Email</p>
            <p class="text-lg font-semibold text-green-900 mt-2 break-all">{{ $user->email }}</p>
        </div>

        <!-- Card 3: Role -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl shadow-md p-6 border border-purple-200">
            <p class="text-purple-600 text-sm font-semibold">Role</p>
            <p class="text-lg font-bold text-purple-900 mt-2">
                <span class="inline-block px-2 py-1 rounded bg-purple-200">{{ ucfirst($user->role) }}</span>
            </p>
        </div>

        <!-- Card 4: Created Date -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl shadow-md p-6 border border-orange-200">
            <p class="text-orange-600 text-sm font-semibold">Dibuat Pada</p>
            <p class="text-lg font-bold text-orange-900 mt-2">{{ $user->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <!-- Details & Action Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Details Card -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg border border-slate-200 p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-4">Informasi User</h2>
            
            <div class="space-y-4">
                <div class="border-b border-slate-200 pb-3">
                    <p class="text-sm text-slate-500 font-medium">Nama Lengkap</p>
                    <p class="text-lg text-slate-900 font-semibold">{{ $user->name }}</p>
                </div>

                <div class="border-b border-slate-200 pb-3">
                    <p class="text-sm text-slate-500 font-medium">Email</p>
                    <p class="text-lg text-slate-900 font-semibold">{{ $user->email }}</p>
                </div>

                <div class="border-b border-slate-200 pb-3">
                    <p class="text-sm text-slate-500 font-medium">Role</p>
                    <p class="text-lg text-slate-900 font-semibold">
                        {{ ucfirst($user->role) }}
                    </p>
                </div>

                <!--<div class="border-b border-slate-200 pb-3">
                    <p class="text-sm text-slate-500 font-medium">Kelas</p>
                    <p class="text-lg text-slate-900 font-semibold">
                        {{ $user->classroom ? $user->classroom->name : 'Tidak ada' }}
                    </p>
                </div>-->

                <div>
                    <p class="text-sm text-slate-500 font-medium">Tanggal Dibuat</p>
                    <p class="text-lg text-slate-900 font-semibold">{{ $user->created_at->format('d F Y H:i:s') }}</p>
                </div>
            </div>
        </div>

        <!-- Action Card -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-900 mb-4">Aksi</h2>
            
            <div class="space-y-3">
                <a href="{{ route('admin.users.edit', $user->id) }}" 
                   class="w-full block text-center px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                    Edit User
                </a>

                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors">
                        Hapus User
                    </button>
                </form>

                <a href="{{ route('admin.users.index') }}" 
                   class="w-full block text-center px-4 py-2 bg-slate-200 text-slate-700 rounded-lg font-medium hover:bg-slate-300 transition-colors">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
