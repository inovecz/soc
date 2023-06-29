<?php

namespace App\Models;

;

use App\Enums\ScriptStatus;
use App\Jobs\RunShellScript;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShellScript extends Model
{

    // <editor-fold desc="Region: STATE DEFINITION">
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = [
        'parameters' => 'array',
        'values' => 'array',
    ];
    // </editor-fold desc="Region: STATE DEFINITION">

    // <editor-fold desc="Region: RELATIONS">
    public function runs(): HasMany
    {
        return $this->hasMany(ShellScriptRun::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'template_id');
    }
    // </editor-fold desc="Region: RELATIONS">

    // <editor-fold desc="Region: GETTERS">
    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getTemplateId(): ?int
    {
        return $this->template_id;
    }

    public function getScript(): string
    {
        return $this->script;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getValues(): array
    {
        return $this->values;
    }
    // </editor-fold desc="Region: GETTERS">

    // <editor-fold desc="Region: COMPUTED GETTERS">
    // </editor-fold desc="Region: COMPUTED GETTERS">

    // <editor-fold desc="Region: ARRAY GETTERS">
    // </editor-fold desc="Region: ARRAY GETTERS">

    // <editor-fold desc="Region: FUNCTIONS">
    public function run(): void
    {
        $shellScriptRun = ShellScriptRun::create([
            'shell_script_id' => $this->getId(),
            'script' => $this->getScript(),
            'state' => ScriptStatus::PENDING,
            'values' => $this->values,
        ]);
        RunShellScript::dispatch($shellScriptRun);
    }
    // </editor-fold desc="Region: FUNCTIONS">

    // <editor-fold desc="Region: SCOPES">
    // </editor-fold desc="Region: SCOPES">

}
