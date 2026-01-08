<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'User successfully deleted.');
    }

    public function togglePremium($id)
    {
        $user = User::find($id);
        $user->update(['is_premium' => !$user->is_premium ?? false]);
    }

    public function render()
    {
        return view('livewire.admin.user.index', [
            'users' => User::latest()->paginate(15)
        ]);
    }
}
