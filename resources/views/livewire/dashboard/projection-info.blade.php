<div>
    <div class="bg-gradient-to-br from-purple-600 via-pink-600 to-red-600 rounded-lg shadow-lg p-6 text-white">
        <!-- Header -->
        <div class="mb-6">
            <h3 class="text-2xl font-bold mb-1">📊 Spending Projection</h3>
            <p class="text-purple-100 text-sm">Based on your spending pattern over {{ $daysElapsed }} days</p>
        </div>

        <!-- Main Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Daily Average -->
            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-6 text-center transform transition hover:scale-105">
                <div class="text-purple-100 text-sm font-medium mb-2">Daily Average Spent</div>
                <div class="text-4xl font-bold mb-1">${{ number_format($dailyAverage, 2) }}</div>
                <div class="text-xs text-purple-100">per day</div>
            </div>

            <!-- Projected Monthly -->
            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-6 text-center transform transition hover:scale-105">
                <div class="text-purple-100 text-sm font-medium mb-2">Projected Monthly Total</div>
                <div class="text-4xl font-bold mb-1">${{ number_format($projectedMonthlySpending, 2) }}</div>
                <div class="text-xs text-purple-100">if spending continues at this rate</div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="border-t border-white border-opacity-30 pt-4">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-center text-sm">
                <div>
                    <p class="text-purple-100 mb-1">Current Spending</p>
                    <p class="font-semibold">${{ number_format($currentMonthExpenses, 2) }}</p>
                </div>
                <div>
                    <p class="text-purple-100 mb-1">Days Tracked</p>
                    <p class="font-semibold">{{ $daysElapsed }} / {{ $daysInMonth }}</p>
                </div>
                @if($budget > 0)
                    <div class="col-span-2 md:col-span-1">
                        <p class="text-purple-100 mb-1">vs. Budget</p>
                        <p class="font-semibold {{ $projectionVsBudget > 0 ? 'text-red-300' : 'text-green-300' }}">
                            {{ $projectionVsBudget > 0 ? '+' : '' }}{{ number_format($projectionVsBudget, 1) }}%
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Warning or Info Message -->
        @if($budget > 0 && $projectedMonthlySpending > $budget)
            <div class="mt-4 bg-red-500 bg-opacity-30 backdrop-blur-sm rounded-lg p-3 text-center border border-red-300 border-opacity-50">
                <p class="text-sm font-medium">
                    ⚠️ Projected to exceed budget by ${{ number_format($projectedMonthlySpending - $budget, 2) }}
                </p>
            </div>
        @elseif($budget > 0 && $projectedMonthlySpending < $budget)
            <div class="mt-4 bg-green-500 bg-opacity-30 backdrop-blur-sm rounded-lg p-3 text-center border border-green-300 border-opacity-50">
                <p class="text-sm font-medium">
                    ✅ Projected to stay under budget by ${{ number_format($budget - $projectedMonthlySpending, 2) }}
                </p>
            </div>
        @endif

        @if($daysElapsed < 3)
            <div class="mt-4 bg-yellow-500 bg-opacity-30 backdrop-blur-sm rounded-lg p-3 text-center border border-yellow-300 border-opacity-50">
                <p class="text-sm">
                    📅 Projections are more accurate after a few days of spending data
                </p>
            </div>
        @endif
    </div>
</div>
