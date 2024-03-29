<?php

use App\Http\Controllers\OtherController;
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
    //Validate User
    $task = Tasks::find($id);
    if ($task->user_id != auth()->id()) {
        abort(403, 'Unauthorized');
    }
    return view('dashboard.edit-task', [
        'task' => Tasks::find($id)
    ]);
})->middleware('auth');
Route::put('/dashboard/tasks/{task}', [TaskController::class, 'editTask'])->middleware('auth');

//Delete Task
Route::get('/dashboard/tasks/{task}/delete', [TaskController::class, 'deleteTask'])->middleware('auth');

//Update SubTask Statuses (True or False)
Route::post('dashboard/tasks/{task}/subtasks/change', [TaskController::class, 'updateSubtasks'])->middleware('auth');

//View Analytics
Route::get('/dashboard/analytics', [OtherController::class, 'showAnalytics'])->middleware('auth');

// Registration
Route::get('/registration', [UserController::class, 'create'])->middleware('guest');

Route::post('/users', [UserController::class, 'store']);

//Login
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

Route::post('/users/authenticate', [UserController::class, 'authenticate']);

//Log User out
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth');

//Notifications
Route::get('/tasks/clear-notifications', [OtherController::class, 'clearNotifications'])->middleware('auth');;
//API
Route::get('/api/chart-data', [OtherController::class, 'getData'])->middleware('auth');;
Route::get('/api/graph-data', [OtherController::class, 'getDataLine'])->middleware('auth');;
Route::get('/api/due-dates', [OtherController::class, 'getDueDates'])->middleware('auth');;
Route::get('api/taskPercentage', [OtherController::class, 'taskPercentages'])->middleware('auth');;
Route::get('/api/task/{taskId}', [OtherController::class, 'getTaskDetails'])->middleware('auth');


//test
Route::get('test', function () {
    return view('test.index');
});
