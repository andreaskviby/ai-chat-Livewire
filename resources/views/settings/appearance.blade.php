<x-layouts.app>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Appearance Settings</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Customize how the application looks.</p>
                </div>
                
                <div class="px-6 py-4">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Theme
                        </label>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Choose your preferred theme or use system setting to automatically match your device.
                        </p>
                        
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="theme" value="light" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-900 dark:text-white">Light</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="theme" value="dark" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-900 dark:text-white">Dark</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="theme" value="system" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                                <span class="ml-2 text-sm text-gray-900 dark:text-white">System</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 text-center">
                <a href="{{ route('chats.index') }}" class="text-blue-600 hover:text-blue-500">
                    ← Back to Chat
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>