<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequests extends Model
{
    protected $table = 'leave_requests';

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'reason',
        'approved_by',
        'status',
    ];

    protected $hidden = [];
    public function users(): BelongsTo
    {
        return $this->belongsTo(Users::class);
    }

}