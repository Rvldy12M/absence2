<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Auth;
use App\Models\User;
use App\Models\Classroom;
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

class GuruController extends Controller
{
    public function index()
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
}