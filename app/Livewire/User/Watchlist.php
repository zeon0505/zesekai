<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.user')]
#[Title('Watchlist')]
class Watchlist extends Component
{
    public function render()
    {
        $watchlists = \App\Models\Watchlist::where('user_id', Auth::id())
            ->with('anime')
            ->latest()
            ->get();
            
        return view('livewire.user.watchlist', [
            'watchlists' => $watchlists
        ]);
    }
}
