<div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">App Settings</h3>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit="save">
                <!-- Monthly Budget -->
                <div class="mb-6">
                    <label for="monthly_budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Monthly Budget *
                    </label>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Set your monthly spending budget to track your expenses
                    </p>
                    <div class="mt-2 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                        </div>
                        <input
                            type="number"
                            step="0.01"
                            wire:model="monthly_budget"
                            id="monthly_budget"
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md"
                            placeholder="0.00"
                        >
                    </div>
                    @error('monthly_budget')
                        <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button
                        type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-800 dark:bg-gray-700 hover:bg-gray-900 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700"
                    >
                        Save Budget
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Management -->
    <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" x-data="{ showCategories: false }">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manage Categories</h3>
                <button
                    type="button"
                    @click="showCategories = !showCategories"
                    class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                >
                    <span x-text="showCategories ? 'Hide' : 'Show'"></span>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': showCategories }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>

            <div x-show="showCategories" x-transition>

            <!-- Add New Category Form -->
            <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600">
                <div class="flex items-center gap-2">
                    <input
                        type="text"
                        wire:model="newCategoryName"
                        placeholder="Enter new category name"
                        class="flex-1 text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        wire:keydown.enter="createCategory"
                    >
                    <button
                        type="button"
                        wire:click="createCategory"
                        class="text-sm bg-gray-800 dark:bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-900 dark:hover:bg-gray-600"
                    >
                        Add Category
                    </button>
                </div>
                @error('newCategoryName')
                    <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            @if($categories->isEmpty())
                <p class="text-gray-500 dark:text-gray-400 text-sm">No categories yet. Create one above.</p>
            @else
                <div class="space-y-2">
                    @foreach($categories as $category)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                            @if($editingCategoryId === $category->id)
                                <div class="flex-1 flex items-center gap-2">
                                    <input
                                        type="text"
                                        wire:model="editingCategoryName"
                                        class="flex-1 text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                        wire:keydown.enter="updateCategory"
                                        wire:keydown.escape="cancelCategoryEdit"
                                    >
                                    @error('editingCategoryName')
                                        <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                    @enderror
                                    <button
                                        type="button"
                                        wire:click="updateCategory"
                                        class="text-xs bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700"
                                    >
                                        Save
                                    </button>
                                    <button
                                        type="button"
                                        wire:click="cancelCategoryEdit"
                                        class="text-xs bg-gray-600 text-white px-3 py-1 rounded hover:bg-gray-700"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            @else
                                <div class="flex-1">
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $category->name }}</span>
                                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">({{ $category->expenses_count }} expenses)</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        wire:click="editCategory({{ $category->id }})"
                                        class="text-xs bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        wire:click="deleteCategory({{ $category->id }})"
                                        wire:confirm="Are you sure you want to delete this category?"
                                        class="text-xs bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                        @if($category->expenses_count > 0) disabled title="Cannot delete category with expenses" @endif
                                    >
                                        Delete
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
            </div>
        </div>
    </div>

    <!-- Stores Management -->
    <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" x-data="{ showStores: false }">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manage Stores</h3>
                <button
                    type="button"
                    @click="showStores = !showStores"
                    class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                >
                    <span x-text="showStores ? 'Hide' : 'Show'"></span>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': showStores }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>

            <div x-show="showStores" x-transition>

            <!-- Add New Store Form -->
            <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600">
                <div class="flex items-center gap-2">
                    <input
                        type="text"
                        wire:model="newStoreName"
                        placeholder="Enter new store name"
                        class="flex-1 text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        wire:keydown.enter="createStore"
                    >
                    <button
                        type="button"
                        wire:click="createStore"
                        class="text-sm bg-gray-800 dark:bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-900 dark:hover:bg-gray-600"
                    >
                        Add Store
                    </button>
                </div>
                @error('newStoreName')
                    <span class="text-red-500 dark:text-red-400 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            @if($stores->isEmpty())
                <p class="text-gray-500 dark:text-gray-400 text-sm">No stores yet. Create one above.</p>
            @else
                <div class="space-y-2">
                    @foreach($stores as $store)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                            @if($editingStoreId === $store->id)
                                <div class="flex-1 flex items-center gap-2">
                                    <input
                                        type="text"
                                        wire:model="editingStoreName"
                                        class="flex-1 text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                        wire:keydown.enter="updateStore"
                                        wire:keydown.escape="cancelStoreEdit"
                                    >
                                    @error('editingStoreName')
                                        <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>
                                    @enderror
                                    <button
                                        type="button"
                                        wire:click="updateStore"
                                        class="text-xs bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700"
                                    >
                                        Save
                                    </button>
                                    <button
                                        type="button"
                                        wire:click="cancelStoreEdit"
                                        class="text-xs bg-gray-600 text-white px-3 py-1 rounded hover:bg-gray-700"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            @else
                                <div class="flex-1">
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $store->name }}</span>
                                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">({{ $store->expenses_count }} expenses)</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        wire:click="editStore({{ $store->id }})"
                                        class="text-xs bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        wire:click="deleteStore({{ $store->id }})"
                                        wire:confirm="Are you sure you want to delete this store?"
                                        class="text-xs bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                        @if($store->expenses_count > 0) disabled title="Cannot delete store with expenses" @endif
                                    >
                                        Delete
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
            </div>
        </div>
    </div>
</div>
