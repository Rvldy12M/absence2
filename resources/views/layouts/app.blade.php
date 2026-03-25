<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Attendance System')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

<!-- Navbar -->
<nav class="bg-gradient-to-r from-blue-900 to-slate-800 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            
            <!-- Logo/Brand -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-lg flex items-center justify-center border border-white/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                                 C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Absenly</h1>
            </div>

            <!-- Tombol Hamburger (muncul di HP) -->
            <button id="menu-toggle" class="md:hidden focus:outline-none">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

                <!-- Menu Desktop -->
                <div id="menu-desktop" class="hidden md:flex items-center space-x-2">
                @if(Auth::check())
                    @if(Auth::user()->role === 'admin')

                        <a href="{{ route('admin.dashboard') }}" 
                        class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                        {{ request()->routeIs('admin.dashboard') 
                            ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                            : 'hover:bg-white/10' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('admin.attendances') }}" 
                        class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                        {{ request()->routeIs('admin.attendances') 
                            ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                            : 'hover:bg-white/10' }}">
                            Kehadiran
                        </a>

                        <!-- MASTER DATA DROPDOWN -->
                        <div class="relative group">
                            <button class="px-4 py-2 rounded-lg text-white font-medium hover:bg-white/10 flex items-center gap-1 transition-all duration-200">
                                Master Data
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform group-hover:rotate-180 duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute hidden group-hover:flex group-hover:block top-full left-0 mt-2 w-56 bg-white/95 backdrop-blur-md text-slate-700 rounded-xl shadow-2xl overflow-hidden border border-slate-200/50 flex-col z-50 opacity-0 group-hover:opacity-100 transition-all duration-200 transform scale-95 group-hover:scale-100 origin-top">

                                <!-- Menu Items -->
                                <a href="{{ route('admin.roles.index') }}" 
                                   class="px-4 py-3 flex items-center gap-3 hover:bg-blue-50 transition-colors duration-150 group/item border-b border-slate-100 last:border-b-0">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover/item:scale-110 transition-transform duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700">Role</p>
                                        <p class="text-xs text-slate-500">Atur peran pengguna</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.users.index') }}" 
                                   class="px-4 py-3 flex items-center gap-3 hover:bg-green-50 transition-colors duration-150 group/item border-b border-slate-100 last:border-b-0">
                                    <div class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center group-hover/item:scale-110 transition-transform duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700">User</p>
                                        <p class="text-xs text-slate-500">Admin, Guru</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.classrooms.index') }}" 
                                   class="px-4 py-3 flex items-center gap-3 hover:bg-purple-50 transition-colors duration-150 group/item border-b border-slate-100 last:border-b-0">
                                    <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center group-hover/item:scale-110 transition-transform duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h5.581M9 21m0 0H7.5M21 9l-3.06-3.06a2 2 0 00-2.83 0L6 9m12 0l-1.757-1.757a2 2 0 00-2.83 0L9 9m3 3l6 6" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700">Kelas</p>
                                        <p class="text-xs text-slate-500">Kelola ruang kelas</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.students') }}" 
                                   class="px-4 py-3 flex items-center gap-3 hover:bg-amber-50 transition-colors duration-150 group/item">
                                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center group-hover/item:scale-110 transition-transform duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700">Siswa</p>
                                        <p class="text-xs text-slate-500">Daftar siswa</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--<a href="{{ route('admin.qr.generate') }}" 
                           class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                  {{ request()->routeIs('admin.qr.generate') 
                                     ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                     : 'hover:bg-white/10' }}">
                            QR Code
                        </a>-->
                    @elseif(Auth::user()->role === 'guru')
                        <a href="{{ route('guru.dashboard') }}" 
                        class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                        {{ request()->routeIs('guru.dashboard') 
                            ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                            : 'hover:bg-white/10' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('guru.attendances') }}" 
                        class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                        {{ request()->routeIs('guru.attendances') 
                            ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                            : 'hover:bg-white/10' }}">
                            Kehadiran
                        </a>
                    @elseif(Auth::user()->role === 'student')
                        <a href="{{ route('attendance.index') }}" 
                           class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                  {{ request()->routeIs('attendance.index') 
                                     ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                     : 'hover:bg-white/10' }}">
                            Absen
                        </a>
                        <a href="{{ route('attendance.form') }}" 
                           class="px-4 py-2 rounded-lg text-white font-medium transition-all duration-200 
                                  {{ request()->routeIs('attendance.form') 
                                     ? 'bg-white/20 backdrop-blur-sm shadow-lg' 
                                     : 'hover:bg-white/10' }}">
                            Form Ketidakhadiran
                        </a>
                    @endif

                    <!-- User Info & Logout -->
                    <div class="flex items-center space-x-3 ml-4 pl-4 border-l border-white/20">
                        <div class="text-right hidden md:block">
                            <p class="text-white font-semibold text-sm">{{ Auth::user()->name }}</p>
                            <p class="text-blue-200 text-xs capitalize">{{ Auth::user()->role }}</p>
                        </div>
                        <!-- Settings Icon Button -->
                        <a href="{{ route('settings.index') }}"
                           class="relative group p-2 rounded-lg text-white transition-all duration-200 hover:bg-blue-500/20 border border-blue-400/30 hover:border-blue-400"
                           title="Pengaturan">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-slate-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap"></span>
                        </a>
                        
                        <!-- Logout Icon Button -->
                        <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                                class="relative group p-2 rounded-lg text-white transition-all duration-200 hover:bg-red-500/20 border border-red-400/30 hover:border-red-400"
                                title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-slate-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap"></span>
                        </button>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Menu Mobile -->
        <div id="menu-mobile" class="hidden md:hidden mt-4 bg-slate-900/90 rounded-xl border border-slate-700/50 p-4 space-y-2">
            @if(Auth::check())
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white hover:bg-blue-600/30 transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 5h4" />
                        </svg>
                        <span class="font-semibold text-sm">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.attendances') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white hover:bg-green-600/30 transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-semibold text-sm">Kehadiran</span>
                    </a>
                    
                    <!-- Master Data Section -->
                        <div class="border-t border-slate-700/50 my-2 pt-2">
                            <p class="px-4 py-1 text-xs font-semibold text-slate-400 uppercase tracking-widest">Master Data</p>
                            
                            <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-white hover:bg-blue-600/30 active:bg-blue-600/50 transition-all duration-300 ease-in-out text-sm group">
                                <div class="w-6 h-6 rounded bg-blue-100/20 group-hover:bg-blue-100/30 flex items-center justify-center transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <span>Role</span>
                            </a>

                            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-white hover:bg-green-600/30 active:bg-green-600/50 transition-all duration-300 ease-in-out text-sm group">
                                <div class="w-6 h-6 rounded bg-green-100/20 group-hover:bg-green-100/30 flex items-center justify-center transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <span>User</span>
                            </a>

                            <a href="{{ route('admin.classrooms.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-white hover:bg-purple-600/30 active:bg-purple-600/50 transition-all duration-300 ease-in-out text-sm group">
                                <div class="w-6 h-6 rounded bg-purple-100/20 group-hover:bg-purple-100/30 flex items-center justify-center transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h5.581M9 21m0 0H7.5M21 9l-3.06-3.06a2 2 0 00-2.83 0L6 9m12 0l-1.757-1.757a2 2 0 00-2.83 0L9 9m3 3l6 6" />
                                    </svg>
                                </div>
                                <span>Kelas</span>
                            </a>

                            <a href="{{ route('admin.students') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg text-white hover:bg-amber-600/30 active:bg-amber-600/50 transition-all duration-300 ease-in-out text-sm group">
                                <div class="w-6 h-6 rounded bg-amber-100/20 group-hover:bg-amber-100/30 flex items-center justify-center transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <span>Siswa</span>
                            </a>
                        </div>
                @elseif(Auth::user()->role === 'guru')
                    <a href="{{ route('guru.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white hover:bg-emerald-600/30 transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 5h4" />
                        </svg>
                        <span class="font-semibold text-sm">Dashboard</span>
                    </a>
                    <a href="{{ route('guru.attendances') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white hover:bg-teal-600/30 transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-semibold text-sm">Kehadiran Siswa</span>
                    </a>
                @elseif(Auth::user()->role === 'student')
                    <a href="{{ route('attendance.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white hover:bg-blue-600/30 transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-semibold text-sm">Absen</span>
                    </a>
                    <a href="{{ route('attendance.form') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white hover:bg-purple-600/30 transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="font-semibold text-sm">Form Ketidakhadiran</span>
                    </a>
                @endif

                <div class="border-t border-white/20 my-2"></div>
                <p class="text-sm text-white font-semibold">{{ Auth::user()->name }} <span class="text-blue-300">({{ Auth::user()->role }})</span></p>
                <div class="flex gap-2">
                    <a href="{{ route('settings.index') }}" 
                       class="flex-1 flex items-center justify-center px-3 py-2 rounded-lg text-white hover:bg-blue-500/20 border border-blue-400/30 hover:border-blue-400 font-medium transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                    <button onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" 
                            class="flex-1 flex items-center justify-center px-3 py-2 rounded-lg text-white hover:bg-red-500/20 border border-red-400/30 hover:border-red-400 font-medium transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            @endif
        </div>
    </div>
</nav>

<!-- Content -->
<main class="p-6">
    @yield('content')
</main>

@yield('scripts')

<!-- Script toggle menu mobile -->
<script>
    const toggleBtn = document.getElementById('menu-toggle');
    const menuMobile = document.getElementById('menu-mobile');

    toggleBtn.addEventListener('click', () => {
        menuMobile.classList.toggle('hidden');
    });
</script>

</body>
</html>
