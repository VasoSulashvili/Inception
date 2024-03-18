<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password')
        ]);
    }
}
