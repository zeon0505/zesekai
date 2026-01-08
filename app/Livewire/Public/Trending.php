<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Trending extends Component
{
    public function render()
    {
        return view('livewire.public.trending');
    }
}
