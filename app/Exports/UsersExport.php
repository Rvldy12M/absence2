<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class UsersExport implements FromView, WithTitle
{
    public function view(): View
    {
        $records = User::whereIn('role', ['admin', 'guru'])
            ->orderBy('role')
            ->orderBy('name')
            ->get();

        return view('exports.users', [
            'records' => $records,
        ]);
    }

    public function title(): string
    {
        return 'Daftar User';
    }
}
