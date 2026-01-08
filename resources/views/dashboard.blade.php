<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Budget Overview -->
            <div class="mb-6">
                <livewire:dashboard.budget-overview />
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Welcome to Where the Money Goes!</h3>
                    <p class="text-gray-600 mb-4">
                        Track your monthly expenses and stay on budget.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <a href="{{ route('expenses') }}" class="block p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <div class="text-blue-600 font-semibold text-lg mb-2">💰 Add Expense</div>
                            <p class="text-gray-600 text-sm">Record a new expense with amount, category, and store</p>
                        </a>

                        <a href="{{ route('settings') }}" class="block p-6 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <div class="text-green-600 font-semibold text-lg mb-2">⚙️ Settings</div>
                            <p class="text-gray-600 text-sm">Set your monthly budget and manage preferences</p>
                        </a>

                        <div class="block p-6 bg-purple-50 rounded-lg">
                            <div class="text-purple-600 font-semibold text-lg mb-2">📊 Reports</div>
                            <p class="text-gray-600 text-sm">Coming soon: View your spending analytics</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
