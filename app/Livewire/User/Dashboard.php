<?php

namespace App\Livewire\User;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.user')]
class Dashboard extends Component
{
    public function render()
    {
        $recentHistory = \App\Models\WatchLog::where('user_id', auth()->id())
            ->with(['episode.anime'])
            ->orderBy('updated_at', 'desc')
            ->take(4)
            ->get();

        return view('livewire.user.dashboard', [
            'recentHistory' => $recentHistory
        ]);
    }
}
