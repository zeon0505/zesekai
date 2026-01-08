<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;

class WatchlistButton extends Component
{
    public $animeId;
    public $isInWatchlist = false;

    public function mount($animeId)
    {
        $this->animeId = $animeId;
        $this->checkWatchlistStatus();
    }

    public function checkWatchlistStatus()
    {
        if (Auth::check()) {
            $this->isInWatchlist = Watchlist::where('user_id', Auth::id())
                ->where('anime_id', $this->animeId)
                ->exists();
        }
    }

    public function toggleWatchlist()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->isInWatchlist) {
            Watchlist::where('user_id', Auth::id())
                ->where('anime_id', $this->animeId)
                ->delete();
            $this->isInWatchlist = false;
        } else {
            Watchlist::create([
                'user_id' => Auth::id(),
                'anime_id' => $this->animeId,
            ]);
            $this->isInWatchlist = true;
        }
    }

    public function render()
    {
        return view('livewire.components.watchlist-button');
    }
}
