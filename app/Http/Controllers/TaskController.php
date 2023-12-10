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
        $request->validate([
            'name' => 'required|max:15',
            'description' => ['max:100'],
            'color' => ['required'],
            'due-date' => 'nullable|date|after:now',
            'subtask-1' => 'nullable|max:15',
            'subtask-2' => 'nullable|max:15',
            'subtask-3' => 'nullable|max:15',
            'subtask-4' => 'nullable|max:15',
            'subtask-5' => 'nullable|max:15',
        ]);
        $formFields = $request->validate(
            [
                'name' => 'required|max:15',
                'description' => ['max:100'],
                'color' => ['required'],
                'due-date' => 'nullable|date|after:now',
            ]
        );
        //Assign to a user
        $formFields['user_id'] = auth()->id();
        //Create Task
        $task = Tasks::create($formFields);
        $request->validate([
            'subtask-1' => 'nullable|max:15',
            'subtask-2' => 'nullable|max:15',
            'subtask-3' => 'nullable|max:15',
            'subtask-4' => 'nullable|max:15',
            'subtask-5' => 'nullable|max:15',
        ]);
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
        return redirect('dashboard/main')->with('message', $formFields['name'] . ' created successfully.');
    }

    //Edit Task
    public function editTask(Request $request, Tasks $task)
    {
        //Validate User
        if ($task->user_id != auth()->id()) {
            abort(403, 'Unauthorized');
        }
        //Validate Task
        $request->validate([
            'name' => 'required|max:15',
            'description' => ['max:100'],
            'color' => ['required'],
            'due-date' => 'nullable|date|after:now',
            'subtask-1' => 'nullable|max:15',
            'subtask-2' => 'nullable|max:15',
            'subtask-3' => 'nullable|max:15',
            'subtask-4' => 'nullable|max:15',
            'subtask-5' => 'nullable|max:15',
        ]);
        $formFields = $request->validate(
            [
                'name' => 'required|max:15',
                'description' => ['max:60'],
                'color' => ['required'],
                'due-date' => 'nullable|date|after:now',
                'time' => 'nullable|date_format:H:i',
            ]
        );
        //Edit Task
        $task->update($formFields);
        // Edit Subtasks
        $counter = 1;
        foreach ($task->subtasks as $subtask) {
            $subtaskName = $request->input('subtask-' . $counter);
            $counter++;
            if ($subtaskName) {
                // Update the subtask if the name is not empty
                $subtask->update([
                    'name' => $subtaskName,
                ]);
            } else {
                // Delete the subtask if the name is empty
                $subtask->delete();
            }
        }
        for ($i = $counter; $i <= 5; $i++) {
            $newSubtaskName = $request->input('subtask-' . $i);
            if ($newSubtaskName) {
                $task->subtasks()->create([
                    'name' => $newSubtaskName,
                    'status' => false,
                ]);
            }
        }
        //Redirect
        return redirect('dashboard/main')->with('message', $formFields['name'] . ' updated successfully.');
    }

    //Update Subtasks
    public function updateSubtasks(Request $request, Tasks $task)
    {
        //Validate User
        if ($task->user_id != auth()->id()) {
            abort(403, 'Unauthorized');
        }
        // //Validate Form
        // $request->validate([
        //     'subtask_statuses.*' => 'nullable|boolean',
        // ]);
        //Update
        foreach ($task->subtasks as $subtask) {
            $statusKey = 'subtask_statuses.' . $subtask->id;
            $subtask->update([
                'status' => $request->input($statusKey, 0),
            ]);
        }
        //Redirect
        return redirect('dashboard/main')->with('message', 'Subtasks updated successfully');
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
