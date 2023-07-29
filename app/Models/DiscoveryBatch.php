<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscoveryBatch extends Model
{

    // <editor-fold desc="Region: STATE DEFINITION">
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
    // </editor-fold desc="Region: STATE DEFINITION">

    // <editor-fold desc="Region: RELATIONS">
    public function items(): HasMany
    {
        return $this->hasMany(DiscoveryItem::class);
    }
    // </editor-fold desc="Region: RELATIONS">

    // <editor-fold desc="Region: GETTERS">
    public function getStartedAt(): Carbon
    {
        return $this->started_at;
    }

    public function getFinishedAt(): ?Carbon
    {
        return $this->finished_at;
    }
    // </editor-fold desc="Region: GETTERS">
}
