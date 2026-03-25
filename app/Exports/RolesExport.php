<?php

namespace App\Exports;

use App\Models\Role;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class RolesExport implements FromView, WithTitle
{
    public function view(): View
    {
        $records = Role::withCount('users')
            ->orderBy('name')
            ->get();

        return view('exports.roles', [
            'records' => $records,
        ]);
    }

    public function title(): string
    {
        return 'Daftar Role';
    }
}
