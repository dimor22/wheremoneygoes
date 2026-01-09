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
        $household = auth()->user()->household;
        $setting = $household ? $household->setting : null;
        $this->monthly_budget = $setting ? $setting->monthly_budget : 0;
    }

    public function save()
    {
        $validated = $this->validate();

        $household = auth()->user()->household;
        if (!$household) {
            session()->flash('error', 'You need to be in a household to save settings.');
            return;
        }

        $household->setting()->updateOrCreate(
            ['household_id' => $household->id],
            ['user_id' => auth()->id(), 'monthly_budget' => $validated['monthly_budget']]
        );

        session()->flash('success', 'Settings saved successfully!');
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

        return view('livewire.settings.app-settings', [
            'categories' => $categories,
            'stores' => $stores,
        ]);
    }
}
