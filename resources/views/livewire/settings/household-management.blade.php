<div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h3 class="text-lg font-semibold mb-4">Household Sharing</h3>

            @if($household)
                <!-- Current Household Info -->
                <div class="mb-6">
                    <h4 class="text-md font-medium mb-2">Your Household</h4>
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded">
                        <p class="mb-2"><strong>Name:</strong> {{ $household->name }}</p>
                        <p class="mb-2"><strong>Share Code:</strong>
                            <span class="font-mono text-lg bg-yellow-200 dark:bg-yellow-900 px-2 py-1 rounded">
                                {{ $household->share_code }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            Share this code with family members so they can join your household and access shared categories, stores, and budget.
                        </p>
                    </div>
                </div>

                <!-- Household Members -->
                <div class="mb-6">
                    <h4 class="text-md font-medium mb-2">Members ({{ $members->count() }})</h4>
                    <div class="space-y-2">
                        @foreach($members as $member)
                            <div class="bg-gray-100 dark:bg-gray-700 p-3 rounded flex items-center">
                                <div class="flex-1">
                                    <p class="font-medium">{{ $member->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $member->email }}</p>
                                </div>
                                @if($member->id === auth()->id())
                                    <span class="text-xs bg-blue-500 text-white px-2 py-1 rounded">You</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- No Household - Show Join Form -->
                <div class="mb-6">
                    <p class="mb-4 text-gray-600 dark:text-gray-400">
                        You are not currently in a household. Join a household to share expenses, categories, and stores with family members.
                    </p>

                    <form wire:submit.prevent="joinHousehold" class="mt-4">
                        <div class="mb-4">
                            <label for="join_code" class="block text-sm font-medium mb-2">Enter Share Code</label>
                            <input
                                type="text"
                                id="join_code"
                                wire:model="join_code"
                                maxlength="8"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 uppercase font-mono text-lg"
                                placeholder="ABCD1234"
                            >
                            @error('join_code')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                        >
                            Join Household
                        </button>
                    </form>
                </div>
            @endif

            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="mt-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mt-4 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
</div>
