<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function notifications()
    {
        return $this->belongsToMany(Notifications::class, 'notify_user', 'user_id', 'notify_id');
    }

    // public function salary_adjustments(): HasMany
    // {
    //     return $this->hasMany(Salaryadjustments::class);
    // }
    public function userShift(): HasOne
    {
        return $this->hasOne(UserShift::class);
    }

    public function leave_requests(): HasMany
    {
        return $this->hasMany(LeaveRequests::class);
    }

    public function offices(): BelongsToMany
    {
        return $this->belongsToMany(Offices::class, 'office_users', 'user_id', 'office_id');
    }
    
    public function salaries(): HasMany
    {
        return $this->hasMany(Salaries::class);
    }

    public function shift(): BelongsToMany
    {
        return $this->belongsToMany(Shifts::class, 'user_shift', 'user_id', 'shift_id');
    }

    public function ot_requests(): HasMany
    {
        return $this->hasMany(OT::class);
    }
}
