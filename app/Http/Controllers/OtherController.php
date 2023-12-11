<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tasks;
use App\Models\ActivityLogs;
use App\Models\subtasks;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    //View Analytics
    public function showAnalytics()
    {
        $logs = ActivityLogs::simplePaginate(7);
        $completedSubtasksCount = Subtasks::where('status', 1)->count();
        $totalSubtasksCount = Subtasks::count();
        $percentage = round(($completedSubtasksCount / $totalSubtasksCount) * 100);;
        $percentage = $percentage . '%';
        return view('dashboard.analytics', compact('logs', 'percentage'),);
    }

    public function getData()
    {
        //Count Datas
        $totalTasks = Tasks::count();
        $done = Tasks::where('status', 1)->count();
        $inProgress = Tasks::whereHas('subtasks', function ($query) {
            $query->where('status', 1);
        })->where('status', '!=', 1)->count();
        $pending = Tasks::doesntHave('subtasks', 'and', function ($query) {
            $query->where('status', 1);
        })->count();
        // Calculate percentages
        $donePercentage = ($done / $totalTasks) * 100;
        $inProgressPercentage = ($inProgress / $totalTasks) * 100;
        $pendingPercentage = ($pending / $totalTasks) * 100;
        //Convert to String
        // $donePercentage = (string)$donePercentage;
        // $inProgressPercentage = (string)$inProgressPercentage;
        // $pendingPercentage = (string)$pendingPercentage;
        //Organize Data
        $chartData = [
            'labels' => ['Done', 'In Progress', 'Pending'],
            'data' => [$done, $inProgress, $pending],
            'dataPercentage' => [$donePercentage, $inProgressPercentage, $pendingPercentage],
        ];
        //Return Data
        return response()->json($chartData);
    }

    public function getDataLine()
    {
        $dayNames = $this->getLast7DaysLabels();

        $activityCounts = ActivityLogs::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        //Organize Data
        $chartData = [
            'labels' => $dayNames,
            'data' => $this->generateChartData($dayNames, $activityCounts),
        ];

        //Return Data
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
        $tasks = Tasks::whereNotNull('due-date')->get();

        // Format tasks for FullCalendar
        $formattedTasks = $tasks->map(function ($task) {
            // Convert the "due-date" string to a DateTime object
            $dueDate = \Carbon\Carbon::parse($task->{'due-date'});

            return [
                'title' => $task->name,
                'start' => $dueDate->format('Y-m-d H:i:s'), // Adjust the format as needed
            ];
        });

        return response()->json($formattedTasks);
    }
}
