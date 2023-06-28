<?php

namespace App\Http\Livewire\Modals;

use App\Enums\ScriptType;
use App\Models\ShellScript;
use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Validation\ValidationException;

class EditShellScriptTemplate extends ModalComponent
{
    public ?int $shellScriptId = null;
    public ?string $name = null;
    public ?string $description = null;
    public string $script = '';
    public array $parameters = [];

    protected $rules = [
        'name' => 'required|string',
        'description' => 'nullable|string',
        'script' => 'required|string',
        'parameters' => 'nullable|array',
        'parameters.*.type' => 'required|in:text,number,boolean,select,uuid',
        'parameters.*.value.options' => 'nullable|required_if:parameters.*.type,select|string|regex:/^(?!;)(?!.*;$).*[^;].*(?=.*;).*$/',
        'parameters.*.value.min' => 'nullable|numeric',
        'parameters.*.value.max' => 'nullable|numeric',
        'parameters.*.value.default' => 'nullable',
    ];

    protected $messages = [
        'parameters.*.value.options.regex' => 'Invalid format. Must be a semicolon separated list of values.',
        'parameters.*.value.options.required_if' => 'Options are required for select type parameters.',
    ];

    public function mount(): void
    {
        if ($this->shellScriptId) {
            $shellScript = ShellScript::find($this->shellScriptId);
            $this->name = $shellScript->name;
            $this->script = $shellScript->script;
            $this->parameters = $shellScript->parameters;
        }
    }

    public function render(): View
    {
        return view('livewire.modals.edit-shell-script-template');
    }

    public function save(): void
    {
        try {
            $validatedData = $this->validate();
        } catch (ValidationException $exception) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __('Form contains invalid fields.')]);
            throw $exception;
        }
        $shellScript = ShellScript::updateOrCreate(
            [
                'id' => $this->shellScriptId,
            ], [
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'script' => $validatedData['script'],
                'parameters' => $validatedData['parameters'],
                'type' => ScriptType::TEMPLATE,
            ]
        );
        if ($shellScript->wasRecentlyCreated) {
            $this->shellScriptId = $shellScript->id;
        }
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Script template was successfully saved.')]);
        $this->closeModalWithEvents(['shell-script-template-updated']);
    }

    public function updatingScript(string $script): void
    {
        $this->fetchParameters($script);
    }

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function fetchParameters(string $script = null): void
    {
        $pattern = '/\$\$(.*?)\$\$/';
        preg_match_all($pattern, $script ?? $this->script, $matches);
        foreach ($matches[1] as $match) {
            if (array_key_exists($match, $this->parameters)) {
                continue;
            }
            $this->parameters[$match] = [
                'type' => 'text',
                'value' => null,
            ];
        }

        $this->parameters = array_intersect_key($this->parameters, array_flip($matches[1]));
    }
}
