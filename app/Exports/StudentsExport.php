<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class StudentsExport implements FromView, WithTitle
{
    public function view(): View
    {
        $records = User::where('role', 'student')
            ->with('classroom')
            ->orderBy('name')
            ->get();

        return view('exports.students', [
            'records' => $records,
        ]);
    }

    public function title(): string
    {
        return 'Daftar Siswa';
    }
}
