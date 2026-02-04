<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Katalog Anime')]
class Catalog extends Component
{
    public function render()
    {
        return view('livewire.public.catalog');
    }
}
