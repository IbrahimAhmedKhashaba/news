<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::factory()->count(10)->create();
        User::create([
            'name' => 'Ibrahim Ahmed',
            'email' => 'ibrahim@user.com',
            'username' => 'HemaF4brey74',
            'image' => 'uploads/posts/1.png',
            'status' => 1,
            'country' => 'Egypt',
            'city' => 'Osayrat',
            'street' => 'El Danan',
            'phone'=> '01124782711',
            'email_verified_at' => now(),
            'password' => Hash::make('789789789'), // password
            'remember_token' => Str::random(10),
        ]);
    }
}
