<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Http\Controllers\SystemController;

class AdminMainController extends Controller
{
    public function index()
    {
        $users = User::all();
        $admins = Admin::all();

        return SystemController::view(
            view('main.admin.main', compact('users', 'admins'))
        );
    }
}
