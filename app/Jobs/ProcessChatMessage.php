<?php

declare(strict_types=1);

namespace App\Jobs;

use Generator;
use Throwable;
use App\Models\Chat;
use Prism\Prism\Prism;
use App\Enums\ModelName;
use Illuminate\Bus\Queueable;
use Prism\Prism\Enums\ChunkType;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Prism\Prism\ValueObjects\Messages\UserMessage;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;

class ProcessChatMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Chat $chat,
        public ModelName $model
    ) {}

    public function handle(): void
    {
        $messages = $this->buildConversationHistory($this->chat);
        $parts = [];

        try {
            $response = Prism::text()
                ->withSystemPrompt(view('prompts.system'))
                ->using($this->model->getProvider(), $this->model->value)
                ->withMessages($messages)
                ->asStream();

            foreach ($response as $chunk) {
                if (! isset($parts[$chunk->chunkType->value])) {
                    $parts[$chunk->chunkType->value] = '';
                }

                $parts[$chunk->chunkType->value] .= $chunk->text;
            }

            if ($parts !== []) {
                $this->chat->messages()->create([
                    'role' => 'assistant',
                    'parts' => $parts,
                    'attachments' => '[]',
                ]);
                $this->chat->touch();
            }

        } catch (Throwable $throwable) {
            Log::error("Chat stream error for chat {$this->chat->id}: ".$throwable->getMessage());
            
            // Create an error message
            $this->chat->messages()->create([
                'role' => 'assistant',
                'parts' => [
                    'text' => 'Sorry, I encountered an error while processing your request. Please try again.',
                ],
                'attachments' => '[]',
            ]);
        }
    }

    private function buildConversationHistory(Chat $chat): array
    {
        return $chat->messages()
            ->orderBy('created_at')
            ->get()
            ->map(fn ($message) => match ($message->role) {
                'user' => new UserMessage(content: $message->parts['text'] ?? ''),
                'assistant' => new AssistantMessage(content: $message->parts['text'] ?? ''),
            })
            ->toArray();
    }
}