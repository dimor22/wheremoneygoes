<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Add New Expense</h3>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('category_created'))
                <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                    {{ session('category_created') }}
                </div>
            @endif

            @if (session('store_created'))
                <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                    {{ session('store_created') }}
                </div>
            @endif

            <form wire:submit="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">
                            Amount *
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input
                                type="number"
                                step="0.01"
                                wire:model="amount"
                                id="amount"
                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                placeholder="0.00"
                            >
                        </div>
                        @error('amount')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="expense_date" class="block text-sm font-medium text-gray-700">
                            Date *
                        </label>
                        <input
                            type="date"
                            wire:model="expense_date"
                            id="expense_date"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        >
                        @error('expense_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">
                                Category *
                            </label>
                            <button
                                type="button"
                                wire:click="toggleNewCategoryForm"
                                class="text-xs text-indigo-600 hover:text-indigo-800"
                            >
                                {{ $showNewCategoryForm ? 'Cancel' : '+ New Category' }}
                            </button>
                        </div>

                        @if($showNewCategoryForm)
                            <div class="mb-2 p-3 bg-gray-50 rounded-md border border-gray-200">
                                <input
                                    type="text"
                                    wire:model="new_category_name"
                                    placeholder="Enter category name"
                                    class="block w-full mb-2 text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                    wire:keydown.enter.prevent="createCategory"
                                >
                                @error('new_category_name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                                <button
                                    type="button"
                                    wire:click="createCategory"
                                    class="mt-1 text-xs bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700"
                                >
                                    Create Category
                                </button>
                            </div>
                        @endif

                        <select
                            wire:model="category_id"
                            id="category_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        >
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Store -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="store_id" class="block text-sm font-medium text-gray-700">
                                Store *
                            </label>
                            <button
                                type="button"
                                wire:click="toggleNewStoreForm"
                                class="text-xs text-indigo-600 hover:text-indigo-800"
                            >
                                {{ $showNewStoreForm ? 'Cancel' : '+ New Store' }}
                            </button>
                        </div>

                        @if($showNewStoreForm)
                            <div class="mb-2 p-3 bg-gray-50 rounded-md border border-gray-200">
                                <input
                                    type="text"
                                    wire:model="new_store_name"
                                    placeholder="Enter store name"
                                    class="block w-full mb-2 text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                    wire:keydown.enter.prevent="createStore"
                                >
                                @error('new_store_name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                                <button
                                    type="button"
                                    wire:click="createStore"
                                    class="mt-1 text-xs bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700"
                                >
                                    Create Store
                                </button>
                            </div>
                        @endif

                        <select
                            wire:model="store_id"
                            id="store_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        >
                            <option value="">Select a store</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
                        @error('store_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700">
                        Notes (Optional)
                    </label>
                    <textarea
                        wire:model="notes"
                        id="notes"
                        rows="3"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        placeholder="Any additional details about this expense..."
                    ></textarea>
                    @error('notes')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-6 border-t pt-6">
                    <button
                        type="submit"
                        class="w-full md:w-auto inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700"
                    >
                        Add Expense
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
