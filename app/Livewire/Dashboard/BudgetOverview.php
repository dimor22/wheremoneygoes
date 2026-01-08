<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Carbon\Carbon;

class BudgetOverview extends Component
{
    public function render()
    {
        $user = auth()->user();
        $setting = $user->setting;
        $budget = $setting ? $setting->monthly_budget : 0;

        // Get current month start and end
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Calculate total expenses for current month
        $currentMonthExpenses = $user->expenses()
            ->whereBetween('expense_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Calculate remaining budget
        $remaining = $budget - $currentMonthExpenses;

        // Get current month name
        $currentMonth = Carbon::now()->format('F Y');

        return view('livewire.dashboard.budget-overview', [
            'budget' => $budget,
            'spent' => $currentMonthExpenses,
            'remaining' => $remaining,
            'currentMonth' => $currentMonth,
            'percentage' => $budget > 0 ? ($currentMonthExpenses / $budget) * 100 : 0,
        ]);
    }
}
