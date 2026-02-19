<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index()
    // {
    //     //
    // }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|exists:App\Models\User,username',
            'password' => 'required|string'
        ]);

        $admin = Admin::where('username', '=', $request->username)->first();

        $password_matches = Hash::check($request->password, $admin->password);
        if (!$password_matches)
        {
            return redirect()
            ->back()
            ->withErrors([
                'password' => 'The password is invalid'
            ])
            ->withInput();
        }

        $admin->last_logged = Carbon::now();
        $admin->save();

        Auth::guard('admin')->login($admin);

        return redirect()->intended('/admin');
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
    // public function show(Admin $admin)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Admin $admin)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Admin $admin)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Admin $admin)
    // {
    //     //
    // }

    public static function isLogged(Admin $admin)
    {
        $last_logged = $admin->last_logged;
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
