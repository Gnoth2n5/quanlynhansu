<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Users extends Model
{
    protected $table = 'users';
   

    protected $fillable = [
        'username',
        'password',
        'full_name',
        'email',
        'avatar',
        'birthday',
        'gender',
        'phone',
        'role_id',
        'status',
        'UID',
    ];

    protected $hidden = [
        'password',
    ];
    public function role(): BelongsTo
    {
        return $this->belongsTo(Roles::class);
    }
    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
    public function notifications():HasMany
    {
        return $this->hasMany(Notifications::class);
    }
    public function salary_adjustments(): HasMany
    {
        return $this->hasMany(Salaryadjustments::class);
    }
    public function userShift(): HasOne
    {
        return $this->hasOne(UserShift::class);
    }
    public function leave_requests(): HasMany
    {
        return $this->hasMany(LeaveRequests::class);
    }
    public function offices(): BelongsTo
    {
        return $this->BelongsTo(Offices::class);
    }
    public function salaries():HasMany
    {
        return $this->hasMany(Salaries::class);
    }

}