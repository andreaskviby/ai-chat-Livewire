// Simple JavaScript for Livewire app
import './bootstrap';

// Auto-scroll chat messages
document.addEventListener('livewire:init', () => {
    Livewire.hook('morph.updated', ({ el, component }) => {
        if (component.fingerprint?.name === 'chat.chat-interface') {
            const container = document.getElementById('messages-container');
            if (container) {
                setTimeout(() => {
                    container.scrollTop = container.scrollHeight;
                }, 100);
            }
        }
    });
});