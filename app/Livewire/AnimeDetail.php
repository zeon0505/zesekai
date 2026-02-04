<?php

namespace App\Livewire;

use App\Models\Anime;
use Livewire\Component;

class AnimeDetail extends Component
{
    public $anime;
    public $initialEpisodeId = null;
    public $initialTime = 0;

    public function mount($slug)
    {
        $this->anime = Anime::with(['genres', 'studio', 'episodes'])->where('slug', $slug)->firstOrFail();
        
        // Auto-detect last watched episode for this anime
        $user = auth()->user();
        $ip = request()->ip();
        
        $lastLog = \App\Models\WatchLog::whereHas('episode', function($q) {
                $q->where('anime_id', $this->anime->id);
            })
            ->where(function($q) use ($user, $ip) {
                if ($user) $q->where('user_id', $user->id);
                else $q->where('ip_address', $ip);
            })
            ->orderBy('updated_at', 'desc')
            ->first();

        if ($lastLog) {
            $this->initialEpisodeId = $lastLog->episode_id;
            $this->initialTime = $lastLog->last_time;
        }
    }

    public function playEpisode($episodeId)
    {
        $user = auth()->user();
        $isPremium = $user && $user->is_premium;
        $ip = request()->ip();
        
        // Always log the watch for history, regardless of premium
        $log = \App\Models\WatchLog::updateOrCreate(
            [
                'user_id' => $user->id ?? null,
                'ip_address' => $ip,
                'episode_id' => $episodeId
            ],
            ['updated_at' => now()] // Refresh timestamp to move to top of history
        );

        if (!$isPremium) {
            $watchCount = \App\Models\WatchLog::where(function($q) use ($user, $ip) {
                if ($user) $q->where('user_id', $user->id);
                else $q->where('ip_address', $ip);
            })->count();

            if ($watchCount >= 3) {
                $this->dispatch('limit-reached');
                return null;
            }
        }

        $episode = \App\Models\Episode::find($episodeId);
        return $episode ? [
            'id' => $episode->id,
            'title' => $episode->title ?? 'Episode ' . $episode->episode_number,
            'url' => $episode->video_url,
            'number' => $episode->episode_number,
            'last_time' => $log->last_time ?? 0
        ] : null;
    }

    public function saveProgress($episodeId, $seconds)
    {
        $user = auth()->user();
        $ip = request()->ip();
        $seconds = (int)$seconds;

        \App\Models\WatchLog::where('episode_id', $episodeId)
            ->where(function($q) use ($user, $ip) {
                if ($user) $q->where('user_id', $user->id);
                else $q->where('ip_address', $ip);
            })
            ->update(['last_time' => $seconds]);
    }

    public function render()
    {
        return view('livewire.anime-detail')
            ->layout('layouts.app', ['title' => $this->anime->title]);
    }
}
