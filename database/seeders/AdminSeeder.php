<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Authorization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Ibrahim Khashaba',
            'email' => 'ibrahim@admin.com',
            'username' => 'admin ',
            'authorization_id' => Authorization::where('role' , 'manager')->first()->id,
            'password' => bcrypt('789789789'),
        ]);

    }
}
