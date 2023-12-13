<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tasks;
use App\Models\subtasks;
use App\Models\ActivityLogs;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtherController extends Controller
{
    //Notifications
    public function clearNotifications()
    {
        $user = Auth::user();

        Notification::whereIn('task_id', function ($query) use ($user) {
            $query->select('id')
                ->from('tasks')
                ->where('user_id', $user->id);
        })->delete();

        return redirect('dashboard/main')->with('message', 'Notifications Cleared');
    }

    //View Analytics
    public function showAnalytics()
    {
        $user = Auth::user();
        $logs = ActivityLogs::where('user_id', $user->id)->latest()->simplePaginate(7);

        $completedSubtasksCount = Subtasks::whereIn('task_id', function ($query) use ($user) {
            $query->select('id')
                ->from('tasks')
                ->where('user_id', $user->id);
        })->where('status', 1)->count();

        $totalSubtasksCount = Subtasks::whereIn('task_id', function ($query) use ($user) {
            $query->select('id')
                ->from('tasks')
                ->where('user_id', $user->id);
        })->count();

        $percentage = ($totalSubtasksCount > 0) ? round(($completedSubtasksCount / $totalSubtasksCount) * 100) : 0;
        $percentage = $percentage . '%';

        return view('dashboard.analytics', compact('logs', 'percentage'));
    }

    public function getTaskDetails($taskId)
    {
        // Retrieve the task details based on the task ID
        $task = Tasks::find($taskId);

        // Check if the task exists
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        // Convert the task object to an array
        $taskDetails = $task->toArray();
        $taskDetails['subtask'] = $task->subtasks;

        return response()->json($taskDetails);
    }

    public function taskPercentages()
    {
        $user = Auth::user();

        $totalTasks = Tasks::where('user_id', $user->id)->count();

        // Completed tasks count for the authenticated user
        $completedTasks = Tasks::where('user_id', $user->id)->where('status', 1)->count();

        $taskPercentage = ($totalTasks > 0) ? ($completedTasks / $totalTasks) * 100 : 0;

        $subtaskPercentage = [];

        foreach (Tasks::where('user_id', $user->id)->get() as $task) {
            $completedSubtasks = $task->subtasks->where('status', 1)->count();
            $totalSubTasks = $task->subtasks->count();

            $taskSubtaskPercentage = ($totalSubTasks > 0) ? ($completedSubtasks / $totalSubTasks) * 100 : 0;
            $subtaskPercentage[$task->id] = $taskSubtaskPercentage;
        }

        $data = [
            'taskPercentage' => $taskPercentage,
            'subtaskPercentage' => $subtaskPercentage,
        ];

        return response()->json($data);
    }

    public function getData()
    {
        $user = Auth::user();

        // Count Datas
        $totalTasks = Tasks::where('user_id', $user->id)->count();
        $done = Tasks::where('user_id', $user->id)->where('status', 1)->count();
        $inProgress = Tasks::where('user_id', $user->id)
            ->whereHas('subtasks', function ($query) {
                $query->where('status', 1);
            })
            ->where('status', '!=', 1)
            ->count();
        $pending = Tasks::where('user_id', $user->id)
            ->doesntHave('subtasks', 'and', function ($query) {
                $query->where('status', 1);
            })
            ->count();

        // Calculate percentages
        $donePercentage = ($done / max(1, $totalTasks)) * 100;
        $inProgressPercentage = ($inProgress / max(1, $totalTasks)) * 100;
        $pendingPercentage = ($pending / max(1, $totalTasks)) * 100;

        // Organize Data
        $chartData = [
            'labels' => ['Done', 'In Progress', 'Pending'],
            'data' => [$done, $inProgress, $pending],
            'dataPercentage' => [$donePercentage, $inProgressPercentage, $pendingPercentage],
        ];

        // Return Data
        return response()->json($chartData);
    }

    public function getDataLine()
    {
        $user = Auth::user();
        $dayNames = $this->getLast7DaysLabels();

        $activityCounts = ActivityLogs::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('user_id', $user->id)
            ->whereDate('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartData = [
            'labels' => $dayNames,
            'data' => $this->generateChartData($dayNames, $activityCounts),
        ];

        return response()->json($chartData);
    }

    private function getLast7DaysLabels()
    {
        $dayNames = [];
        for ($i = 6; $i >= 0; $i--) {
            $dayNames[] = Carbon::now()->subDays($i)->format('l');
        }

        return $dayNames;
    }

    private function generateChartData($dayNames, $activityCounts)
    {
        $data = [];
        foreach ($dayNames as $dayName) {
            $count = $activityCounts->where('date', Carbon::parse($dayName)->format('Y-m-d'))->first();
            $data[] = $count ? $count->count : 0;
        }

        return $data;
    }

    public function getDueDates()
    {
        $user = Auth::user();

        $tasks = Tasks::where('user_id', $user->id)->whereNotNull('due-date')->get();

        $formattedTasks = $tasks->map(function ($task) {
            $dueDate = \Carbon\Carbon::parse($task['due-date']);

            return [
                'title' => $task->name,
                'start' => $dueDate->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json($formattedTasks);
    }
}
