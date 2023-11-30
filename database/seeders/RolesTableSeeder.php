<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['role_name' => Role::ADMIN],
            ['role_name' => Role::COORDINATOR],
            ['role_name' => Role::TESTER],
            ['role_name' => Role::STAFF],
            ['role_name' => Role::PATIENT],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
