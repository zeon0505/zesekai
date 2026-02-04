<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Trending Anime')]
class Trending extends Component
{
    public function render()
    {
        return view('livewire.public.trending');
    }
}
