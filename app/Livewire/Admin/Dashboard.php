<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'totalAnime' => \App\Models\Anime::count(),
            'totalUsers' => \App\Models\User::count(),
            'premiumUsers' => \App\Models\User::where('is_premium', true)->count(),
        ]);
    }
}
