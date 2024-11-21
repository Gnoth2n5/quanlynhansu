<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offices extends Model
{
    protected $table = 'offices';

    protected $fillable = [
        'name',
        'location',
    ];

    protected $hidden = [];
    public function users(): BelongsTo
    {
        return $this->belongsTo(Users::class);
    }
    public function notifications() :HasMany
    {
        return $this->hasMany(Notifications::class);
    }
    public function offices_users() :HasMany
    {
        return $this->hasMany(OfficeUsers::class);
    }
}