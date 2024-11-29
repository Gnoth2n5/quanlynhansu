<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offices extends Model
{
    protected $table = 'offices';

    protected $fillable = [
        'name',
        'location',
    ];

    protected $hidden = [];
    
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Users::class, 'office_users', 'office_id', 'user_id');
    }
    
    public function notifications() :HasMany
    {
        return $this->hasMany(Notifications::class);
    }
    // public function offices_users() :HasMany
    // {
    //     return $this->hasMany(OfficeUsers::class);
    // }

    public function manager()
    {
        return $this->users()->whereHas('role', function ($q){
            $q->where('name', 'manager');
        });
    }
}