<?php

use App\Http\Controllers\TaskController;
use App\Models\Tasks;
use Faker\Provider\Lorem;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\HTTP\Request;

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
//View Landing Page
Route::get('/', function () {
    return view('landing-page.welcome');
});


//View Main Dashboard
Route::get('/dashboard/main', [TaskController::class, 'mainDashboard'])->middleware('auth');

//View Tasks
Route::get('/dashboard/tasks', [TaskController::class, 'showTasks'])->middleware('auth');

//Create Task
Route::get('/dashboard/create-task', [TaskController::class, 'createTask'])->middleware('auth');

Route::post('/dashboard/store-task', [TaskController::class, 'storeTask'])->middleware('auth');

//Edit Task
Route::get('/dashboard/{tasks}/edit', function ($id) {
    // $task = Tasks::find($id);
    // dd($task['description']);
    return view('dashboard.edit-task', [
        'task' => Tasks::find($id)
    ]);
});
Route::put('/dashboard/tasks/{task}', [TaskController::class, 'editTask']);

//Delete Task
Route::get('/dashboard/tasks/{task}/delete', [TaskController::class, 'deleteTask']);

// Registration
Route::get('/registration', [UserController::class, 'create'])->middleware('guest');

Route::post('/users', [UserController::class, 'store']);

//Login
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

Route::post('/users/authenticate', [UserController::class, 'authenticate']);

//Log User out
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth');

//test
Route::get('test', function () {
    return view('test.index');
});
