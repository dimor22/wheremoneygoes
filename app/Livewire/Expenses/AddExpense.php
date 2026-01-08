<?php

namespace App\Livewire\Expenses;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Store;
use Livewire\Component;
use Livewire\Attributes\Validate;

class AddExpense extends Component
{
    #[Validate('required|numeric|min:0.01')]
    public $amount = '';

    #[Validate('required|exists:categories,id')]
    public $category_id = '';

    #[Validate('required|exists:stores,id')]
    public $store_id = '';

    #[Validate('required|date')]
    public $expense_date = '';

    #[Validate('nullable|string')]
    public $notes = '';

    // For inline category creation
    public $showNewCategoryForm = false;
    #[Validate('required|string|max:255')]
    public $new_category_name = '';

    // For inline store creation
    public $showNewStoreForm = false;
    #[Validate('required|string|max:255')]
    public $new_store_name = '';

    public function mount()
    {
        $this->expense_date = now()->format('Y-m-d');
    }

    public function toggleNewCategoryForm()
    {
        $this->showNewCategoryForm = !$this->showNewCategoryForm;
        $this->new_category_name = '';
        $this->resetValidation(['new_category_name']);
    }

    public function createCategory()
    {
        $this->validate(['new_category_name' => 'required|string|max:255']);

        $category = auth()->user()->categories()->create([
            'name' => $this->new_category_name,
        ]);

        $this->category_id = $category->id;
        $this->showNewCategoryForm = false;
        $this->new_category_name = '';

        session()->flash('category_created', 'Category created successfully!');
    }

    public function toggleNewStoreForm()
    {
        $this->showNewStoreForm = !$this->showNewStoreForm;
        $this->new_store_name = '';
        $this->resetValidation(['new_store_name']);
    }

    public function createStore()
    {
        $this->validate(['new_store_name' => 'required|string|max:255']);

        $store = auth()->user()->stores()->create([
            'name' => $this->new_store_name,
        ]);

        $this->store_id = $store->id;
        $this->showNewStoreForm = false;
        $this->new_store_name = '';

        session()->flash('store_created', 'Store created successfully!');
    }

    public function save()
    {
        $validated = $this->validate([
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'store_id' => 'required|exists:stores,id',
            'expense_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        auth()->user()->expenses()->create($validated);

        session()->flash('success', 'Expense added successfully!');

        $this->reset(['amount', 'category_id', 'store_id', 'notes']);
        $this->expense_date = now()->format('Y-m-d');
    }

    public function render()
    {
        $categories = auth()->user()->categories()->orderBy('name')->get();
        $stores = auth()->user()->stores()->orderBy('name')->get();

        return view('livewire.expenses.add-expense', [
            'categories' => $categories,
            'stores' => $stores,
        ]);
    }
}
