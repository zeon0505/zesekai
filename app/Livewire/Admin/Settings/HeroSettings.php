<?php

namespace App\Livewire\Admin\Settings;

use App\Models\HeroSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class HeroSettings extends Component
{
    use WithFileUploads;

    public $image1;
    public $image2;
    public $upload1;
    public $upload2;

    public function mount()
    {
        $this->image1 = HeroSetting::where('key', 'hero_image_1')->first()?->value ?? 'https://m.media-amazon.com/images/M/MV5BNDFjYTIxMjctYTQ2ZC00OGQ4LWE3OGYtYTdiMzRkMTE1OTQxXkEyXkFqcGdeQXVyOTAyMDgxODQ@._V1_.jpg';
        $this->image2 = HeroSetting::where('key', 'hero_image_2')->first()?->value ?? 'https://m.media-amazon.com/images/M/MV5BZjZjNzI5MDctY2YyZC00NmM0LThlZWItMDhmYmQyYTgzOTQ2XkEyXkFqcGdeQXVyNjU1OTg0OTM@._V1_FMjpg_UX1000_.jpg';
    }

    public function save()
    {
        $this->validate([
            'image1' => 'nullable|string',
            'image2' => 'nullable|string',
            'upload1' => 'nullable|image|max:5120',
            'upload2' => 'nullable|image|max:5120',
        ]);

        if ($this->upload1) {
            $path = $this->upload1->store('hero', 'public');
            $this->image1 = '/storage/' . $path;
        }

        if ($this->upload2) {
            $path = $this->upload2->store('hero', 'public');
            $this->image2 = '/storage/' . $path;
        }

        HeroSetting::updateOrCreate(['key' => 'hero_image_1'], ['value' => $this->image1]);
        HeroSetting::updateOrCreate(['key' => 'hero_image_2'], ['value' => $this->image2]);

        $this->reset(['upload1', 'upload2']);
        session()->flash('message', 'Hero settings updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.settings.hero-settings');
    }
}
