<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    protected $table = 'statistics';

    protected $fillable = [
        'user_id',
        'attendance_days',
        'late_days',
        'absent_days',
        'year',
        'month',
    ];

    protected $hidden = [];

}