<?php

namespace App\Livewire;

use App\Models\Anime;
use Livewire\Component;

class AnimeDetail extends Component
{
    public $anime;

    public function mount($slug)
    {
        $this->anime = Anime::with(['genres', 'studio', 'episodes'])->where('slug', $slug)->firstOrFail();
    }

    public function playEpisode($episodeId)
    {
        $user = auth()->user();
        $isPremium = $user && $user->is_premium;
        
        if (!$isPremium) {
            $ip = request()->ip();
            $watchCount = \App\Models\WatchLog::where(function($q) use ($user, $ip) {
                if ($user) $q->where('user_id', $user->id);
                else $q->where('ip_address', $ip);
            })->count();

            if ($watchCount >= 3) {
                $this->dispatch('limit-reached');
                return null;
            }

            // Log the watch
            \App\Models\WatchLog::create([
                'user_id' => $user->id ?? null,
                'ip_address' => $ip,
                'episode_id' => $episodeId
            ]);
        }

        $episode = \App\Models\Episode::find($episodeId);
        return $episode ? [
            'id' => $episode->id,
            'title' => $episode->title ?? 'Episode ' . $episode->episode_number,
            'url' => $episode->video_url,
            'number' => $episode->episode_number
        ] : null;
    }

    public function render()
    {
        return view('livewire.anime-detail')->layout('layouts.app');
    }
}
