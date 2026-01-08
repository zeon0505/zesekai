<?php

namespace App\Livewire\Admin\Studio;

use App\Models\Studio;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class Edit extends Component
{
    public Studio $studio;
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function mount(Studio $studio)
    {
        $this->studio = $studio;
        $this->name = $studio->name;
    }

    public function update()
    {
        $this->validate();

        $this->studio->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        return redirect()->route('admin.studios.index');
    }

    public function render()
    {
        return view('livewire.admin.studio.edit');
    }
}
