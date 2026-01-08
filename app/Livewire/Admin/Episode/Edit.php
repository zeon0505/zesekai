<?php

namespace App\Livewire\Admin\Episode;

use App\Models\Episode;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Edit extends Component
{
    public Episode $episode;
    public $title;
    public $episode_number;
    public $video_url;
    public $thumbnail_image;

    protected $rules = [
        'episode_number' => 'required|integer',
        'title' => 'nullable|string|max:255',
        'video_url' => 'required|url',
        'thumbnail_image' => 'nullable|url',
    ];

    public function mount(Episode $episode)
    {
        $this->episode = $episode;
        $this->title = $episode->title;
        $this->episode_number = $episode->episode_number;
        $this->video_url = $episode->video_url;
        $this->thumbnail_image = $episode->thumbnail_image;
    }

    public function update()
    {
        $this->validate();

        $this->episode->update([
            'episode_number' => $this->episode_number,
            'title' => $this->title,
            'video_url' => $this->video_url,
            'thumbnail_image' => $this->thumbnail_image,
        ]);

        return redirect()->route('admin.anime.episodes.index', $this->episode->anime_id)->with('message', 'Episode updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.episode.edit');
    }
}
