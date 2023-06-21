<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Logo extends Component
{
    use WithFileUploads;

    public $uploadedLogo;
    public ?string $logo = null;

    protected $rules = [
        'uploadedLogo' => 'required|image|mimes:jpg,png,jpeg,gif,webp,svg|max:2048',
    ];

    protected $messages = [];

    public function mount()
    {
        $this->messages = [
            'uploadedLogo.required' => __('No logo file provided'),
            'uploadedLogo.image' => 'Please upload a valid image.',
            'uploadedLogo.mimes' => __('Supported image types: jpg, png, gif, webp, svg.'),
            'uploadedLogo.max' => __('Max file size: 2MB.'),
        ];

        $this->fetchLogo();
    }

    public function render()
    {
        return view('livewire.settings.logo', ['logo' => $this->logo]);
    }

    public function submit()
    {
        $this->validate();

        $image_path = $this->uploadedLogo->store('logos');
        \Setting::set('logo.'.auth()->user()->id, $image_path);
        $this->fetchLogo();
        $this->emit('menu-settings-updated');
    }

    private function fetchLogo()
    {
        $logoPath = \Setting::get('logo.'.auth()->user()->id);
        if ($logoPath) {
            $logo = Storage::get($logoPath, null);
            $extension = pathinfo($logoPath, PATHINFO_EXTENSION);
            $base64Logo = base64_encode($logo);
            $this->logo = 'data:image/'.$extension.';base64,'.$base64Logo;
        } else {
            $this->logo = null;
        }
    }

    public function removeLogo()
    {
        $logoPath = \Setting::get('logo.'.auth()->user()->id);
        if ($logoPath) {
            Storage::delete($logoPath);
        }
        \Setting::forget('logo.'.auth()->user()->id);
        $this->fetchLogo();
        $this->emit('menu-settings-updated');
    }
}
