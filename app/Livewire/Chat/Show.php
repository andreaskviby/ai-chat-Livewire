<?php

declare(strict_types=1);

namespace App\Livewire\Chat;

use App\Models\Chat;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    public Chat $chat;

    public function mount(Chat $chat)
    {
        $this->chat = $chat;
    }

    public function render()
    {
        $chatHistory = null;

        if (Auth::check()) {
            $chatHistory = Auth::user()->chats()->orderBy('updated_at', 'desc')->paginate(25);
        }

        return view('livewire.chat.show', [
            'chat' => $this->chat->load('messages'),
            'chatHistory' => $chatHistory,
        ]);
    }
}