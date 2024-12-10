<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'user_id',
        'check_in',
        'check_out',
        'check_in_status',
        'check_out_status',
    ];

    protected $hidden = [];

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if(!empty($filters['user_id'])){
            $query->where('user_id', $filters['user_id']);
        }

        if(!empty($filters['to'] && !empty($filters['from']))){
            $query->whereBetween('check_in', [$filters['from'], $filters['to']]);
        }

        if(!empty($filters['check_in_status']) && $filters['check_in_status'] !== 'all'){
            $query->where('check_in_status', $filters['check_in_status']);
        }

        if(!empty($filters['check_out_status']) && $filters['check_out_status'] !== 'all'){
            $query->where('check_out_status', $filters['check_out_status']);
        }

        return $query;

    }


    public function user():BelongsTo
    {
        return $this->belongsTo(Users::class);
    }
}