<?php

namespace App\Livewire\Settings;

use App\Models\Category;
use App\Models\Setting;
use App\Models\Store;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Validate;

class AppSettings extends Component
{
    #[Validate('required|numeric|min:0')]
    public $monthly_budget = 0;

    #[Validate('required|string|timezone')]
    public $timezone = 'UTC';

    // Monthly budget history
    public $budget_month;
    public $budget_amount = 0;
    public $editingBudgetId = null;
    public $editingBudgetMonth = '';
    public $editingBudgetAmount = 0;

    // Category editing
    public $editingCategoryId = null;
    public $editingCategoryName = '';

    // Category creation
    public $newCategoryName = '';

    // Store editing
    public $editingStoreId = null;
    public $editingStoreName = '';

    // Store creation
    public $newStoreName = '';

    public function mount()
    {
        $household = auth()->user()->household;
        $this->monthly_budget = $household ? $household->budgetForMonth(Carbon::now()) : 0;
        $this->budget_month = Carbon::now()->format('Y-m');
        $this->budget_amount = $this->monthly_budget;
        $this->timezone = auth()->user()->timezone ?: 'UTC';
    }

    public function save()
    {
        $validated = $this->validate();

        $household = auth()->user()->household;
        if (!$household) {
            session()->flash('error', 'You need to be in a household to save settings.');
            return;
        }

        auth()->user()->update(['timezone' => $validated['timezone']]);

        // Update the runtime timezone so subsequent now() calls reflect it immediately
        config(['app.timezone' => $validated['timezone']]);
        date_default_timezone_set($validated['timezone']);

        $household->setting()->updateOrCreate(
            ['household_id' => $household->id],
            ['user_id' => auth()->id(), 'monthly_budget' => $validated['monthly_budget']]
        );

        $household->monthlyBudgets()->updateOrCreate(
            ['budget_month' => Carbon::now()->startOfMonth()->toDateString()],
            ['user_id' => auth()->id(), 'amount' => $validated['monthly_budget']]
        );

        session()->flash('success', 'Settings saved successfully!');
    }

    // Monthly budget history management
    public function createBudget()
    {
        $this->validate([
            'budget_month' => 'required|date_format:Y-m',
            'budget_amount' => 'required|numeric|min:0',
        ]);

        $household = auth()->user()->household;
        if (!$household) {
            session()->flash('error', 'You need to be in a household to save budgets.');
            return;
        }

        $month = Carbon::createFromFormat('Y-m', $this->budget_month)
            ->startOfMonth()
            ->format('Y-m-01');

        $household->monthlyBudgets()->updateOrCreate(
            ['budget_month' => $month],
            ['user_id' => auth()->id(), 'amount' => $this->budget_amount]
        );

        session()->flash('success', 'Monthly budget saved successfully!');
    }

    public function editBudget($budgetId)
    {
        $household = auth()->user()->household;
        if (!$household) return;

        $budget = $household->monthlyBudgets()->find($budgetId);
        if ($budget) {
            $this->editingBudgetId = $budget->id;
            $this->editingBudgetMonth = Carbon::parse($budget->budget_month)->format('Y-m');
            $this->editingBudgetAmount = $budget->amount;
        }
    }

    public function updateBudget()
    {
        $this->validate([
            'editingBudgetMonth' => 'required|date_format:Y-m',
            'editingBudgetAmount' => 'required|numeric|min:0',
        ]);

        $household = auth()->user()->household;
        if (!$household) return;

        $budget = $household->monthlyBudgets()->find($this->editingBudgetId);
        if ($budget) {
            $month = Carbon::createFromFormat('Y-m', $this->editingBudgetMonth)
                ->startOfMonth()
                ->format('Y-m-01');
            $budget->update([
                'budget_month' => $month,
                'amount' => $this->editingBudgetAmount,
            ]);
            session()->flash('success', 'Monthly budget updated successfully!');
        }

        $this->editingBudgetId = null;
        $this->editingBudgetMonth = '';
        $this->editingBudgetAmount = 0;
    }

    public function cancelBudgetEdit()
    {
        $this->editingBudgetId = null;
        $this->editingBudgetMonth = '';
        $this->editingBudgetAmount = 0;
        $this->resetValidation(['editingBudgetMonth', 'editingBudgetAmount']);
    }

    public function deleteBudget($budgetId)
    {
        $household = auth()->user()->household;
        if (!$household) return;

        $budget = $household->monthlyBudgets()->find($budgetId);
        if ($budget) {
            $budget->delete();
            session()->flash('success', 'Monthly budget deleted successfully!');
        }
    }

    // Category management
    public function createCategory()
    {
        $this->validate([
            'newCategoryName' => 'required|string|max:255',
        ]);

        $household = auth()->user()->household;
        if (!$household) {
            session()->flash('error', 'You need to be in a household to create categories.');
            return;
        }

        $household->categories()->create([
            'user_id' => auth()->id(),
            'name' => $this->newCategoryName,
        ]);

        $this->newCategoryName = '';
        session()->flash('success', 'Category created successfully!');
    }

    public function editCategory($categoryId)
    {
        $household = auth()->user()->household;
        if (!$household) return;

        $category = $household->categories()->find($categoryId);
        if ($category) {
            $this->editingCategoryId = $categoryId;
            $this->editingCategoryName = $category->name;
        }
    }

    public function updateCategory()
    {
        $this->validate([
            'editingCategoryName' => 'required|string|max:255',
        ]);

        $household = auth()->user()->household;
        if (!$household) return;

        $category = $household->categories()->find($this->editingCategoryId);
        if ($category) {
            $category->update(['name' => $this->editingCategoryName]);
            session()->flash('success', 'Category updated successfully!');
        }

        $this->editingCategoryId = null;
        $this->editingCategoryName = '';
    }

    public function cancelCategoryEdit()
    {
        $this->editingCategoryId = null;
        $this->editingCategoryName = '';
        $this->resetValidation(['editingCategoryName']);
    }

    public function deleteCategory($categoryId)
    {
        $household = auth()->user()->household;
        if (!$household) return;

        $category = $household->categories()->find($categoryId);
        if ($category) {
            // Check if category has expenses (including soft-deleted)
            if ($category->expenses()->withTrashed()->count() > 0) {
                session()->flash('error', 'Cannot delete category with existing expenses.');
            } else {
                $category->delete();
                session()->flash('success', 'Category deleted successfully!');
            }
        }
    }

    // Store management
    public function createStore()
    {
        $this->validate([
            'newStoreName' => 'required|string|max:255',
        ]);

        $household = auth()->user()->household;
        if (!$household) {
            session()->flash('error', 'You need to be in a household to create stores.');
            return;
        }

        $household->stores()->create([
            'user_id' => auth()->id(),
            'name' => $this->newStoreName,
        ]);

        $this->newStoreName = '';
        session()->flash('success', 'Store created successfully!');
    }

    public function editStore($storeId)
    {
        $household = auth()->user()->household;
        if (!$household) return;

        $store = $household->stores()->find($storeId);
        if ($store) {
            $this->editingStoreId = $storeId;
            $this->editingStoreName = $store->name;
        }
    }

    public function updateStore()
    {
        $this->validate([
            'editingStoreName' => 'required|string|max:255',
        ]);

        $household = auth()->user()->household;
        if (!$household) return;

        $store = $household->stores()->find($this->editingStoreId);
        if ($store) {
            $store->update(['name' => $this->editingStoreName]);
            session()->flash('success', 'Store updated successfully!');
        }

        $this->editingStoreId = null;
        $this->editingStoreName = '';
    }

    public function cancelStoreEdit()
    {
        $this->editingStoreId = null;
        $this->editingStoreName = '';
        $this->resetValidation(['editingStoreName']);
    }

    public function deleteStore($storeId)
    {
        $household = auth()->user()->household;
        if (!$household) return;

        $store = $household->stores()->find($storeId);
        if ($store) {
            // Check if store has expenses (including soft-deleted)
            if ($store->expenses()->withTrashed()->count() > 0) {
                session()->flash('error', 'Cannot delete store with existing expenses.');
            } else {
                $store->delete();
                session()->flash('success', 'Store deleted successfully!');
            }
        }
    }

    public function render()
    {
        $household = auth()->user()->household;
        $categories = $household ? $household->categories()->withCount(['expenses' => function ($query) {
            $query->withTrashed();
        }])->orderBy('name')->get() : collect();
        $stores = $household ? $household->stores()->withCount(['expenses' => function ($query) {
            $query->withTrashed();
        }])->orderBy('name')->get() : collect();
        $monthlyBudgets = $household ? $household->monthlyBudgets()->orderBy('budget_month', 'desc')->get() : collect();

        return view('livewire.settings.app-settings', [
            'categories' => $categories,
            'stores' => $stores,
            'monthlyBudgets' => $monthlyBudgets,
        ]);
    }
}
