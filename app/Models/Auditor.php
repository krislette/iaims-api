<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditor extends Model
{
    protected $table = 'tblauditors';
    protected $primaryKey = 'aur_id';
    public $incrementing = false;
    
    protected $fillable = [
        'aur_id',
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

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'aur_agn_id', 'agn_id');
    }
}