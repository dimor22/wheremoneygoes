<div>
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-lg shadow-lg p-8 text-white">
        <!-- Current Month -->
        <div class="text-center mb-6">
            <h1 class="text-5xl font-bold mb-2">{{ $currentMonth }}</h1>
            <p class="text-blue-100 text-sm">Current Budget Period</p>
        </div>

        <!-- Budget Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
            <!-- Budget Amount -->
            <div class="text-center col-span-2 md:col-span-1">
                <p class="text-blue-100 text-sm mb-1">Monthly Budget</p>
                <p class="text-3xl font-bold">${{ number_format($budget, 2) }}</p>
            </div>

            <!-- Spent Amount -->
            <div class="text-center">
                <p class="text-blue-100 text-sm mb-1">Spent This Month</p>
                <p class="text-3xl font-bold">${{ number_format($spent, 2) }}</p>
                @if($budget > 0)
                    <p class="text-sm text-blue-100 mt-1">{{ number_format($percentage, 1) }}% of budget</p>
                @endif
            </div>

            <!-- Remaining Amount -->
            <div class="text-center">
                <p class="text-blue-100 text-sm mb-1">Remaining</p>
                <p class="text-3xl font-bold {{ $remaining < 0 ? 'text-red-300' : '' }}">
                    ${{ number_format($remaining, 2) }}
                </p>
                @if($remaining < 0)
                    <p class="text-sm text-red-200 mt-1">Over budget!</p>
                @elseif($budget > 0)
                    <p class="text-sm text-blue-100 mt-1">{{ number_format(100 - $percentage, 1) }}% left</p>
                @endif
            </div>
        </div>

        <!-- Progress Bar -->
        @if($budget > 0)
            <div class="mt-6">
                <div class="w-full bg-blue-800 rounded-full h-3 overflow-hidden">
                    <div
                        class="h-3 rounded-full transition-all duration-500 {{ $percentage >= 100 ? 'bg-red-500' : ($percentage >= 75 ? 'bg-yellow-400' : 'bg-green-400') }}"
                        style="width: {{ min($percentage, 100) }}%"
                    ></div>
                </div>
            </div>
        @endif

        <!-- Warning Messages -->
        @if($budget == 0)
            <div class="mt-6 text-center">
                <p class="text-blue-100 text-sm">
                    Set your monthly budget in
                    <a href="{{ route('settings') }}" class="underline hover:text-white">Settings</a>
                    to track your spending
                </p>
            </div>
        @elseif($percentage >= 90 && $remaining > 0)
            <div class="mt-6 text-center">
                <p class="text-yellow-200 text-sm">⚠️ You've used {{ number_format($percentage, 1) }}% of your budget</p>
            </div>
        @endif
    </div>
</div>
