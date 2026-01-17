<div>
    <div class="px-3 py-2 mb-6 flex items-center justify-center md:justify-end">
        <div class="flex gap-3">
            <div class="text-center">
                <p class="text-xs opacity-90">Daily</p>
                <p class="text-lg font-bold">${{ number_format($dailyAverage, 0) }}</p>
            </div>
            <div class="">→</div>
            <div class="text-center">
                <p class="text-xs opacity-90">Projected</p>
                {{-- if projectedMonthlySpending is greater than budget change the color to red, otherwise green --}}
                <p class="text-lg font-bold {{ $isOverBudget ? 'text-red-600' : 'text-green-600' }}">$ {{ number_format($projectedMonthlySpending, 0) }}</p>
            </div>
            <div class="">→</div>
            <div class="text-center">
                @if($budget > 0 && $projectedMonthlySpending > $budget)
                    <p class="text-xs opacity-90">Projected Over Budget</p>
                @endif
                @if($budget > 0)
                    <p class="text-lg font-bold {{ $isOverBudget ? 'text-red-600' : 'text-green-600' }}">
                        {{ $isOverBudget ? '+' : '' }}{{ number_format($projectionVsBudget, 1) }}%
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
