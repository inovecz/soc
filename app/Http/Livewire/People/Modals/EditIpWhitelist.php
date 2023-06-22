<?php

namespace App\Http\Livewire\People\Modals;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class EditIpWhitelist extends ModalComponent
{
    public User $user;
    public array $whitelist = [];
    public ?string $ip_start = null;
    public ?string $ip_end = null;
    public ?string $description = null;

    protected $rules = [
        'ip_start' => 'required|ipv4',
        'ip_end' => 'nullable|ipv4',
        'description' => 'nullable|string',
    ];

    public static function closeModalOnEscape(): bool
    {
        return false;
    }

    public static function closeModalOnClickAway(): bool
    {
        return false;
    }

    public function mount()
    {
        $this->whitelist = json_decode(\Setting::get('ip_whitelist.'.$this->user->id) ?? '', true) ?? [];
    }

    public function render()
    {
        return view('livewire.people.modals.edit-ip-whitelist');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function addToWhitelist(): void
    {
        $validatedData = $this->validate();
        $whitelistItem = [
            'ip_start' => $validatedData['ip_start'],
            'ip_end' => $validatedData['ip_end'],
            'description' => $validatedData['description'],
        ];
        $this->whitelist[] = $whitelistItem;
        \Setting::set('ip_whitelist.'.$this->user->id, json_encode($this->whitelist));
    }

    public function deleteFromWhitelist(int $index): void
    {
        unset($this->whitelist[$index]);
        \Setting::set('ip_whitelist.'.$this->user->id, json_encode($this->whitelist));
    }
}
