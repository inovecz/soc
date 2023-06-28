<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\ScriptStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShellScriptRun extends Model
{

    // <editor-fold desc="Region: STATE DEFINITION">
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = [
        'status' => ScriptStatus::class,
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
    // </editor-fold desc="Region: STATE DEFINITION">

    // <editor-fold desc="Region: RELATIONS">
    public function shellScript(): BelongsTo
    {
        return $this->belongsTo(ShellScript::class);
    }
    // </editor-fold desc="Region: RELATIONS">

    // <editor-fold desc="Region: GETTERS">
    public function getScript(): string
    {
        return $this->script;
    }

    public function getStatus(): ScriptStatus
    {
        return $this->status;
    }

    public function getStartedAt(): ?Carbon
    {
        return $this->started_at;
    }

    public function getFinishedAt(): ?Carbon
    {
        return $this->finished_at;
    }

    public function getOutput(): ?string
    {
        return $this->outpu;
    }
    // </editor-fold desc="Region: GETTERS">

    // <editor-fold desc="Region: COMPUTED GETTERS">
    // </editor-fold desc="Region: COMPUTED GETTERS">

    // <editor-fold desc="Region: ARRAY GETTERS">
    // </editor-fold desc="Region: ARRAY GETTERS">

    // <editor-fold desc="Region: FUNCTIONS">
    // </editor-fold desc="Region: FUNCTIONS">

    // <editor-fold desc="Region: SCOPES">
    // </editor-fold desc="Region: SCOPES">

}
