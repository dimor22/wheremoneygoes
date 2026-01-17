<div>
    <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg shadow px-3 py-2 mb-6 text-white flex items-center justify-center">
        <div class="flex gap-3">
            <div class="text-center">
                <p class="text-xs opacity-90">Daily</p>
                <p class="text-lg font-bold">${{ number_format($dailyAverage, 0) }}</p>
            </div>
            <div class="text-white opacity-50">→</div>
            <div class="text-center">
                <p class="text-xs opacity-90">Projected</p>
                <p class="text-lg font-bold">${{ number_format($projectedMonthlySpending, 0) }}</p>
            </div>
            <div class="text-white opacity-50">→</div>
            <div class="text-center">
                @if($budget > 0 && $projectedMonthlySpending > $budget)
                    <p class="text-xs opacity-90">Over Budget</p>
                @endif
                @if($budget > 0)
                    <p class="text-lg font-bold">
                        {{ $isOverBudget ? '+' : '' }}{{ number_format($projectionVsBudget, 1) }}%
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
