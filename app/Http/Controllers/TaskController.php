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
        $tasks = Tasks::query()
            ->when(request('search'), function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->when(request('sort'), function ($query, $sort) {
                return $query->orderBy($sort, 'desc');
            }, function ($query) {
                // Default sort by creation date if no specific sort is requested
                return $query->orderBy('updated_at', 'desc');
            })
            ->simplePaginate(6);

        return view('dashboard.main-dashboard', compact('tasks'));
    }

    //Show Tasks
    public function showTasks()
    {
        return view('dashboard.tasks', [
            'tasks' => Tasks::all()
        ]);
    }

    //Show Single Task
    public function showSingleTask(Tasks $task)
    {
        return view('dashboard.single-task', [
            'task' => $task
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
                'description' => ['max:100'],
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

    //Edit Task
    public function editTask(Request $request, Tasks $task)
    {
        //Validate Task
        $formFields = $request->validate(
            [
                'name' => 'required|max:20',
                'description' => ['max:60'],
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
        //Edit Task
        $task->update($formFields);
        //Redirect
        return redirect('dashboard/main')->with('message', 'Welcome, ' . $formFields['name']);
    }

    //Delete Task
    public function deleteTask(Tasks $task)
    {
        $task->delete();
        return redirect('dashboard/main')->with('message', 'Listing Deleted Succcessfully');
    }
}
