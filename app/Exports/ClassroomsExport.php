<?php

namespace App\Exports;

use App\Models\Classroom;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ClassroomsExport implements FromView, WithTitle
{
    public function view(): View
    {
        $records = Classroom::withCount('users as student_count')
            ->orderBy('name')
            ->get();

        return view('exports.classrooms', [
            'records' => $records,
        ]);
    }

    public function title(): string
    {
        return 'Daftar Kelas';
    }
}
