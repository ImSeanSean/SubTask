<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Events\ActivityNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Console\Events\ScheduledTaskSkipped;

class TaskController extends Controller
{
    //Show Main Dashboard
    public function mainDashboard()
    {
        $user = Auth::user();

        // Handle color filter
        $colorFilter = request('color');
        $tasksQuery = Tasks::where('user_id', $user->id);
        if ($colorFilter) {
            $tasksQuery->where('color', $colorFilter);
        }

        // Handle due date filter
        $dueDateFilter = request('due_date');
        if ($dueDateFilter) {
            $tasksQuery->whereDate('due-date', now()->addDays($dueDateFilter));
        }

        // Handle other filters (search and sort)
        $tasksQuery->when(request('search'), function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->when(request('sort'), function ($query, $sort) {
            return $query->orderBy($sort, 'desc');
        }, function ($query) {
            return $query->orderBy('updated_at', 'desc');
        });

        $tasks = $tasksQuery->simplePaginate(6);

        $completedTasksCount = $tasksQuery->where('status', 1)->count();

        $notifications = Notification::whereIn('task_id', function ($query) use ($user) {
            $query->select('id')
                ->from('tasks')
                ->where('user_id', $user->id);
        })->get();

        return view('dashboard.main-dashboard', compact('tasks', 'completedTasksCount', 'notifications'));
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
        // Validate Task
        $request->validate([
            'name' => 'required|max:15',
            'description' => 'max:100',
            'color' => 'required',
            'due-date' => 'nullable|date|after:now',
            'subtask-1' => 'required|max:15',
            'subtask-2' => 'nullable|max:15',
            'subtask-3' => 'nullable|max:15',
            'subtask-4' => 'nullable|max:15',
            'subtask-5' => 'nullable|max:15',
        ]);

        $formFields = $request->validate([
            'name' => 'required|max:15',
            'description' => 'max:100',
            'color' => 'required',
            'due-date' => 'nullable|date|after:now',
        ]);

        // Assign to a user
        $formFields['user_id'] = auth()->id();

        // Create Task
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

        // Notification
        event(new ActivityNotification(auth()->user(), 'New Task', $formFields['name'] . ' created successfully.', $task));

        // Redirect
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
        //Notification
        event(new ActivityNotification(auth()->user(), 'Task Edited', $formFields['name'] . ' has been edited.', $task));
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
        event(new ActivityNotification(auth()->user(), 'Task Deleted', $task->name . ' has been deleted.', $task));
        return redirect('dashboard/main')->with('message', 'Listing Deleted Succcessfully');
    }
}
