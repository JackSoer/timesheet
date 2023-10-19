<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeveloperResource;
use App\Http\Resources\WorkLogCollection;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, $year = null, $month = null)
    {
        $paidThisMonth = $this->getPaidThisMonthAmount();

        $unpaid = $this->getUnpaidAmount();

        $workLogsByDevelopers = [];

        if ($month && $year) {
            $monthNumber = Carbon::parse("1 $month")->month;

            $date = Carbon::create($year, $monthNumber, 1);

            $workLogsThisMonth = $this->getWorkLogsByMonth($date->month, $date->year);

            $workLogsByDevelopers = $this->getWorkLogsByDevelopers($workLogsThisMonth);

            return inertia('Dashboard', compact('paidThisMonth', 'unpaid', 'workLogsByDevelopers', 'date'));
        } else {
            $currentMonth = Carbon::now();

            $workLogsThisMonth = $this->getWorkLogsByMonth($currentMonth->month, $currentMonth->year);

            $workLogsByDevelopers = $this->getWorkLogsByDevelopers($workLogsThisMonth);

            return inertia('Dashboard', compact('paidThisMonth', 'unpaid', 'workLogsByDevelopers'));
        }
    }

    private function getWorkLogsByDevelopers($workLogs)
    {
        $workLogsByDevelopers = [];

        foreach ($workLogs as $workLog) {
            $developer = new DeveloperResource($workLog->developer);
            $developerFullName = "$developer->first_name $developer->last_name";

            $date = $workLog->date;
            $hrs = $workLog->hrs;

            $log = ['date' => $date, 'hrs' => $hrs];

            $developerExist = false;

            foreach ($workLogsByDevelopers as &$workLogsByDeveloper) {
                if ($workLogsByDeveloper['developer'] === $developerFullName) {
                    $found = false;

                    foreach ($workLogsByDeveloper['logs'] as &$existingLog) {
                        if ($existingLog['date'] === $date) {
                            $existingLog['hrs'] += $hrs;
                            $found = true;
                            break;
                        }
                    }

                    if (!$found) {
                        $workLogsByDeveloper['logs'][] = $log;
                    }

                    $developerExist = true;
                }
            }

            if (!$developerExist) {
                $workLogsByDevelopers[] = ['developer' => $developerFullName, 'logs' => [$log]];
            }
        }

        return $workLogsByDevelopers;
    }

    private function getWorkLogsByMonth($month, $year)
    {
        $workLogsThisMonth = new WorkLogCollection(WorkLog::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->get());

        return $workLogsThisMonth;
    }

    private function getPaidThisMonthAmount()
    {
        $currentMonth = Carbon::now()->month;

        $workLogsThisMonth = WorkLog::whereMonth('date', $currentMonth)->get();

        $paidThisMonth = 0;

        foreach ($workLogsThisMonth as $workLog) {

            if ($workLog->status === 200) {
                $paidThisMonth += $workLog->total;
            }
        }

        return $paidThisMonth;
    }

    private function getUnpaidAmount()
    {
        $workLogs = WorkLog::all();

        $unpaid = 0;

        foreach ($workLogs as $workLog) {
            if ($workLog->status === 100) {
                $unpaid += $workLog->total;
            }
        }

        return $unpaid;
    }
}
