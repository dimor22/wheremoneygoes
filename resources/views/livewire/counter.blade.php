<div class="text-center">
    <h1 class="text-2xl font-bold mb-4">Counter: {{ $count }}</h1>
    <div class="space-x-4">
        <button wire:click="increment" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Increment
        </button>
        <button wire:click="decrement" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Decrement
        </button>
    </div>
</div>
