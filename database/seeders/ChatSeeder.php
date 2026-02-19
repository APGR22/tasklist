<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Chat;
use App\Models\Task;
use App\Models\Group;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Str;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $group = Group::find(1);
        $task = Task::find(1);
        $uuid = Str::uuid();

        $chat = Chat::create([
            'uuid' => $uuid,
            'data' => [
                ChatController::createMessage(
                    1,
                    $group->uuid,
                    $task->uuid,
                    $uuid,
                    'Halo'
                ),
                ChatController::createMessage(
                    1,
                    $group->uuid,
                    $task->uuid,
                    $uuid,
                    'Ini adalah pesan kedua'
                ),
                ChatController::createMessage(
                    1,
                    $group->uuid,
                    $task->uuid,
                    $uuid,
                    'Ini adalah pesan ketiga'
                ),
            ],
            'in_task' => 1
        ]);

        $task->chat_id = $chat->id;
        $task->save();
    }
}
