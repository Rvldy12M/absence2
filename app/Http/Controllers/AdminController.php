<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Classroom;
use Carbon\Carbon;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\LaravelAdapter;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Exports\AttendancesExport;
use App\Exports\ClassroomsExport;
use App\Exports\RolesExport;
use App\Exports\StudentsExport;
use App\Exports\UsersExport;
use App\Models\Role;



class AdminController extends Controller
{

    public function dashboard()
    {
        $today = Carbon::today('Asia/Jakarta');

        // Total siswa
        $totalStudents = User::where('role', 'student')->count();

        // Hitung per status (hari ini)
        $todayPresent = Attendance::whereDate('date', $today)->where('status', 'Hadir')->count();
        $todayTelat   = Attendance::whereDate('date', $today)->where('status', 'Telat')->count();
        $todayIzin    = Attendance::whereDate('date', $today)->where('status', 'Izin')->count();
        $todaySakit   = Attendance::whereDate('date', $today)->where('status', 'Sakit')->count();
        $todayAlpha   = $totalStudents - ($todayPresent + $todayTelat + $todayIzin + $todaySakit);

        // Data untuk chart global
        $attendanceStats = [
            'Hadir' => $todayPresent,
            'Telat' => $todayTelat,
            'Izin'  => $todayIzin,
            'Sakit' => $todaySakit,
            'Alpha' => max($todayAlpha, 0),
        ];

        // Chart per kelas
        $classes = Classroom::select('id', 'name')
        ->whereIn('id', User::where('role', 'student')->pluck('class_id'))
        ->get();
        $classData = [];

        foreach ($classes as $class) {
            $studentsInClass = User::where('class_id', $class->id)->count();
        
            $present = Attendance::whereDate('date', $today)
                ->where('status', 'Hadir')
                ->whereHas('user', fn($q) => $q->where('class_id', $class->id))
                ->count();
        
            $telat = Attendance::whereDate('date', $today)
                ->where('status', 'Telat')
                ->whereHas('user', fn($q) => $q->where('class_id', $class->id))
                ->count();
        
            $izin = Attendance::whereDate('date', $today)
                ->where('status', 'Izin')
                ->whereHas('user', fn($q) => $q->where('class_id', $class->id))
                ->count();
        
            $sakit = Attendance::whereDate('date', $today)
                ->where('status', 'Sakit')
                ->whereHas('user', fn($q) => $q->where('class_id', $class->id))
                ->count();
        
            $alpha = $studentsInClass - ($present + $telat + $izin + $sakit);
        
            $classData[$class->name] = [
                'Hadir' => $present,
                'Telat' => $telat,
                'Izin'  => $izin,
                'Sakit' => $sakit,
                'Alpha' => max($alpha, 0),
            ];
        }
    
        return view('admin.dashboard', compact(
            'totalStudents',
            'attendanceStats',
            'classData'
        ));
    }
    public function dashboardpublic()
    {
        $today = Carbon::today('Asia/Jakarta');

        // Total siswa
        $totalStudents = User::where('role', 'student')->count();

        // Hitung per status (hari ini)
        $todayPresent = Attendance::whereDate('date', $today)->where('status', 'Hadir')->count();
        $todayTelat   = Attendance::whereDate('date', $today)->where('status', 'Telat')->count();
        $todayIzin    = Attendance::whereDate('date', $today)->where('status', 'Izin')->count();
        $todaySakit   = Attendance::whereDate('date', $today)->where('status', 'Sakit')->count();
        $todayAlpha   = $totalStudents - ($todayPresent + $todayTelat + $todayIzin + $todaySakit);

        // Data untuk chart global
        $attendanceStats = [
            'Hadir' => $todayPresent,
            'Telat' => $todayTelat,
            'Izin'  => $todayIzin,
            'Sakit' => $todaySakit,
            'Alpha' => max($todayAlpha, 0),
        ];

        // Chart per kelas
        $classes = User::where('role', 'student')->select('class_id')->distinct()->pluck('class_id');
        $classData = [];

        foreach ($classes as $class) {
            $studentsInClass = User::where('class_id', $class)->count();

            $present = Attendance::whereDate('date', $today)
                ->where('status', 'Hadir')
                ->whereHas('user', fn($q) => $q->where('class_id', $class))
                ->count();

            $telat = Attendance::whereDate('date', $today)
                ->where('status', 'Telat')
                ->whereHas('user', fn($q) => $q->where('class_id', $class))
                ->count();

            $izin = Attendance::whereDate('date', $today)
                ->where('status', 'Izin')
                ->whereHas('user', fn($q) => $q->where('class_id', $class))
                ->count();

            $sakit = Attendance::whereDate('date', $today)
                ->where('status', 'Sakit')
                ->whereHas('user', fn($q) => $q->where('class_id', $class))
                ->count();

            $alpha = $studentsInClass - ($present + $telat + $izin + $sakit);

            $classData[$class] = [
                'Hadir' => $present,
                'Telat' => $telat,
                'Izin'  => $izin,
                'Sakit' => $sakit,
                'Alpha' => max($alpha, 0),
            ];
        }

        return view('dashboard', compact(
            'totalStudents',
            'attendanceStats',
            'classData'
        ));
    }
 
    public function attendances()
    {
        // ambil semua data attendance + relasi student
        $attendances = Attendance::with('user')->orderBy('date', 'desc')->get();

        return view('admin.attendances', compact('attendances'));
    }

        // ✅ Halaman view DataTables
    public function students()
    {
        $classes = Classroom::orderBy('name')->get();
        return view('admin.students', compact('classes'));
    }
    
    public function studentsData(Request $request)
    {
        $query = User::select([
            'users.id', 
            'users.name', 
            'classrooms.name as class_name', 
            'users.email',
            \DB::raw("'' as actions")
        ])
        ->leftJoin('classrooms', 'users.class_id', '=', 'classrooms.id')
        ->where('users.role', 'student');

        if ($request->filled('class_id')) {
            $query->where('users.class_id', $request->class_id);
        }
    
        $dt = new \Ozdemir\Datatables\Datatables(new \Ozdemir\Datatables\DB\LaravelAdapter);
        $dt->query($query);
    
        $dt->edit('actions', function($data) {
            $id = $data['id'];
            return '
                <div class="flex justify-center space-x-2">
                    <a href="/admin/students/'.$id.'" 
                       class="px-3 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 border border-blue-200">View</a>
                    <a href="/admin/students/'.$id.'/edit" 
                       class="px-3 py-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 border border-yellow-200">Edit</a>
                    <form action="/admin/students/'.$id.'" method="POST" class="inline delete-form">
                        '.csrf_field().method_field('DELETE').'
                        <button type="button" class="delete-btn px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 border border-red-200">
                            Delete
                        </button>
                    </form>
                </div>
            ';
        });
    
        return $dt->generate();
    }
    
    public function createStudent()
    {
        return view('admin.students_create');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'class_id' => 'required|exists:classrooms,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'student',
            'class_id' => $request->class_id,
        ]);

        return redirect()->route('admin.students')->with('success', 'Siswa berhasil ditambahkan.');
    }


    // 🔹 Lihat detail siswa
    public function showStudent($id)
    {
        $student = User::findOrFail($id);
        return view('admin.students_detail', compact('student'));
    }

    // 🔹 Form edit siswa
    public function editStudent($id)
    {
        $student = User::findOrFail($id);
        return view('admin.students_edit', compact('student'));
    }

    // 🔹 Update siswa
    public function updateStudent(Request $request, $id)
    {
        $student = User::findOrFail($id);
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'class_id' => 'required|exists:classrooms,id',
        ]);
    
        $student->update($validated);
    
        return redirect()->route('admin.students')->with('success', 'Data siswa berhasil diperbarui.');
    }
    

    // 🔹 Hapus siswa
    public function deleteStudent($id)
    {
        $student = User::findOrFail($id);
        $student->delete();

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus.');
    }

    public function attendancesData(Request $request)
    {
        $query = Attendance::select([
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
        ->join('classrooms', 'users.class_id', '=', 'classrooms.id');

        // Filter tanggal
        if ($request->filled('date')) {
            $query->whereDate('attendances.date', $request->date);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('attendances.status', $request->status);
        }

        // Filter kelas
        if ($request->filled('class_id')) {
            $query->where('users.class_id', $request->class_id);
        }

        // Search filter - cari di nama siswa, email, atau keterangan
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('users.name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('users.email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('attendances.notes', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Urutkan berdasarkan tanggal dan waktu terbaru
        $query->orderByDesc('attendances.date')
            ->orderByDesc('attendances.time');

        // Ozdemir DataTables
        $dt = new \Ozdemir\Datatables\Datatables(new \Ozdemir\Datatables\DB\LaravelAdapter);
        $dt->query($query->toSql(), $query->getBindings());
        
        return $dt->generate();
    }


    public function exportAttendances(Request $request)
    {
        $date = $request->get('date');
        $status = $request->get('status');
        $class_id = $request->get('class_id');

        return Excel::download(
            new AttendancesExport($date, $status, $class_id),
            'attendance_records.xlsx'
        );
    }

    // 🔹 Export Classrooms
    public function exportClassrooms()
    {
        return Excel::download(
            new ClassroomsExport(),
            'classrooms_' . date('Y-m-d_Hi') . '.xlsx'
        );
    }

    // 🔹 Export Roles
    public function exportRoles()
    {
        return Excel::download(
            new RolesExport(),
            'roles_' . date('Y-m-d_Hi') . '.xlsx'
        );
    }

    // 🔹 Export Students
    public function exportStudents()
    {
        return Excel::download(
            new StudentsExport(),
            'students_' . date('Y-m-d_Hi') . '.xlsx'
        );
    }

    // 🔹 Export Users
    public function exportUsers()
    {
        return Excel::download(
            new UsersExport(),
            'users_' . date('Y-m-d_Hi') . '.xlsx'
        );
    }

    // 🔹 Create Attendance (Manual Input / Sakit / Izin / Hadir)
        public function createAttendance()
        {
            $students = User::where('role', 'student')->get();
            return view('admin.attendances_create', compact('students'));
        }
    
        // 🔹 Store Attendance (auto mark late after 07:00)
        public function storeAttendance(Request $request)
        {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'status' => 'required|string|in:Hadir,Sakit,Izin,Telat',
                'method' => 'nullable|string|max:255',
            ]);
        
            $now = \Carbon\Carbon::now('Asia/Jakarta');
            $time = $now->format('H:i:s');
        
            // Standarisasi huruf biar aman
            $status = ucfirst(strtolower($request->status));
        
            // ✅ Kalau status Hadir tapi lewat jam 07:00, ubah jadi Telat
            if ($status === 'Hadir' && $now->greaterThan(\Carbon\Carbon::createFromTime(7, 0, 0, 'Asia/Jakarta'))) {
                $status = 'Telat';
            }
            
        
            Attendance::create([
                'user_id' => $request->user_id,
                'date' => $now->toDateString(),
                'time' => $time,
                'status' => $status,
                'method' => 'Manual',
                'photo' => null,
                'notes' => $request->notes,
            ]);
        
            return redirect()->route('admin.attendances')->with('success', 'Attendance successfully recorded.');
        }
            
        // 🔹 Attendance Filter per Class
        public function filterAttendancesByClass(Request $request)
        {
            $classId = $request->get('class_id');
    
            $query = Attendance::select([
                'users.id',
                'users.name as student_name',
                'users.email',
                'attendances.date',
                'attendances.time',
                'attendances.status',
                'attendances.method',
                'attendances.photo',
                'attendances.notes',
            ])
                ->join('users', 'users.id', '=', 'attendances.user_id')
                ->when($classId, function ($q) use ($classId) {
                    $q->where('users.class_id', $classId);
                });
    
            $dt = new Datatables(new LaravelAdapter);
            $dt->query($query);
    
            return $dt->generate();
        }

    // ============================================
    // 🔹 GURU (TEACHER) METHODS
    // ============================================

    public function guruDashboard()
    {
        // Verify user is guru
        if (auth()->user()->role !== 'guru') {
            abort(403, 'Unauthorized');
        }

        $guru = auth()->user();
        $today = Carbon::today('Asia/Jakarta');

        // Get guru's class students
        $totalStudents = User::where('role', 'student')
            ->where('class_id', $guru->class_id)
            ->count();

        // Hitung per status hari ini untuk kelas guru
        $todayPresent = Attendance::whereDate('date', $today)
            ->where('status', 'Hadir')
            ->whereHas('user', function ($q) use ($guru) {
                $q->where('class_id', $guru->class_id);
            })
            ->count();
        
        $todayTelat = Attendance::whereDate('date', $today)
            ->where('status', 'Telat')
            ->whereHas('user', function ($q) use ($guru) {
                $q->where('class_id', $guru->class_id);
            })
            ->count();
        
        $todayIzin = Attendance::whereDate('date', $today)
            ->where('status', 'Izin')
            ->whereHas('user', function ($q) use ($guru) {
                $q->where('class_id', $guru->class_id);
            })
            ->count();
        
        $todaySakit = Attendance::whereDate('date', $today)
            ->where('status', 'Sakit')
            ->whereHas('user', function ($q) use ($guru) {
                $q->where('class_id', $guru->class_id);
            })
            ->count();
        
        $todayAlpha = $totalStudents - ($todayPresent + $todayTelat + $todayIzin + $todaySakit);

        $attendanceStats = [
            'Hadir' => $todayPresent,
            'Telat' => $todayTelat,
            'Izin'  => $todayIzin,
            'Sakit' => $todaySakit,
            'Alpha' => max($todayAlpha, 0),
        ];

        // Attendance data per classroom for guru's class
        $classAttendances = Classroom::select('classrooms.name', DB::raw('COUNT(attendances.id) as total_present'))
            ->leftJoin('attendances', function ($join) use ($today) {
                $join->on('classrooms.id', '=', DB::raw('(SELECT class_id FROM users WHERE users.id = attendances.user_id)'))
                    ->whereDate('attendances.date', $today)
                    ->where('attendances.status', 'Hadir');
            })
            ->where('classrooms.id', $guru->class_id)
            ->groupBy('classrooms.name')
            ->get();

        return view('guru.dashboard', compact('totalStudents', 'attendanceStats', 'classAttendances'));
    }

    public function guruAttendances()
    {
        // Verify user is guru
        if (auth()->user()->role !== 'guru') {
            abort(403, 'Unauthorized');
        }

        $guru = auth()->user();
        $classroom = Classroom::find($guru->class_id);

        return view('guru.attendances', compact('classroom'));
    }

    public function guruAttendancesData(Request $request)
    {
        // Verify user is guru
        if (auth()->user()->role !== 'guru') {
            abort(403, 'Unauthorized');
        }

        $guru = auth()->user();

        $query = Attendance::select([
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
        ->where('users.class_id', $guru->class_id); // Only show guru's class

        // Filter tanggal
        if ($request->filled('date')) {
            $query->whereDate('attendances.date', $request->date);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('attendances.status', $request->status);
        }

        // Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('users.name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('users.email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('attendances.notes', 'LIKE', "%{$searchTerm}%");
            });
        }

        $query->orderByDesc('attendances.date')
            ->orderByDesc('attendances.time');

        $dt = new Datatables(new LaravelAdapter);
        $dt->query($query->toSql(), $query->getBindings());
        
        return $dt->generate();
    }

    public function guruExportAttendances(Request $request)
    {
        // Verify user is guru
        if (auth()->user()->role !== 'guru') {
            abort(403, 'Unauthorized');
        }

        $guru = auth()->user();
        $date = $request->get('date');
        $status = $request->get('status');
        $classId = $guru->class_id; // Guru only exports their own class

        return Excel::download(
            new AttendancesExport($date, $status, $classId),
            'attendance_' . $guru->name . '_' . date('Y-m-d_Hi') . '.xlsx'
        );
    }

}
