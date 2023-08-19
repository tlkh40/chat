<?php

namespace App\Livewire;

use App\Models\Channel;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ChatView extends Component
{
    public Channel $channel;
    #[Rule('required|min:3|max:100|string')]
    public string $chatMessage;

    public function sendMessage() {
        $this->validate();

        Message::create([
            'channel_id' => $this->channel->id,
            'user_id' => Auth::user()->id,
            'contents' => $this->chatMessage
        ]);

        $this->chatMessage = '';
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div wire:poll.keep-alive id="messages" class="flex flex-col-reverse gap-2 bg-gray-900 p-3 rounded mb-2 min-h-[50vh] overflow-y-auto max-h-[50vh]">
                <div>
                    @foreach($channel->messages()->take(100)->orderBy('id', 'DESC')->get()->reverse() as $message)
                        <div class="flex flex-col" style="transform: translateZ(0);">
                            <span class="font-bold text-xl">{{ $message->user->name }}:</span>
                            <p>{{ $message->contents }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex flex-col gap-3">
                <form wire:submit="sendMessage" class="flex">
                    <div class="flex flex-col flex-1">
                        <x-text-input id="chatMessage" name="chatMessage" wire:model.blur="chatMessage" placeholder="Send a message..." class="flex-1" />
                    </div>
                    <x-secondary-button type="submit">
                        Send
                    </x-secondary-button>
                </form>
                @error('chatMessage')
                    <div class="border-red-500 border p-3  rounded text-red-200">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>
        HTML;
    }
}
