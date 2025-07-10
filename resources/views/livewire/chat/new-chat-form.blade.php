<div>
    <form wire:submit="createChat" class="w-full max-w-md mx-auto">
        <div class="mb-4">
            <textarea 
                wire:model="message"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                rows="3"
                placeholder="Type your message to start a new chat..."
                required
            ></textarea>
            @error('message') 
                <span class="text-red-500 text-sm">{{ $message }}</span> 
            @enderror
        </div>

        <div class="mb-4">
            <select wire:model="visibility" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="private">Private</option>
                <option value="public">Public</option>
            </select>
            @error('visibility') 
                <span class="text-red-500 text-sm">{{ $message }}</span> 
            @enderror
        </div>

        <button 
            type="submit" 
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Start Chat</span>
            <span wire:loading>Creating...</span>
        </button>
    </form>
</div>