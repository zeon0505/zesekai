<?php

namespace App\Livewire\Admin\Studio;

use App\Models\Studio;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class Create extends Component
{
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255|unique:studios,name',
    ];

    public function save()
    {
        $this->validate();

        Studio::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        return redirect()->route('admin.studios.index');
    }

    public function render()
    {
        return view('livewire.admin.studio.create');
    }
}
