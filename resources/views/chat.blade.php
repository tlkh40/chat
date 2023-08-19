<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Channel: #{{ $channel->name }}
        </h2>
        <span class="text-gray-300">
            by <span class="text-white font-medium">{{ $channel->user->name }}</span>
        </span>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <livewire:chat-view :channel="$channel" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
