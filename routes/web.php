<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminMainController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\AdminController;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\Guest;
use App\Http\Middleware\System_State;
use App\Http\Middleware\Administrator;
use App\Http\Middleware\AdminGuest;
use App\Http\Middleware\System_State_Reversed;

// Route::get('/', function () {
//     return view('welcome');
// });

# SYSTEM

Route::view('/state/maintenance', 'main.system.maintenance')
->middleware(System_State_Reversed::class)
->name('system.maintenance');

# MAIN

Route::get('/', [MainController::class, 'index'])
->middleware(System_State::class)
->middleware(Authenticate::class)
->name('home');

Route::get('/group/{uuid_group}', [GroupController::class, 'index'])
->middleware(System_State::class)
->middleware(Authenticate::class)
->name('group');

Route::get('/group/{uuid_group}/{uuid_task}', [ChatController::class, 'index'])
->middleware(System_State::class)
->middleware(Authenticate::class)
->name('chat');


Route::get('/login', function (){
    return SystemController::view(
        view('main.accounts.login')
    );
})
->middleware(System_State::class)
->middleware(Guest::class)
->name('login');

Route::post('/login/post', [UserController::class, 'login'])
->middleware(System_State::class)
->middleware(Guest::class)
->name('login.post');

# ADMIN

Route::get('/admin', [AdminMainController::class, 'index'])
->middleware(Administrator::class)
->name('admin.home');

Route::get('/admin/login', function () {
    return SystemController::view(
        view('main.admin.accounts.login')
    );
})
->middleware(AdminGuest::class)
->name('admin.login');

Route::post('/admin/login/post', [AdminController::class, 'login'])
->middleware(AdminGuest::class)
->name('admin.login.post');

Route::view('/tes/livewire', 'tes.livewire');
Route::view('/tes/trackclient', 'tes.trackclient');