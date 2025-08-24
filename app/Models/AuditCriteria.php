<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditCriteria extends Model
{
    use HasFactory;

    protected $table = 'tblaudit_criteria';
    protected $primaryKey = 'cra_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'cra_id',
        'cra_name',
        'cra_areas',
        'cra_references',
        'cra_active',
    ];

    protected $casts = [
        'cra_id' => 'integer',
        'cra_active' => 'integer',
    ];
}
