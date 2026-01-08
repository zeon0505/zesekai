<?php

namespace App\Livewire\Admin\Genre;

use App\Models\Genre;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public function delete($id)
    {
        Genre::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.genre.index', [
            'genres' => Genre::latest()->paginate(10)
        ]);
    }
}
