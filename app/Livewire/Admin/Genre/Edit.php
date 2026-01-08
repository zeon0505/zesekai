<?php

namespace App\Livewire\Admin\Genre;

use App\Models\Genre;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class Edit extends Component
{
    public Genre $genre;
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function mount(Genre $genre)
    {
        $this->genre = $genre;
        $this->name = $genre->name;
    }

    public function update()
    {
        $this->validate();

        $this->genre->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        return redirect()->route('admin.genres.index');
    }

    public function render()
    {
        return view('livewire.admin.genre.edit');
    }
}
