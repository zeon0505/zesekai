<?php

namespace App\Livewire\Admin\Genre;

use App\Models\Genre;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class Create extends Component
{
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255|unique:genres,name',
    ];

    public function save()
    {
        $this->validate();

        Genre::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        return redirect()->route('admin.genres.index');
    }

    public function render()
    {
        return view('livewire.admin.genre.create');
    }
}
