<div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <button
            wire:click="$toggle('isOpen')"
            class="w-full flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 -m-4 p-4 rounded-lg transition"
        >
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">📊 Spending Projection</h3>
            <div class="flex items-center gap-2">
                @if($daysElapsed < 3 && $isOpen)
                    <span class="text-xs text-yellow-600 dark:text-yellow-400">Early estimate</span>
                @endif
                <svg
                    class="w-5 h-5 text-gray-500 transition-transform {{ $isOpen ? 'rotate-180' : '' }}"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </button>

        @if($isOpen)
            <div class="mt-4">
                <div class="grid grid-cols-2 gap-3">
                    <!-- Daily Average -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded p-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Daily Avg</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-gray-100">${{ number_format($dailyAverage, 2) }}</p>
                    </div>

                    <!-- Projected Monthly -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded p-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">Projected</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-gray-100">${{ number_format($projectedMonthlySpending, 2) }}</p>
                    </div>
                </div>

                @if($budget > 0)
                    <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">vs. Budget:</span>
                            <span class="font-semibold {{ $projectionVsBudget > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                {{ $projectionVsBudget > 0 ? '+' : '' }}{{ number_format($projectionVsBudget, 1) }}%
                            </span>
                        </div>
                    </div>
                @endif

                <!-- More Details Button -->
                <div class="mt-3">
                    <a
                        href="{{ route('projection') }}"
                        wire:navigate
                        class="block w-full text-center px-4 py-2 text-sm font-medium text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-900 dark:bg-opacity-20 rounded-md hover:bg-purple-100 dark:hover:bg-purple-900 dark:hover:bg-opacity-30 transition"
                    >
                        More Details →
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
