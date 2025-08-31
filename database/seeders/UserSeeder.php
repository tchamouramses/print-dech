<?php

namespace Database\Seeders;

use App\Models\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'roger@dechtech.cm',
            'password' => 'Dech..8Fr',
            'role' => UserRoleEnum::ADMIN,
        ]);

    }
}
