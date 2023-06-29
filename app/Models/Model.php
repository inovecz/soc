<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    public function getId(): int|string
    {
        $primaryKey = $this->getPrimaryKeyName();
        return $this->$primaryKey;
    }

    public function getPrimaryKeyName(): string
    {
        return $this->primaryKey;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }
}
