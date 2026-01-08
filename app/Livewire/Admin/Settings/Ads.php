<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Ads extends Component
{
    public $adsense_client;
    public $adsense_header_code;
    public $adsense_sidebar_code;
    public $sponsor_banner_url;
    public $sponsor_link;
    public $sponsor_active = false;
    public $donation_link;
    public $donation_active = false;
    public $popunder_code;

    public function mount()
    {
        $this->adsense_client = Setting::get('adsense_client');
        $this->adsense_header_code = Setting::get('adsense_header_code');
        $this->adsense_sidebar_code = Setting::get('adsense_sidebar_code');
        $this->sponsor_banner_url = Setting::get('sponsor_banner_url');
        $this->sponsor_link = Setting::get('sponsor_link');
        $this->sponsor_active = Setting::get('sponsor_active', false);
        $this->donation_link = Setting::get('donation_link');
        $this->donation_active = Setting::get('donation_active', false);
        $this->popunder_code = Setting::get('popunder_code');
    }

    public function save()
    {
        Setting::updateOrCreate(['key' => 'adsense_client'], ['value' => $this->adsense_client]);
        Setting::updateOrCreate(['key' => 'adsense_header_code'], ['value' => $this->adsense_header_code]);
        Setting::updateOrCreate(['key' => 'adsense_sidebar_code'], ['value' => $this->adsense_sidebar_code]);
        Setting::updateOrCreate(['key' => 'sponsor_banner_url'], ['value' => $this->sponsor_banner_url]);
        Setting::updateOrCreate(['key' => 'sponsor_link'], ['value' => $this->sponsor_link]);
        Setting::updateOrCreate(['key' => 'sponsor_active'], ['value' => $this->sponsor_active]);
        Setting::updateOrCreate(['key' => 'donation_link'], ['value' => $this->donation_link]);
        Setting::updateOrCreate(['key' => 'donation_active'], ['value' => $this->donation_active]);
        Setting::updateOrCreate(['key' => 'popunder_code'], ['value' => $this->popunder_code]);

        session()->flash('message', 'Ads & Donation settings updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.settings.ads');
    }
}
