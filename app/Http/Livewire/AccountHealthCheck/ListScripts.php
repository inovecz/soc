<?php

namespace App\Http\Livewire\AccountHealthCheck;

use Livewire\Component;
use App\Enums\ScriptType;
use App\Models\ShellScript;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;

class ListScripts extends Component
{
    public Collection $scripts;
    public Collection $templates;

    protected $listeners = [
        'shell-script-updated' => 'loadScripts',
        'shell-script-template-updated' => 'loadScriptTemplates',
    ];

    public function mount(): void
    {
        $this->loadScripts();
        $this->loadScriptTemplates();
    }

    public function render(): View
    {
        return view('livewire.account-health-check.list-scripts');
    }

    public function loadScripts(): void
    {
        $this->scripts = ShellScript::where('type', ScriptType::SCRIPT)->get();
    }

    public function loadScriptTemplates(): void
    {
        $this->templates = ShellScript::where('type', ScriptType::TEMPLATE)->get();
    }

    public function runScript(int $scriptId): void
    {
        $script = ShellScript::find($scriptId);
        $script->run();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Script run was successfully dispatched.')]);
    }
}
