<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shifts extends Model
{
    protected $table = 'shifts';

    protected $fillable = [
        'shift_name',
        'start_time',
        'end_time',
        'is_overtime',

    ];

    protected $hidden = [];
    
    public function userShift(): HasMany
    {
        return $this->hasMany(UserShift::class);
    }

}