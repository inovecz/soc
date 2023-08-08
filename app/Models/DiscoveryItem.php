<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscoveryItem extends Model
{

    // <editor-fold desc="Region: STATE DEFINITION">
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = [
        'status' => 'boolean',
        'last_up' => 'datetime',
        'last_down' => 'datetime',
        'services' => 'array',
    ];
    // </editor-fold desc="Region: STATE DEFINITION">

    // <editor-fold desc="Region: RELATIONS">
    public function batch(): BelongsTo
    {
        return $this->belongsTo(DiscoveryBatch::class);
    }
    // </editor-fold desc="Region: RELATIONS">

    // <editor-fold desc="Region: GETTERS">
    public function getHostId(): int
    {
        return $this->host_id;
    }

    public function getDiscoveryBatchId(): int
    {
        return $this->discovery_batch_id;
    }

    public function getRuleId(): int
    {
        return $this->rule_id;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getLastUp(): ?Carbon
    {
        return $this->last_up;
    }

    public function getLastDown(): ?Carbon
    {
        return $this->last_down;
    }

    public function getServices(): array
    {
        return $this->services;
    }
    // </editor-fold desc="Region: GETTERS">
}
