<div class="flex flex-col h-full" wire:poll.2s="checkForNewMessages">
    {{-- Chat Header --}}
    <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
        <h1 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $chat->title }}</h1>
    </div>

    {{-- Messages Container --}}
    <div class="flex-1 overflow-y-auto px-6 py-4" id="messages-container">
        @if(count($messages) === 0)
            <div class="flex items-center justify-center h-full">
                <div class="text-center">
                    <div class="text-6xl mb-4">🤖</div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Hello! I'm your AI assistant</h3>
                    <p class="text-gray-600 dark:text-gray-400">How can I help you today?</p>
                </div>
            </div>
        @else
            <div class="space-y-6 max-w-4xl mx-auto">
                @foreach($messages as $message)
                    <div class="flex {{ $message['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-3xl {{ $message['role'] === 'user' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800' }} rounded-lg px-4 py-3 shadow">
                            {{-- Role indicator --}}
                            <div class="flex items-center mb-2">
                                @if($message['role'] === 'user')
                                    <div class="w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs">
                                        U
                                    </div>
                                    <span class="ml-2 text-sm font-medium">You</span>
                                @else
                                    <div class="w-6 h-6 rounded-full bg-gray-500 flex items-center justify-center text-white text-xs">
                                        AI
                                    </div>
                                    <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">Assistant</span>
                                @endif
                            </div>

                            {{-- Message content --}}
                            <div class="{{ $message['role'] === 'user' ? 'text-white' : 'text-gray-900 dark:text-white' }}">
                                {{ $message['parts']['text'] ?? '' }}
                            </div>

                            {{-- Actions for assistant messages --}}
                            @if($message['role'] === 'assistant')
                                <div class="flex items-center mt-3 space-x-2">
                                    <button 
                                        wire:click="updateMessage({{ $message['id'] }}, true)"
                                        class="text-green-600 hover:text-green-700 text-sm"
                                        title="Upvote"
                                    >
                                        👍
                                    </button>
                                    <button 
                                        wire:click="updateMessage({{ $message['id'] }}, false)"
                                        class="text-red-600 hover:text-red-700 text-sm"
                                        title="Downvote"
                                    >
                                        👎
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                {{-- Streaming indicator --}}
                @if($isStreaming)
                    <div class="flex justify-start">
                        <div class="bg-white dark:bg-gray-800 rounded-lg px-4 py-3 shadow">
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 rounded-full bg-gray-500 flex items-center justify-center text-white text-xs">
                                    AI
                                </div>
                                <div class="flex space-x-1">
                                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    {{-- Message Input --}}
    <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-4">
        <form wire:submit="sendMessage" class="flex space-x-4">
            <div class="flex-1">
                <textarea 
                    wire:model="message"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white resize-none"
                    rows="2"
                    placeholder="Type your message..."
                    required
                    @disabled($isStreaming)
                ></textarea>
            </div>
            <div class="flex flex-col space-y-2">
                <select 
                    wire:model="model" 
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm"
                    @disabled($isStreaming)
                >
                    @foreach(App\Enums\ModelName::getAvailableModels() as $modelOption)
                        <option value="{{ $modelOption['id'] }}">{{ $modelOption['name'] }}</option>
                    @endforeach
                </select>
                <button 
                    type="submit" 
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50"
                    @disabled($isStreaming || empty(trim($message)))
                >
                    @if($isStreaming)
                        <span class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Sending...
                        </span>
                    @else
                        Send
                    @endif
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Auto-scroll to bottom when new messages arrive --}}
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.hook('morph.updated', ({ el, component }) => {
            const container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    });
</script>