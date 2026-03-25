@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Pengaturan Akun</h1>
        <p class="text-slate-600">Kelola informasi profil dan preferensi akun Anda</p>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if (session('status'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('status') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-4 sticky top-24">
                <nav class="space-y-2">
                    <a href="#profil" onclick="scrollToSection('profil')" 
                       class="block px-4 py-2 rounded-lg text-slate-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-colors">
                        Informasi Profil
                    </a>
                    <a href="#password" onclick="scrollToSection('password')" 
                       class="block px-4 py-2 rounded-lg text-slate-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-colors">
                        Ganti Password
                    </a>
                    <a href="#info-siswa" onclick="scrollToSection('info-siswa')" 
                       class="block px-4 py-2 rounded-lg text-slate-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-colors">
                        Informasi
                    </a>
                    @if(Auth::user()->role === 'student')
                        <a href="#riwayat" onclick="scrollToSection('riwayat')" 
                           class="block px-4 py-2 rounded-lg text-slate-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-colors">
                            Riwayat Kehadiran
                        </a>
                    @endif
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- 1. Informasi Profil Section -->
            <section id="profil" class="bg-white rounded-lg shadow-md p-6 scroll-mt-24">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900">Informasi Profil</h2>
                </div>

                <form action="{{ route('settings.update.profile') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" 
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                            Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" 
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role (Read-only) -->
                    <div>
                        <label for="role" class="block text-sm font-semibold text-slate-700 mb-2">
                            Role
                        </label>
                        <input type="text" id="role" value="{{ ucfirst(Auth::user()->role) }}" 
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg bg-slate-50 cursor-not-allowed text-slate-600"
                               disabled>
                    </div>

                    <!-- Tombol Update -->
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Simpan Perubahan
                    </button>
                </form>
            </section>

            <!-- 2. Ganti Password Section -->
            <section id="password" class="bg-white rounded-lg shadow-md p-6 scroll-mt-24">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900">Ganti Password</h2>
                </div>

                <form action="{{ route('settings.update.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Password Lama -->
                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-slate-700 mb-2">
                            Password Saat Ini
                        </label>
                        <input type="password" id="current_password" name="current_password" 
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition"
                               required>
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                            Password Baru
                        </label>
                        <input type="password" id="password" name="password" 
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition"
                               required>
                        <p class="mt-1 text-xs text-slate-500">Password minimal 8 karakter</p>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">
                            Konfirmasi Password Baru
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition"
                               required>
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Update -->
                    <button type="submit" 
                            class="w-full bg-yellow-600 text-white py-2 rounded-lg font-semibold hover:bg-yellow-700 transition-colors">
                        Update Password
                    </button>
                </form>
            </section>

            <!-- 3. Informasi Siswa Section -->
            <section id="info-siswa" class="bg-white rounded-lg shadow-md p-6 scroll-mt-24">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900">Informasi</h2>
                </div>

                <div class="space-y-4">
                    <!-- ID Pengguna -->
                    <div class="border-l-4 border-green-500 pl-4 py-3">
                        <p class="text-sm text-slate-500 font-medium">ID Pengguna</p>
                        <p class="text-lg font-semibold text-slate-900">#{{ Auth::user()->id }}</p>
                    </div>

                    <!-- Email -->
                    <div class="border-l-4 border-green-500 pl-4 py-3">
                        <p class="text-sm text-slate-500 font-medium">Email</p>
                        <p class="text-lg font-semibold text-slate-900">{{ Auth::user()->email }}</p>
                    </div>

                    <!-- Kelas -->
                    @if(Auth::user()->role == 'student')

                        <!-- Kelas -->
                        @if(Auth::user()->classroom)
                            <div class="border-l-4 border-green-500 pl-4 py-3">
                                <p class="text-sm text-slate-500 font-medium">Kelas</p>
                                <p class="text-lg font-semibold text-slate-900">
                                    {{ Auth::user()->classroom->name ?? 'Tidak ada' }}
                                </p>
                            </div>
                        @else
                            <div class="border-l-4 border-red-500 pl-4 py-3">
                                <p class="text-sm text-slate-500 font-medium">Kelas</p>
                                <p class="text-lg font-semibold text-red-600">
                                    Tidak ada kelas yang terdaftar
                                </p>
                            </div>
                        @endif

                    @endif

                    <!-- Tanggal Daftar -->
                    <div class="border-l-4 border-green-500 pl-4 py-3">
                        <p class="text-sm text-slate-500 font-medium">Tanggal Pendaftaran</p>
                        <p class="text-lg font-semibold text-slate-900">{{ Auth::user()->created_at->format('d F Y H:i') }}</p>
                    </div>

                    <!-- Status Email Verification
                    <div class="border-l-4 border-green-500 pl-4 py-3">
                        <p class="text-sm text-slate-500 font-medium">Status Verifikasi Email</p>
                        @if(Auth::user()->email_verified_at)
                            <p class="text-lg font-semibold text-green-600">✓ Terverifikasi</p>
                        @else
                            <p class="text-lg font-semibold text-yellow-600">⟳ Belum Terverifikasi</p>
                        @endif
                    </div> -->
                </div>
            </section>

            <!-- 4. Riwayat Kehadiran Section (untuk siswa) -->
            @if(Auth::user()->role === 'student')
                <section id="riwayat" class="bg-white rounded-lg shadow-md p-6 scroll-mt-24">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900">Riwayat Kehadiran Terakhir</h2>
                    </div>

                    @php
                        $attendances = Auth::user()->attendances()
                            ->orderBy('date', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp

                    @if($attendances->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-slate-50 border-b-2 border-slate-200">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Tanggal</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Waktu</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Status</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="space-y-2">
                                    @foreach($attendances as $attendance)
                                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                                            <td class="px-4 py-3 text-sm text-slate-900">
                                                {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-slate-900">
                                                {{ $attendance->time ? \Carbon\Carbon::parse($attendance->time)->format('H:i:s') : '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($attendance->status === 'Hadir') bg-green-100 text-green-800
                                                    @elseif($attendance->status === 'Telat') bg-yellow-100 text-yellow-800
                                                    @elseif($attendance->status === 'Izin') bg-blue-100 text-blue-800
                                                    @elseif($attendance->status === 'Sakit') bg-purple-100 text-purple-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ $attendance->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-slate-600">
                                                {{ $attendance->description ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a href="{{ route('attendance.history') }}" 
                           class="inline-block mt-4 px-4 py-2 bg-purple-100 text-purple-600 rounded-lg font-medium hover:bg-purple-200 transition-colors">
                            Lihat Semua Riwayat →
                        </a>
                    @else
                        <div class="text-center py-8">
                            <p class="text-slate-500">Belum ada riwayat kehadiran</p>
                        </div>
                    @endif
                </section>
            @endif

            <!-- 5. Danger Zone Section -->
            <section class="bg-red-50 border-2 border-red-200 rounded-lg shadow-md p-6 scroll-mt-24">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 6v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-red-900">Zona Bahaya</h2>
                </div>

                <p class="text-red-800 mb-4">
                    Tindakan di bawah ini tidak dapat dibatalkan. Harap berhati-hati.
                </p>

                <!-- Delete Account Button -->
                <button type="button" onclick="openDeleteModal()"
                        class="w-full bg-red-600 text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                    Hapus Akun
                </button>
            </section>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
        <h3 class="text-xl font-bold text-red-600 mb-4">Hapus Akun</h3>
        <p class="text-slate-600 mb-6">
            Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan dan semua data Anda akan dihapus secara permanen.
        </p>

        <form action="{{ route('settings.delete.account') }}" method="POST" class="space-y-4">
            @csrf
            @method('DELETE')

            <div>
                <label for="delete_password" class="block text-sm font-semibold text-slate-700 mb-2">
                    Masukkan password Anda untuk mengkonfirmasi
                </label>
                <input type="password" id="delete_password" name="password" 
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                       required>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2 border border-slate-300 rounded-lg font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition-colors">
                    Hapus Akun
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function scrollToSection(sectionId) {
        const element = document.getElementById(sectionId);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    }

    function openDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal')?.addEventListener('click', function(event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection
