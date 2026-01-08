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


                    <div class="grid grid-cols-2 gap-4 mt-6">


                        <a href="{{ route('expense-list') }}" class="block p-6 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                            <div class="text-purple-600 font-semibold text-xl mb-2 text-center md:text-left">
                                <span class="text-3xl pr-2">📋</span> View Expenses
                            </div>
                            <p class="text-gray-600 text-sm hidden md:block">View and manage your recorded expenses</p>
                        </a>

                        <a href="{{ route('expenses') }}" class="block p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <div class="text-blue-600 font-semibold text-xl mb-2 text-center md:text-left">
                                <span class="text-3xl pr-2">💰</span> Add Expense
                            </div>
                            <p class="text-gray-600 text-sm hidden md:block">Record a new expense with amount, category, and store</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
