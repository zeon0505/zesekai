<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
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
