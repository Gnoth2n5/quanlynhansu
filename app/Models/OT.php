<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OT extends Model
{
    protected $table = 'ot_request';

    protected $fillable = [
        'user_id',
        'shift_id',
        'requested_hours',
        'approved_hours',
        'status',
    ];

    protected $hidden = [];



    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shifts::class, 'shift_id', 'id');
    }
}
