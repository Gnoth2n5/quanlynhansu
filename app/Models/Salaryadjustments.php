<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salaryadjustments extends Model
{
    protected $table = 'salary_adjustments';

    protected $fillable = [
        'salary_id',
        'user_id',
        'type',
        'amount',
        'description',
        'adjustment_date',
    ];

    protected $hidden = [];
    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class);
    }
    public function salaries(): BelongsTo
    {
        return $this->belongsTo(Salaries::class);
    }
}