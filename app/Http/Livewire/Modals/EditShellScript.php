<?php

namespace App\Http\Livewire\Modals;

use App\Enums\ScriptType;
use App\Models\ShellScript;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Validation\ValidationException;

class EditShellScript extends ModalComponent
{
    public ?string $name = null;
    public ?string $description = null;
    public ?int $shellScriptId = null;
    public Collection $shellScriptTemplates;
    public ?ShellScript $shellScriptTemplate = null;
    public ?int $shellScriptTemplateId = null;
    public array $parameters = [];
    public array $values = [];
    public ?string $scriptPreview = null;

    protected $rules = [
        'name' => 'required|string',
        'description' => 'nullable|string',
        'shellScriptTemplateId' => 'required|exists:shell_scripts,id',
    ];

    public function mount(): void
    {
        if ($this->shellScriptId) {
            $shellScript = ShellScript::find($this->shellScriptId);
            $this->shellScriptTemplates = ShellScript::where('type', ScriptType::TEMPLATE)->where('id', $shellScript->getTemplateId())->get();
            $this->name = $shellScript->getName();
            $this->description = $shellScript->getDescription();
            $this->shellScriptTemplate = $this->shellScriptTemplates->firstWhere('id', $shellScript->getTemplateId());
            $this->shellScriptTemplateId = $this->shellScriptTemplate->id;
            $this->parameters = $this->shellScriptTemplate?->getParameters() ?? [];
            $this->values = $shellScript->getValues();
        } else {
            $this->shellScriptTemplates = ShellScript::where('type', ScriptType::TEMPLATE)->get();
            $this->shellScriptTemplate = $this->shellScriptTemplates->first();
            $this->shellScriptTemplateId = $this->shellScriptTemplates->first()?->id;
            $this->parameters = $this->shellScriptTemplate?->getParameters() ?? [];
            $this->updateValues();
        }

        $this->updateScriptPreview();
    }

    public function render(): View
    {
        return view('livewire.modals.edit-shell-script');
    }

    public function updatingShellScriptTemplateId(int $templateId): void
    {
        $this->shellScriptTemplate = $this->shellScriptTemplates->firstWhere('id', $templateId);
        $this->parameters = $this->shellScriptTemplate?->getParameters() ?? [];
        $this->values = [];

        $this->updateValues();

        $this->updateScriptPreview();
    }

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
        $this->updateScriptPreview();
    }

    public function save(): void
    {
        try {
            $validatedData = $this->validate();
        } catch (ValidationException $exception) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Form contains invalid fields.')]);
            throw $exception;
        }

        ShellScript::updateOrCreate(
            [
                'id' => $this->shellScriptId,
            ], [
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'script' => $this->scriptPreview,
                'parameters' => $this->parameters,
                'values' => $this->values,
                'type' => ScriptType::SCRIPT,
                'template_id' => $validatedData['shellScriptTemplateId'],
            ]
        );
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Script was successfully saved.')]);
        $this->closeModalWithEvents(['shell-script-updated']);
    }

    private function updateValues(): void
    {
        foreach ($this->parameters as $name => $parameter) {
            if ($parameter['type'] === 'number') {
                $this->values[$name] = $parameter['value']['default'] ?? null;
            } elseif ($parameter['type'] === 'select') {
                $options = explode(';', $parameter['value']['options']);
                $this->values[$name] = $options[0];
            } elseif ($parameter['type'] === 'boolean') {
                $this->values[$name] = (bool) ($parameter['value']['default'] ?? 0);
            } elseif ($parameter['type'] === 'text') {
                $this->values[$name] = $parameter['value']['default'] ?? null;
            } elseif ($parameter['type'] === 'uuid') {
                $this->values[$name] = Str::uuid();
            } else {
                $this->values[$name] = null;
            }
        }
    }

    private function updateScriptPreview(): void
    {
        $this->scriptPreview = preg_replace(
            array_map(static fn($key) => '/\$\$'.$key.'\$\$/', array_keys($this->values)),
            array_map(static fn($value) => is_bool($value) && $value === true ? '1' : (is_bool($value) && $value === false ? '0' : $value), array_values($this->values)),
            $this->shellScriptTemplate?->script ?? ''
        );
    }
}
