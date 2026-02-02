<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Carbon\Carbon;

class BudgetOverview extends Component
{
    public function render()
    {
        $user = auth()->user();
        $household = $user->household;
        $setting = $household ? $household->setting : null;
        $budget = $setting ? $setting->monthly_budget : 0;
        $daysRemaining = Carbon::now()->endOfMonth()->day - Carbon::now()->day + 1;

        // Get current month start and end
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Calculate total expenses for current month across all household members
        if ($household) {
            $expenses = $household->users()
                ->with(['expenses' => function($query) use ($startOfMonth, $endOfMonth) {
                    $query->whereBetween('expense_date', [$startOfMonth, $endOfMonth]);
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
            'daysRemaining' => $daysRemaining,
        ]);
    }
}
