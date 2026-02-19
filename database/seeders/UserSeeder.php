<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'uuid' => Str::uuid(),
            'username' => 'Azhar',
            'password' => '123',
            'groups_joined' => [1],
            // 'tasks_voted'
            // 'is_logged'
            // 'last_logged'
        ]);
    }
}
