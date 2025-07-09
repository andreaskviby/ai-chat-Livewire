<?php

declare(strict_types=1);

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\Message;
use App\Enums\ModelName;
use Livewire\Component;
use App\Jobs\ProcessChatMessage;
use Illuminate\Support\Facades\Auth;

class ChatInterface extends Component
{
    public Chat $chat;
    public string $message = '';
    public ModelName $model = ModelName::GPT_4_1_NANO;
    public bool $isStreaming = false;
    public array $messages = [];
    public int $lastMessageCount = 0;

    public function mount(Chat $chat)
    {
        $this->chat = $chat;
        $this->loadMessages();
        $this->lastMessageCount = count($this->messages);
    }

    public function loadMessages()
    {
        $this->messages = $this->chat->messages()
            ->orderBy('created_at')
            ->get()
            ->toArray();
    }

    public function checkForNewMessages()
    {
        // Refresh the chat to get updated messages
        $this->chat->refresh();
        $this->loadMessages();
        
        // If we have new messages and were streaming, stop streaming
        if (count($this->messages) > $this->lastMessageCount) {
            $this->lastMessageCount = count($this->messages);
            if ($this->isStreaming) {
                $this->isStreaming = false;
            }
        }
    }

    public function sendMessage()
    {
        if (empty(trim($this->message))) {
            return;
        }

        // Create user message
        $userMessage = $this->chat->messages()->create([
            'role' => 'user',
            'parts' => [
                'text' => trim($this->message),
            ],
            'attachments' => '[]',
        ]);

        $messageText = $this->message;
        $this->message = '';
        $this->loadMessages();
        $this->lastMessageCount = count($this->messages);

        // Start streaming state
        $this->isStreaming = true;

        // Dispatch job to process the message
        ProcessChatMessage::dispatch($this->chat, $this->model);
    }

    public function updateMessage($messageId, $upvoted)
    {
        $message = $this->chat->messages()->find($messageId);
        if ($message) {
            $message->update(['is_upvoted' => $upvoted]);
        }
    }

    public function render()
    {
        return view('livewire.chat.chat-interface');
    }
}