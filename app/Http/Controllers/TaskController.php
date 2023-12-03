<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    //Show Main Dashboard
    public function mainDashboard()
    {
        return view('dashboard.main-dashboard');
    }
    //Show Tasks
    public function showTasks()
    {
        return view('dashboard.tasks', [
            'tasks' => Tasks::all()
        ]);
    }

    //Show Create Task Form
    public function createTask()
    {
        return view('dashboard.create-task');
    }

    //Validate Task Form
    public function storeTask(Request $request)
    {
        //Validate Task
        $formFields = $request->validate(
            [
                'name' => 'required|max:20',
                'description' => ['max:40'],
                'color' => ['required'],
                'due-date' => 'date|after:now',
                'time' => 'nullable|date_format:H:i',
                // 'subtask-1' => ['nullable', 'max:15'],
                // 'subtask-2' => ['nullable', 'max:15'],
                // 'subtask-3' => ['nullable', 'max:15'],
                // 'subtask-4' => ['nullable', 'max:15'],
                // 'subtask-5' => ['nullable', 'max:15'],
            ]
        );
        //Create Task
        Tasks::create($formFields);
        //Redirect
        return redirect('dashboard/main')->with('message', 'Welcome, ' . $formFields['name']);
    }
}
