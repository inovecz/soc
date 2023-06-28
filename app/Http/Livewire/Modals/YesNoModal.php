<?php

namespace App\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

class YesNoModal extends ModalComponent
{
    public string $type = 'info';
    public string $title;
    public string $message;
    public string $action;
    public array $params = [];

    public function mount(string $type): void
    {
        $this->type = $type;
    }

    public function render(): View
    {
        return view('livewire.modals.yes-no-modal');
    }

    public function confirm(): void
    {
        $this->emit($this->action, ...array_values($this->params));
        $this->closeModal();
    }
}
