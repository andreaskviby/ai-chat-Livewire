<?php

declare(strict_types=1);

namespace App\Livewire\Chat;

use App\Models\Chat;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $chatHistory = null;

        if (Auth::check()) {
            $chatHistory = Auth::user()->chats()->orderBy('updated_at', 'desc')->paginate(25);
        }

        return view('livewire.chat.index', [
            'chatHistory' => $chatHistory,
        ]);
    }
}