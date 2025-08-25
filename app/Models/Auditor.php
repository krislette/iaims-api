<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Auditor extends Model
{
    use HasFactory;

    protected $table = 'tblauditors';
    protected $primaryKey = 'aur_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'aur_name_last',
        'aur_name_first',
        'aur_name_middle',
        'aur_name_prefix',
        'aur_name_suffix',
        'aur_external',
        'aur_position',
        'aur_salary_grade',
        'aur_agn_id',
        'aur_expertise',
        'aur_email',
        'aur_birthdate',
        'aur_contact_no',
        'aur_tin',
        'aur_status',
        'aur_photo',
        'aur_active',
    ];

    protected $casts = [
        'aur_id' => 'integer',
        'aur_external' => 'integer',
        'aur_salary_grade' => 'integer',
        'aur_agn_id' => 'integer',
        'aur_birthdate' => 'date',
        'aur_status' => 'integer',
        'aur_active' => 'integer',
    ];

    /**
     * Get the agency that the auditor belongs to.
     */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'aur_agn_id', 'agn_id');
    }

    /**
     * Get the user account associated with this auditor
     */
    public function userAccount(): HasOne
    {
        return $this->hasOne(UserAccount::class, 'usr_aur_id', 'aur_id');
    }

    /**
     * Scope to get only active auditors
     */
    public function scopeActive($query)
    {
        return $query->where('aur_active', 1);
    }

    /**
     * Scope to get only internal auditors
     */
    public function scopeInternal($query)
    {
        return $query->where('aur_external', 0);
    }

    /**
     * Scope to get only external auditors
     */
    public function scopeExternal($query)
    {
        return $query->where('aur_external', 1);
    }

    /**
     * Get full name attribute
     */
    public function getFullNameAttribute()
    {
        $parts = array_filter([
            $this->aur_name_prefix,
            $this->aur_name_first,
            $this->aur_name_middle,
            $this->aur_name_last,
            $this->aur_name_suffix
        ]);

        return implode(' ', $parts);
    }

    /**
     * Get formatted name attribute (Last, First Middle)
     */
    public function getFormattedNameAttribute()
    {
        $firstName = trim($this->aur_name_first . ' ' . $this->aur_name_middle);
        return $this->aur_name_last . ', ' . $firstName;
    }
}
