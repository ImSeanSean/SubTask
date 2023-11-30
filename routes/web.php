<?php

use App\Models\Tasks;
use Faker\Provider\Lorem;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard/main', function () {
    return view('main-dashboard');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard/tasks', function () {
    return view('tasks', [
        'tasks' => Tasks::all()
    ]);
});

// Registration
Route::get('/registration', [UserController::class, 'create']);
