<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // <editor-fold desc="Region: STATE DEFINITION">
    protected $guarded = ['id', 'created_at', 'updated_at',];
    protected $hidden = ['password',];
    protected $casts = [
        'password' => 'hashed',
    ];
    // </editor-fold desc="Region: STATE DEFINITION">

    // <editor-fold desc="Region: RELATIONS">
    // </editor-fold desc="Region: RELATIONS">

    // <editor-fold desc="Region: GETTERS">
    public function getRoleId(): int
    {
        return $this->role_id;
    }
    // </editor-fold desc="Region: GETTERS">

    // <editor-fold desc="Region: FUNCTIONS">
    public function hasRole(int $roleId): bool
    {
        return $this->getRoleId() === $roleId;
    }
    // </editor-fold desc="Region: FUNCTIONS">

}
