<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;

class ExpenseList extends Component
{
    public $search = '';
    public $sortField = 'expense_date';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $household = auth()->user()->household;

        if (!$household) {
            $expenses = collect();
        } else {
            $expenses = Expense::whereIn('user_id', $household->users->pluck('id'))
                ->with(['category', 'store', 'user'])
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('amount', 'like', '%' . $this->search . '%')
                          ->orWhere('notes', 'like', '%' . $this->search . '%')
                          ->orWhereHas('category', function ($q) {
                              $q->where('name', 'like', '%' . $this->search . '%');
                          })
                          ->orWhereHas('store', function ($q) {
                              $q->where('name', 'like', '%' . $this->search . '%');
                          })
                          ->orWhereHas('user', function ($q) {
                              $q->where('name', 'like', '%' . $this->search . '%');
                          });
                    });
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->get();
        }

        return view('livewire.expenses.expense-list', [
            'expenses' => $expenses,
        ]);
    }
}
