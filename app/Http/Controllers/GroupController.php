<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\SystemController;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($uuid_group)
    {
        $group = Group::where('uuid', '=', $uuid_group)->first();
        $tasks = $group->tasks_included;

        $user = Auth::user();
        $tasks_voted = $user->tasks_voted;

        if ($tasks_voted == null) $tasks_voted = [];

        return SystemController::view(
            view('main.group.main', compact('group', 'tasks', 'tasks_voted'))
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
        
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Group $user)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Group $user)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Group $user)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Group $user)
    // {
    //     //
    // }

    /**
     * Summary of create
     * @param string $name
     * @return Group|null
     */
    public static function create(string $name)
    {
        $parameters = [
            'uuid' => Str::uuid()->toString(),
            'name' => $name,
            'users_id' => [
                1, // Auth later
            ],
            'tasks_included' => []
        ];

        $group = Group::create($parameters);

        $user = Auth::user(); // Auth later

        $user_groups_joined = $user->groups_joined;
        array_push($user_groups_joined, $group->id);

        $user->groups_joined = $user_groups_joined;
        $user->save();

        return $group;
    }
}
