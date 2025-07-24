<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $roleUser = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        $userAdmin = User::create([
            'name' => 'Admin Shujia',
            'email' => 'admin@shujia.com',
            'password' => bcrypt('passwordd'),
            'email_verified_at' => now(),
        ]);

        $userShujia = User::create([
            'name' => 'User Shujia',
            'email' => 'user@shujia.com',
            'password' => bcrypt('passwordd'),
            'email_verified_at' => now(),
        ]);

        $userAdmin->assignRole($roleAdmin);
        $userShujia->assignRole($roleUser);
    }
}
