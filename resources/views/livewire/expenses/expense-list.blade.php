<div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <!-- Flash Message -->
            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Search Bar -->
            <div class="mb-6">
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Search expenses..."
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Expenses Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th wire:click="sortBy('expense_date')" class="px-3 py-1 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600">
                                <div class="flex items-center">
                                    <span>Date</span>

                                    @if($sortField === 'expense_date')
                                        <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                    {{-- show an icon that tells the user this field is sortable --}}
                                        <span class="ml-1 text-gray-400">↕</span>
                                    @endif
                                </div>

                            </th>
                            <th wire:click="sortBy('amount')" class="px-3 py-1 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600">
                                <div class="flex items-center">
                                    <span>Amount</span>

                                    @if($sortField === 'amount')
                                        <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ml-1 text-gray-400">↕</span>
                                    @endif
                                </div>
                            </th>
                            <th class="px-3 py-1 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" wire:click="sortBy('store_id')">
                                <div class="flex items-center">
                                    <span>Store</span>

                                    @if($sortField === 'store_id')
                                        <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ml-1 text-gray-400">↕</span>
                                    @endif
                                </div>
                            </th>
                            <th class="px-3 py-1 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" wire:click="sortBy('category_id')">
                                <div class="flex items-center">
                                    <span>Category</span>

                                    @if($sortField === 'category_id')
                                        <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ml-1 text-gray-400">↕</span>
                                    @endif
                                </div>
                            </th>

                            <th class="px-3 py-1 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" wire:click="sortBy('user_id')">
                                <div class="flex items-center">
                                    <span>User</span>

                                    @if($sortField === 'user_id')
                                        <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ml-1 text-gray-400">↕</span>
                                    @endif
                                </div>
                            </th>
                            <th class="px-3 py-1 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Notes
                            </th>
                            <th class="px-3 py-1 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($expenses as $expense)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 {{ $expense->trashed() ? 'opacity-50' : '' }}">
                                <td class="px-3 py-2 md:px-6 md:py-4  whitespace-nowrap text-sm {{ $expense->trashed() ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-900 dark:text-gray-100' }}">
                                    {{ \Carbon\Carbon::parse($expense->expense_date)->format('M d') }}
                                </td>
                                <td class="px-3 py-2 md:px-6 md:py-4  whitespace-nowrap text-sm font-medium {{ $expense->trashed() ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-900 dark:text-gray-100' }}">
                                    ${{ number_format($expense->amount, 2) }}
                                </td>
                                <td class="px-3 py-2 md:px-6 md:py-4  whitespace-nowrap text-sm {{ $expense->trashed() ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-900 dark:text-gray-100' }}">
                                    {{ $expense->store->name ?? 'N/A' }}
                                </td>
                                <td class="px-3 py-2 md:px-6 md:py-4  whitespace-nowrap text-sm {{ $expense->trashed() ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-900 dark:text-gray-100' }}">
                                    {{ $expense->category->name ?? 'N/A' }}
                                </td>

                                <td class="px-3 py-2 md:px-6 md:py-4  whitespace-nowrap text-sm {{ $expense->trashed() ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-900 dark:text-gray-100' }}">
                                    {{ $expense->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-3 py-2 md:px-6 md:py-4  text-sm {{ $expense->trashed() ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $expense->notes ?? '-' }}
                                </td>
                                <td class="px-3 py-2 md:px-6 md:py-4  whitespace-nowrap text-sm">
                                    @if($expense->trashed())
                                        <div class="flex gap-2">
                                            <button
                                                wire:click="restoreExpense({{ $expense->id }})"
                                                class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 font-medium"
                                                wire:confirm="Are you sure you want to restore this expense?"
                                            >
                                                Restore
                                            </button>
                                            <button
                                                wire:click="permanentlyDeleteExpense({{ $expense->id }})"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium"
                                                wire:confirm="Are you sure you want to permanently delete this expense? This action cannot be undone."
                                            >
                                                Delete Permanently
                                            </button>
                                        </div>
                                    @else
                                        <button
                                            wire:click="deleteExpense({{ $expense->id }})"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium"
                                            wire:confirm="Are you sure you want to delete this expense?"
                                        >
                                            Delete
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 py-2 md:px-6 md:py-4  text-center text-sm text-gray-500 dark:text-gray-400">
                                    No expenses found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Total Summary -->
            @if($expenses->count() > 0)
                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Total Expenses: {{ $expenses->count() }}
                        </span>
                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Total: ${{ number_format($expenses->sum('amount'), 2) }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
