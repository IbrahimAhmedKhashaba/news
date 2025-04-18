<?php

namespace Database\Seeders;

use App\Models\Authorization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permission_items = config('authorization.permissions');
        foreach ($permission_items as $key => $value) {
            $permissions[] = $key;
        }
        Authorization::create([
            'role' => 'manager',
            'permissions' => $permissions,
        ]);
    }
}
