<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tasks;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    //View Analytics
    public function showAnalytics()
    {
        return view('dashboard.analytics');
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
}
