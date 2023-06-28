<?php

namespace App\Http\Livewire\AccountHealthCheck;

use Livewire\Component;
use App\Enums\ScriptType;
use App\Models\ShellScript;
use Illuminate\Support\Collection;

class ListScripts extends Component
{
    public Collection $scripts;
    public Collection $templates;

    protected $listeners = [
        'shell-script-updated' => 'loadScripts',
        'shell-script-template-updated' => 'loadScriptTemplates',
        'deleteScript',
    ];

    public function mount()
    {
        $this->loadScripts();
        $this->loadScriptTemplates();
    }

    public function render()
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

    public function deleteScript(int $shellScriptId): void
    {
        ShellScript::where('id', $shellScriptId)->delete();
        $this->loadScripts();
    }
}
