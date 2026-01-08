<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.admin')]
class General extends Component
{
    use WithFileUploads;

    public $logo;
    public $existingLogo;

    public function mount()
    {
        $this->existingLogo = Setting::get('site_logo');
    }

    public function saveLogo()
    {
        $this->validate([
            'logo' => 'image|max:1024' // 1MB Max
        ]);

        $path = $this->logo->store('settings', 'public');
        
        Setting::updateOrCreate(
            ['key' => 'site_logo'],
            ['value' => $path, 'type' => 'image']
        );

        $this->existingLogo = $path;
        $this->logo = null;
        
        session()->flash('message', 'Logo updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.settings.general');
    }
}
