<?php

namespace App\Livewire\Admin\Episode;

use App\Models\Anime;
use App\Models\Episode;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public Anime $anime;

    public function mount(Anime $anime)
    {
        $this->anime = $anime;
    }

    public $confirmId = null;

    public function confirmDelete($id)
    {
        $this->confirmId = $id;
        $this->dispatch('open-modal', 'confirm-episode-delete');
    }

    public function deleteConfirmed()
    {
        if ($this->confirmId) {
            Episode::find($this->confirmId)->delete();
            session()->flash('message', 'Episode successfully deleted.');
            $this->confirmId = null;
            $this->dispatch('close-modal', 'confirm-episode-delete');
        }
    }

    public function render()
    {
        return view('livewire.admin.episode.index', [
            'episodes' => $this->anime->episodes()->orderBy('episode_number', 'desc')->paginate(15)
        ]);
    }
}
