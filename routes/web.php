<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use App\Models\Attendance;

// Welcome 
Route::get('/', function () {
    return view('welcome');
});


// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/dashboard', [AdminController::class, 'dashboardpublic'])->name('dashboard');

Route::get('/public', [AttendanceController::class, 'publicscreen'])->name('publicscreen');

// Route untuk student (siswa)
Route::middleware(['auth'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');

    // Contoh route tambahan
    Route::get('/attendance/qr', [AttendanceController::class, 'scanQr'])->name('student.attendance.qr');
    Route::get('/attendance/camera', [AttendanceController::class, 'camera'])->name('student.attendance.camera');
});

// Route Izin/sakit
Route::middleware(['auth'])->group(function () {
    Route::get('/attendance/presence', [AttendanceController::class, 'createByStudent'])->name('attendance.form');
    Route::post('/attendance/presence', [AttendanceController::class, 'storeByStudent'])->name('attendance.submit');
});


// Route untuk admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // 🔹 EXPORT ROUTES (harus sebelum parameter routes untuk menghindari route conflict)
    Route::get('/admin/attendances/export', [AdminController::class, 'exportAttendances'])->name('admin.attendances.export');
    Route::get('/admin/classrooms/export', [AdminController::class, 'exportClassrooms'])->name('admin.classrooms.export');
    Route::get('/admin/roles/export', [AdminController::class, 'exportRoles'])->name('admin.roles.export');
    Route::get('/admin/students/export', [AdminController::class, 'exportStudents'])->name('admin.students.export');
    Route::get('/admin/users/export', [AdminController::class, 'exportUsers'])->name('admin.users.export');

    // Attendance DataTables
    Route::get('/admin/attendances', [AdminController::class, 'attendances'])->name('admin.attendances');
    Route::get('/admin/attendances/data', [AdminController::class, 'attendancesData'])->name('admin.attendances.data');

    // Student DataTables
    Route::get('/admin/students', [AdminController::class, 'students'])->name('admin.students');
    Route::get('/admin/students/data', [AdminController::class, 'studentsData'])->name('admin.students.data');

    // CRUD siswa
    Route::get('/admin/students/create', [AdminController::class, 'createStudent'])->name('admin.students.create');
    Route::post('/admin/students/store', [AdminController::class, 'storeStudent'])->name('admin.students.store');
    Route::get('/admin/students/{id}', [AdminController::class, 'showStudent'])->name('admin.students.show');
    Route::get('/admin/students/{id}/edit', [AdminController::class, 'editStudent'])->name('admin.students.edit');
    Route::post('/admin/students/{id}/update', [AdminController::class, 'updateStudent'])->name('admin.students.update');
    Route::delete('/admin/students/{id}', [AdminController::class, 'deleteStudent'])->name('admin.students.delete');

    // Classroom Management
    Route::get('/admin/classrooms', [ClassroomController::class, 'index'])->name('admin.classrooms.index');
    Route::get('/admin/classrooms/data', [ClassroomController::class, 'data'])->name('admin.classrooms.data');
    Route::get('/admin/classrooms/create', [ClassroomController::class, 'create'])->name('admin.classrooms.create');
    Route::post('/admin/classrooms', [ClassroomController::class, 'store'])->name('admin.classrooms.store');
    Route::get('/admin/classrooms/{id}', [ClassroomController::class, 'show'])->name('admin.classrooms.show');
    Route::get('/admin/classrooms/{id}/edit', [ClassroomController::class, 'edit'])->name('admin.classrooms.edit');
    Route::put('/admin/classrooms/{id}', [ClassroomController::class, 'update'])->name('admin.classrooms.update');
    Route::delete('/admin/classrooms/{id}', [ClassroomController::class, 'destroy'])->name('admin.classrooms.destroy');

    // Role Management
    Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::get('/admin/roles/data', [RoleController::class, 'data'])->name('admin.roles.data');
    Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('/admin/roles', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('/admin/roles/{id}', [RoleController::class, 'show'])->name('admin.roles.show');
    Route::get('/admin/roles/{id}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::put('/admin/roles/{id}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('/admin/roles/{id}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');

    // User Management
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/data', [UserController::class, 'data'])->name('admin.users.data');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{id}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

// Route untuk guru (teacher)
Route::middleware(['auth'])->group(function () {
    Route::get('/guru/dashboard', [AdminController::class, 'guruDashboard'])->name('guru.dashboard');
    
    // Attendance for guru's class
    Route::get('/guru/attendances', [AdminController::class, 'guruAttendances'])->name('guru.attendances');
    Route::get('/guru/attendances/data', [AdminController::class, 'guruAttendancesData'])->name('guru.attendances.data');
    Route::get('/guru/attendances/export', [AdminController::class, 'guruExportAttendances'])->name('guru.attendances.export');
});

    //QR
    Route::middleware(['auth'])->group(function () {
        // Student input QR
        Route::get('/attendance/qr', [QRController::class, 'showForm'])->name('attendance.qr');
        Route::post('/attendance/qr', [QRController::class, 'submit'])->name('attendance.qr.submit');
    
        // Admin generate QR
        Route::get('/admin/qr/generate', [QRController::class, 'generate'])->name('admin.qr.generate');
    });

    // Lupa Password
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest')
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware('guest')
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest')
        ->name('password.store');

    // Settings routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.update.profile');
        Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.update.password');
        Route::delete('/settings/account', [SettingsController::class, 'deleteAccount'])->name('settings.delete.account');
    });

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');

// Test Debug Route (Remove after debugging)
Route::get('/test-attendances-data', function() {
    $attendances = Attendance::select([
        'attendances.id',
        'users.name as student_name',
        'classrooms.name as class_name',
        'users.email',
        'attendances.date',
        'attendances.time',
        'attendances.status',
        'attendances.method',
        'attendances.photo',
        'attendances.notes',
        'attendances.location',
        'attendances.latitude',
        'attendances.longitude',
    ])
    ->join('users', 'attendances.user_id', '=', 'users.id')
    ->join('classrooms', 'users.class_id', '=', 'classrooms.id')
    ->orderByDesc('attendances.date')
    ->orderByDesc('attendances.time')
    ->limit(5)
    ->get();
    
    return response()->json([
        'total' => $attendances->count(),
        'data' => $attendances,
    ]);
});

// Test export classes
Route::get('/test-export/classrooms', function() {
    try {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\ClassroomsExport(),
            'test_classrooms.xlsx'
        );
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
});

Route::get('/test-export/roles', function() {
    try {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\RolesExport(),
            'test_roles.xlsx'
        );
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
});

Route::get('/test-export/students', function() {
    try {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\StudentsExport(),
            'test_students.xlsx'
        );
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
});

Route::get('/test-export/users', function() {
    try {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\UsersExport(),
            'test_users.xlsx'
        );
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
});

Route::middleware(['auth','role:guru'])->group(function () {

    Route::get('/guru/dashboard', [GuruController::class,'index'])
        ->name('guru.dashboard');

});