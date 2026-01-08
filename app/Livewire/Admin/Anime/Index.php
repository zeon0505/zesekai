<?php

namespace App\Livewire\Admin\Anime;

use App\Models\Anime;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public $confirmId = null;

    public function confirmDelete($id)
    {
        $this->confirmId = $id;
        $this->dispatch('open-modal', 'confirm-anime-delete');
    }

    public function deleteConfirmed()
    {
        if ($this->confirmId) {
            Anime::find($this->confirmId)->delete();
            session()->flash('message', 'Anime successfully deleted.');
            $this->confirmId = null;
            $this->dispatch('close-modal', 'confirm-anime-delete');
        }
    }

    public function render()
    {
        $animes = Anime::where('title', 'like', '%'.$this->search.'%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.anime.index', compact('animes'));
    }
}
