<?php

namespace App\Http\Livewire\Modals;

use App\Libraries\Zabbix;
use LivewireUI\Modal\ModalComponent;

class ExecuteAction extends ModalComponent
{
    public $script;
    public int $scriptId;
    public int $hostId = 0;
    public ?array $scriptResult = null;

    public static function closeModalOnEscape(): bool
    {
        return false;
    }

    public static function closeModalOnClickAway(): bool
    {
        return false;
    }

    public function mount(): void
    {
        $this->scriptId = $this->script['scriptid'];
    }

    public function render()
    {
        return view('livewire.modals.execute-action');
    }

    public function execute(): void
    {
        $zabbix = new Zabbix();
        $this->scriptResult = $zabbix->executeScript($this->scriptId, $this->hostId);
    }
}
