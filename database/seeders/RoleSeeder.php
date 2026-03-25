<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator sistem dengan akses penuh'
            ],
            [
                'name' => 'guru',
                'description' => 'Guru/Pendidik di sekolah'
            ],
            [
                'name' => 'staf',
                'description' => 'Staf sekolah'
            ],
            [
                'name' => 'student',
                'description' => 'Siswa/Peserta didik'
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']]
            );
        }
    }
}
