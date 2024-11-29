<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeNotify extends Model
{
    protected $table = 'notify_office';

    protected $fillable = [
        'office_id',
        'notify_id',
    ];

    protected $hidden = [];

}