<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Household Management Section -->
            <livewire:settings.household-management />

            <!-- Budget and Categories/Stores Settings -->
            <livewire:settings.app-settings />
        </div>
    </div>
</x-app-layout>
