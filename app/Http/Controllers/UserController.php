<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|exists:App\Models\User,username',
            'password' => 'required|string'
        ]);

        $user = User::where('username', '=', $request->username)->first();

        $password_matches = Hash::check($request->password, $user->password);
        if (!$password_matches)
        {
            return redirect()
            ->back()
            ->withErrors([
                'password' => 'The password is invalid'
            ])
            ->withInput();
        }

        $user->last_logged = Carbon::now();
        $user->save();

        Auth::login($user);

        return redirect()->intended();
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request);
    }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(User $user)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(User $user)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, User $user)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(User $user)
    // {
    //     //
    // }

    public static function update($attributes)
    {
        $user = User::find(1); //Auth later
        $user->update($attributes);
    }

    public static function isLogged(User $user)
    {
        $last_logged = $user->last_logged;
        $expire_time_in_minutes = env('SESSION_LIFETIME');

        if ($last_logged != null)
        {
            $now = Carbon::now();

            if ($now->diffInMinutes($last_logged) < $expire_time_in_minutes)
            {
                return true;
            }
        }

        return false;
    }
}
