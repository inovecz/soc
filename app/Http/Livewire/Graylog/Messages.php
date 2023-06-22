<?php

namespace App\Http\Livewire\Graylog;

use Livewire\Component;
use App\Libraries\Graylog;

class Messages extends Component
{
    public array $messages = [];

    public function mount()
    {
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.graylog.messages', ['messages' => $this->messages]);
    }

    public function loadMessages(): void
    {
        $graylog = new Graylog();
        $this->messages = $graylog->getMessages();
    }
}
