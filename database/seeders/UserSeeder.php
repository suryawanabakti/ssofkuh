<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminsso = User::create([
            'name' => 'Admin SSO',
            'username' => 'adminsso',
            'password' => bcrypt('qwerty123'),
        ]);

        $adminsso->assignRole("adminsso");
    }
}
