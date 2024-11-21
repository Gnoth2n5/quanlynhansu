<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserShift extends Model
{
    protected $table = 'user_shift';

    protected $fillable = [
        'user_id',
        'shift_id',
    ];

    protected $hidden = [];
    public function user()
    {
        return $this->belongsTo(Users::class);
    }
    public function shift():BelongsTo
    {
        return $this->belongsTo(Shifts::class);
    }
}