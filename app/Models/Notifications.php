<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifications extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'title',
        'message',
    ];

    protected $hidden = [];

    public function users()
    {
        return $this->belongsToMany(Users::class, 'notify_user', 'notify_id', 'user_id');
    }

    // Quan hệ với bảng office_notify
    public function offices()
    {
        return $this->belongsToMany(Offices::class, 'notify_office', 'notify_id', 'office_id');
    }
}
