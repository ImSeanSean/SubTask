<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    //Show Main Dashboard
    public function mainDashboard()
    {
        $user = Auth::user();
        $tasks = Tasks::query()
            ->where('user_id', $user->id)
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
                'due-date' => 'nullable|date|after:now',
            ]
        );
        //Assign to a user
        $formFields['user_id'] = auth()->id();
        //Create Task
        $task = Tasks::create($formFields);
        // Add Subtasks
        for ($i = 1; $i <= 5; $i++) {
            $subtaskName = $request->input('subtask-' . $i);

            if ($subtaskName) {
                $task->subtasks()->create([
                    'name' => $subtaskName,
                    'status' => false,
                ]);
            }
        }
        //Redirect
        return redirect('dashboard/main')->with('message', 'Welcome, ' . $formFields['name']);
    }

    //Edit Task
    public function editTask(Request $request, Tasks $task)
    {
        //Validate User
        if ($task->user_id != auth()->id()) {
            abort(403, 'Unauthorized');
        }
        //Validate Task
        $formFields = $request->validate(
            [
                'name' => 'required|max:20',
                'description' => ['max:60'],
                'color' => ['required'],
                'due-date' => 'date|after:now',
                'time' => 'nullable|date_format:H:i',
            ]
        );
        //Edit Task
        $task->update($formFields);
        // Edit Subtasks
        foreach ($task->subtasks as $subtask) {
            $subtaskName = $request->input('subtask-' . $subtask->id);

            if ($subtaskName) {
                // Update the subtask if the name is not empty
                $subtask->update([
                    'name' => $subtaskName,
                    'status' => false,
                ]);
            } else {
                // Delete the subtask if the name is empty
                $subtask->delete();
            }
        }
        //Redirect
        return redirect('dashboard/main')->with('message', 'Welcome, ' . $formFields['name']);
    }

    //Delete Task
    public function deleteTask(Tasks $task)
    {
        //Validate User
        if ($task->user_id != auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $task->delete();
        return redirect('dashboard/main')->with('message', 'Listing Deleted Succcessfully');
    }
}
