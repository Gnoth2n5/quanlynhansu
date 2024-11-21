<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfficeUsers extends Model
{
    protected $table = 'office_users';

    protected $fillable = [
        'office_id',
        'user_id',
    ];

    protected $hidden = [];
    public function offices() :BelongsTo
    {
        return $this->belongsTo(Offices::class);
    }
}