<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Carbon\Carbon;

class ProjectionInfo extends Component
{
    public function render()
    {
        $user = auth()->user();
        $household = $user->household;

        // Get current month start and end
        $startOfMonth = Carbon::now()->startOfMonth();
        $today = Carbon::now();

        // Calculate days elapsed in the current month
        $daysElapsed = $today->day;

        // Calculate total expenses for current month across all household members (excluding soft-deleted)
        $currentMonthExpenses = $household
            ? $household->users()
                ->with(['expenses' => function($query) use ($startOfMonth, $today) {
                    $query->whereBetween('expense_date', [$startOfMonth, $today])
                          ->whereNull('deleted_at');
                }])
                ->get()
                ->pluck('expenses')
                ->flatten()
                ->sum('amount')
            : 0;

        // Calculate daily average (avoid division by zero)
        $dailyAverage = $daysElapsed > 0 ? $currentMonthExpenses / $daysElapsed : 0;

        // Calculate projected monthly spending
        $daysInMonth = $today->daysInMonth;
        $projectedMonthlySpending = $dailyAverage * $daysInMonth;

        // Get budget for comparison
        $setting = $household ? $household->setting : null;
        $budget = $setting ? $setting->monthly_budget : 0;

        // Calculate if projection is over budget
        $projectionVsBudget = $budget > 0 ? (($projectedMonthlySpending - $budget) / $budget) * 100 : 0;

        return view('livewire.dashboard.projection-info', [
            'dailyAverage' => $dailyAverage,
            'projectedMonthlySpending' => $projectedMonthlySpending,
            'daysElapsed' => $daysElapsed,
            'daysInMonth' => $daysInMonth,
            'currentMonthExpenses' => $currentMonthExpenses,
            'budget' => $budget,
            'projectionVsBudget' => $projectionVsBudget,
        ]);
    }
}
