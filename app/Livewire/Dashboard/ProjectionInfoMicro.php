<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Carbon\Carbon;

class ProjectionInfoMicro extends Component
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
        if ($household) {
            $expenses = $household->users()
                ->with(['expenses' => function($query) use ($startOfMonth, $today) {
                    $query->whereBetween('expense_date', [$startOfMonth, $today])
                          ->whereNull('deleted_at');
                }])
                ->get()
                ->pluck('expenses')
                ->flatten();

            $totalExpenses = $expenses->where('type', 'expense')->sum('amount');
            $totalRefunds = $expenses->where('type', 'refund')->sum('amount');
            $currentMonthExpenses = $totalExpenses - $totalRefunds;
        } else {
            $currentMonthExpenses = 0;
        }

        // Calculate daily average (avoid division by zero)
        $dailyAverage = $daysElapsed > 0 ? $currentMonthExpenses / $daysElapsed : 0;

        // Calculate projected monthly spending
        $daysInMonth = $today->daysInMonth;
        $projectedMonthlySpending = $dailyAverage * $daysInMonth;

        // Get budget for comparison
        $budget = $household ? $household->budgetForMonth(Carbon::now()) : 0;

        // Calculate if projection is over budget
        $isOverBudget = $budget > 0 && $projectedMonthlySpending > $budget;

        return view('livewire.dashboard.projection-info-micro', [
            'dailyAverage' => $dailyAverage,
            'projectedMonthlySpending' => $projectedMonthlySpending,
            'isOverBudget' => $isOverBudget,
            'budget' => $budget,
            'projectionVsBudget' => $budget > 0 ? (($projectedMonthlySpending - $budget) / $budget) * 100 : 0,
        ]);
    }
}
