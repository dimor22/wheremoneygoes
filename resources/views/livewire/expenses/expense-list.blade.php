<div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <!-- Flash Message -->
            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Month Navigation -->
            <div class="mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <button
                        wire:click="previousMonth"
                        class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-colors"
                        title="Previous Month"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <div class="flex items-center gap-3 min-w-[200px] justify-center">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $selectedMonthName }}
                        </h2>
                        @if(!$isCurrentMonth)
                            <button
                                wire:click="goToCurrentMonth"
                                class="text-sm px-3 py-1 rounded-md bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-300 transition-colors"
                                title="Go to current month"
                            >
                                Today
                            </button>
                        @endif
                    </div>

                    <button
                        wire:click="nextMonth"
                        class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-colors"
                        title="Next Month"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <!-- Month Picker Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button
                        @click="open = !open"
                        @click.away="open = false"
                        class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition-colors flex items-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm font-medium">Jump to Month</span>
                    </button>

                    <div
                        x-show="open"
                        x-transition
                        class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-10 max-h-96 overflow-y-auto"
                    >
                        <div class="p-2">
                            @php
                                $currentDate = now();
                                $startDate = $currentDate->copy()->subMonths(12);
                                $months = [];
                                for ($i = 0; $i <= 12; $i++) {
                                    $date = $startDate->copy()->addMonths($i);
                                    $months[] = ['month' => $date->month, 'year' => $date->year, 'label' => $date->format('F Y')];
                                }
                                $months = array_reverse($months);
                            @endphp

                            @foreach($months as $monthData)
                                <button
                                    wire:click="setMonth({{ $monthData['month'] }}, {{ $monthData['year'] }})"
                                    @click="open = false"
                                    class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-sm
                                        {{ $monthData['month'] == $selectedMonth && $monthData['year'] == $selectedYear
                                            ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 font-medium'
                                            : 'text-gray-700 dark:text-gray-300' }}"
                                >
                                    {{ $monthData['label'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="mb-6">
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Search expenses in {{ $selectedMonthName }}..."
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
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $expenses->count() }} {{ $expenses->count() === 1 ? 'expense' : 'expenses' }} in {{ $selectedMonthName }}
                        </span>
                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Total: ${{ number_format($expenses->sum('amount'), 2) }}
                        </span>
                    </div>
                </div>
            @else
                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-center text-gray-500 dark:text-gray-400">
                        No expenses recorded for {{ $selectedMonthName }}.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
