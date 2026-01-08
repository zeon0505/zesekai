<?php

namespace App\Livewire\Admin\Studio;

use App\Models\Studio;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public function delete($id)
    {
        Studio::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.studio.index', [
            'studios' => Studio::latest()->paginate(10)
        ]);
    }
}
