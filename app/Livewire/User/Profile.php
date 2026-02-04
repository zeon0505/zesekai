<?php

namespace App\Livewire\User;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.user')]
#[Title('Profil Saya')]
class Profile extends Component
{
    public function render()
    {
        return view('livewire.user.profile');
    }
}
