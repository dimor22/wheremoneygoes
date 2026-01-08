<?php

namespace App\Livewire\Settings;

use App\Models\Category;
use App\Models\Setting;
use App\Models\Store;
use Livewire\Component;
use Livewire\Attributes\Validate;

class AppSettings extends Component
{
    #[Validate('required|numeric|min:0')]
    public $monthly_budget = 0;

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
        $setting = auth()->user()->setting;
        $this->monthly_budget = $setting ? $setting->monthly_budget : 0;
    }

    public function save()
    {
        $validated = $this->validate();

        auth()->user()->setting()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['monthly_budget' => $validated['monthly_budget']]
        );

        session()->flash('success', 'Settings saved successfully!');
    }

    // Category management
    public function createCategory()
    {
        $this->validate([
            'newCategoryName' => 'required|string|max:255',
        ]);

        auth()->user()->categories()->create([
            'name' => $this->newCategoryName,
        ]);

        $this->newCategoryName = '';
        session()->flash('success', 'Category created successfully!');
    }

    public function editCategory($categoryId)
    {
        $category = auth()->user()->categories()->find($categoryId);
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

        $category = auth()->user()->categories()->find($this->editingCategoryId);
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
        $category = auth()->user()->categories()->find($categoryId);
        if ($category) {
            // Check if category has expenses
            if ($category->expenses()->count() > 0) {
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

        auth()->user()->stores()->create([
            'name' => $this->newStoreName,
        ]);

        $this->newStoreName = '';
        session()->flash('success', 'Store created successfully!');
    }

    public function editStore($storeId)
    {
        $store = auth()->user()->stores()->find($storeId);
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

        $store = auth()->user()->stores()->find($this->editingStoreId);
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
        $store = auth()->user()->stores()->find($storeId);
        if ($store) {
            // Check if store has expenses
            if ($store->expenses()->count() > 0) {
                session()->flash('error', 'Cannot delete store with existing expenses.');
            } else {
                $store->delete();
                session()->flash('success', 'Store deleted successfully!');
            }
        }
    }

    public function render()
    {
        $categories = auth()->user()->categories()->withCount('expenses')->orderBy('name')->get();
        $stores = auth()->user()->stores()->withCount('expenses')->orderBy('name')->get();

        return view('livewire.settings.app-settings', [
            'categories' => $categories,
            'stores' => $stores,
        ]);
    }
}
