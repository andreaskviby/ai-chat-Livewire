<x-layouts.app>
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <div class="hidden w-64 bg-white dark:bg-gray-800 shadow-lg md:block">
            <div class="flex h-full flex-col">
                {{-- Header --}}
                <div class="border-b border-gray-200 dark:border-gray-700 px-4 py-4">
                    <h1 class="text-lg font-semibold text-gray-900 dark:text-white">{{ config('app.name') }}</h1>
                </div>

                {{-- Chat History --}}
                <div class="flex-1 overflow-y-auto px-4 py-4">
                    @if($chatHistory && $chatHistory->count() > 0)
                        <div class="space-y-2">
                            @foreach($chatHistory as $chat)
                                <a href="{{ route('chats.show', $chat) }}" 
                                   class="block rounded-lg px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    {{ Str::limit($chat->title, 30) }}
                                </a>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $chatHistory->links() }}
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">No chat history yet.</p>
                    @endif
                </div>

                {{-- User Info --}}
                @auth
                    <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="h-8 w-8 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            {{-- Chat Area --}}
            <div class="flex-1 flex items-center justify-center px-4">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Welcome to AI Chat</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">Start a new conversation to begin chatting with AI.</p>
                    
                    @auth
                        <livewire:chat.new-chat-form />
                    @else
                        <div class="space-x-4">
                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Sign Up
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>