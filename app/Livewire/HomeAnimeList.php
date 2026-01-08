<?php

namespace App\Livewire;

use App\Models\Anime;
use App\Models\Genre;
use Livewire\Component;
use Livewire\WithPagination;

class HomeAnimeList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedGenre = '';

    protected $updatesQueryString = ['search', 'selectedGenre'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedGenre()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Anime::with('genres')->latest();

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->selectedGenre) {
            $query->whereHas('genres', function($q) {
                $q->where('slug', $this->selectedGenre);
            });
        }

        return view('livewire.home-anime-list', [
            'animes' => $query->paginate(12),
            'genres' => Genre::all(),
        ]);
    }
}
