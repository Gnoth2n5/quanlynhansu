<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifications extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'office_id',
    ];

    protected $hidden = [];
    public function User(): BelongsTo
    {
        return $this->belongsTo(Users::class);
    }
    public function Office() : BelongsTo
    {
        return $this->belongsTo(Offices::class);
    }
}