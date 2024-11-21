<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Salaries extends Model
{
    protected $table = 'salaries';

    protected $fillable = [
        'user_id',
        'base_salary',
        'total_salary',
        'total_deductions',
        'net_salary',
        'pay_date',
    ];

    protected $hidden = [];
    public function users():BelongsTo
    {
        return $this->belongsTo(Users::class);
    }
    public function salary_adjustments(): HasMany
    {
        return $this->hasMany(SalaryAdjustments::class);
    }
}