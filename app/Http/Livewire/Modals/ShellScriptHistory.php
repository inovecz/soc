<?php

namespace App\Http\Livewire\Modals;

use App\Models\ShellScript;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

class ShellScriptHistory extends ModalComponent
{
    public int $shellScriptId;
    public Collection $shellScriptRuns;
    protected ShellScript $shellScript;

    public function mount(): void
    {
        $this->shellScript = ShellScript::find($this->shellScriptId);
        $this->shellScriptRuns = $this->shellScript->runs()->orderBy('created_at', 'desc')->limit(10)->get();
    }

    public function render(): View
    {
        return view('livewire.modals.shell-script-history');
    }
}
