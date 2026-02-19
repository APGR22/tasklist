<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\SystemController;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($uuid_group, $uuid_task)
    {
        return SystemController::view(
            view('main.group.chat.main', compact('uuid_group', 'uuid_task'))
        );
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Chat $chat)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Chat $chat)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Chat $chat)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Chat $chat)
    // {
    //     //
    // }

    public static function createMessage(
        int $user_id,
        string $uuid_group,
        string $uuid_task,
        string $uuid_chat,
        string $message,
        int $reply_to_index = -1
    )
    {
        $msg = [
        'uuid' => $uuid_group.'.'.$uuid_task.'.'.$uuid_chat.'.'.Str::uuid(),
        'datetime' => Carbon::now()->toString(),
        'user_id' => $user_id,
        'message' => $message,
        'reply_to_index' => $reply_to_index, //-1 means no reply
        'deleted' => false
        ];

        return $msg;
    }

    public static function deleteMessage(array &$msg)
    {
        $msg['deleted'] = true;
    }

    public static function ifMessageDeleted(array $msg)
    {
        return $msg['deleted'] == true;
    }

    /**
     * Add to database
     * @param array $msg
     * @return int index of the msg
     */
    public static function addToDatabase(int $chat_id, array $msg): int
    {
        $chat = Chat::find($chat_id);
        $data = $chat->data;

        $index = array_push($data, $msg);

        $chat->data = $data;
        $chat->save();

        return $index;
    }

    /**
     * Delete the message in database
     * @param int $index
     * @return void
     */
    public static function deleteInDatabse(int $chat_id, int $index)
    {
        $chat = Chat::find($chat_id);
        $data = $chat->data;

        self::deleteMessage($data[$index]);

        $chat->data = $data;
        $chat->save();
    }
}
