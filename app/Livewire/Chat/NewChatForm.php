<?php

declare(strict_types=1);

namespace App\Livewire\Chat;

use App\Models\Chat;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NewChatForm extends Component
{
    public string $message = '';
    public string $visibility = 'private';

    public function createChat()
    {
        $this->validate([
            'message' => 'required|string|max:1000',
            'visibility' => 'required|in:private,public',
        ]);

        $chat = Auth::user()->chats()->create([
            'title' => $this->message,
            'visibility' => $this->visibility,
        ]);

        return $this->redirect(route('chats.show', $chat));
    }

    public function render()
    {
        return view('livewire.chat.new-chat-form');
    }
}