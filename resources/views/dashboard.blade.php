<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>

        <!-- Show Current Month -->
        <div class="text-4xl font-bold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">
            {{ \Carbon\Carbon::now()->format('F') }}
        </div>
    </x-slot>

    <div class="py-6 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <livewire:dashboard.projection-info-micro />

            <!-- Budget Overview -->
            <div class="mb-6">
                <livewire:dashboard.budget-overview />
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">


                    <div class="grid grid-cols-2 gap-4 mt-6">


                        <a href="{{ route('expense-list') }}" class="flex flex-col items-center justify-center p-6 bg-white border-2 border-purple-200 rounded-xl hover:border-purple-400 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
                            <span class="text-4xl mb-2">📋</span>
                            <div class="text-purple-600 font-bold text-lg text-center">
                                View Expenses
                            </div>
                            <p class="text-gray-500 text-xs mt-1 text-center hidden md:block">Manage your expenses</p>
                        </a>

                        <a href="{{ route('expenses') }}" class="flex flex-col items-center justify-center p-6 bg-white border-2 border-blue-200 rounded-xl hover:border-blue-400 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1">
                            <span class="text-4xl mb-2">💰</span>
                            <div class="text-blue-600 font-bold text-lg text-center">
                                Add Expense
                            </div>
                            <p class="text-gray-500 text-xs mt-1 text-center hidden md:block">Record new expense</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Projection Info Compact -->
            {{-- <div class="mb-6">
                <livewire:dashboard.projection-info-compact />
            </div> --}}
        </div>
    </div>
</x-app-layout>
