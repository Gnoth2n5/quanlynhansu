<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'user_id',
        'check_in',
        'check_out',
        'check_in_status',
        'check_out_status',
    ];

    protected $hidden = [];
    public function user():BelongsTo
    {
        return $this->belongsTo(Users::class);
    }
}