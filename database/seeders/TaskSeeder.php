<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Group;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::create([
            'uuid' => Str::uuid(),
            'name' => 'Tugas percobaan',
            'in_group' => 1,
            //users_voted
            // 'chat_id' => 1 //nullable
        ]);
    }
}
