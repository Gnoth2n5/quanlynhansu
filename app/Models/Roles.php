<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Roles extends Model
{
    protected $table = 'roles';
    

    protected $fillable = [
        'name',
    ];

    protected $hidden = [];
    public function users(): HasMany
    {
        return $this->hasMany(Users::class);
    }

}