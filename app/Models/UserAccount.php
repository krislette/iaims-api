<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class UserAccount extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $table = 'tbluser_accounts';
    protected $primaryKey = 'usr_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'usr_name',
        'usr_aur_id',
        'usr_level',
        'usr_email',
        'usr_password',
        'usr_active',
        'usr_logged',
    ];

    protected $casts = [
        'usr_id' => 'integer',
        'usr_aur_id' => 'integer',
        'usr_level' => 'integer',
        'usr_active' => 'integer',
        'usr_logged' => 'integer',
    ];

    protected $hidden = [
        'usr_password',
    ];

    // Tell Laravel which column is the "password"
    public function getAuthPassword()
    {
        return $this->usr_password;
    }

    // Tell Laravel which column is the "email" for login
    public function getAuthIdentifierName()
    {
        return 'usr_email';
    }

    public function auditor()
    {
        return $this->belongsTo(Auditor::class, 'usr_aur_id', 'aur_id');
    }

    public function getUserLevelNameAttribute(): string
    {
        $levels = [
            1 => 'System Administrator',
            2 => 'Internal Auditor',
            3 => 'External Auditor',
            4 => 'Audit Manager',
            5 => 'Audit Supervisor',
            6 => 'Senior Auditor',
            7 => 'Junior Auditor',
            8 => 'Read Only User',
        ];

        return $levels[$this->usr_level] ?? 'Unknown Level';
    }
}
