<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;
use Illuminate\Support\Str;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
            'uuid' => Str::uuid(),
            'name' => 'grup pertama',
            'users_id' => [1],
            'tasks_included' => [1]
        ]);
    }
}
