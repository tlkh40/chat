<?php

namespace App\Livewire;

use App\Models\Channel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateChannel extends Component
{
    #[Rule('required|string|min:5|max:30')]
    public string $name;
    public Collection $channels;

    public function createChannel() {
        $this->validate();
        $this->dispatch('close-modal');
        Channel::create([
            'name' => $this->name,
            'user_id' => Auth::user()->id
        ]);
    }

    public function delete(int $id) {
        if (Auth::user()->id === Channel::find($id)->user_id) {
            Channel::destroy($id);
        }
    }

    public function render()
    {
        $this->channels = Channel::all();
        return <<<'HTML'
        <div>
            <x-primary-button x-on:click.prevent="$dispatch('open-modal', 'create-channel')" x-data="">
                Create channel
            </x-primary-button>
            <x-modal name="create-channel" focusable>
                <div class="p-6">
                    <form wire:submit="createChannel" wire:loading.class="opacity-50">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Create a channel') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Create a channel where you can chat with other users and stuff™') }}
                        </p>

                        <div class="mt-6">
                            <x-input-label value="Channel name" for="name" />

                            <x-text-input
                                id="Name"
                                wire:model.blur="name"
                                name="name"
                                class="mt-1 block w-full"
                                placeholder="{{ __('General') }}"
                            />

                            @error('name')
                                <x-input-error :messages="$message" class="mt-2" />
                            @enderror
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <x-primary-button class="ml-3">
                                {{ __('Create channel') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </x-modal>
            <div wire:poll class="flex flex-col gap-2 mt-3">
                @foreach($channels as $channel)
                <div class="p-3 bg-gray-700 items-center rounded flex gap-3 text-center justify-between">
                        <a class="flex-1" href="{{ url('dashboard/chat', $channel->id) }}" wire:navigate>
                            <h1 class="text-xl font-bold text-left">
                                #{{ $channel->name }}
                            </h1>
                        </a>
                        @if($channel->user->id === Auth::user()->id)
                            <x-danger-button class="text-center" wire:click="delete({{ $channel->id }})" wire:loading.class="opacity-50">delete</x-danger-button>
                        @else
                            <span class="text-gray-300">
                                by <span class="text-white font-medium">{{ $channel->user->name }}</span>
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        HTML;
    }
}
