<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'setting_key',
        'setting_value',
        'description',
    ];

    protected $hidden = [];

}