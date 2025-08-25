<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditType extends Model
{
    use HasFactory;

    protected $table = 'tblaudit_types';
    protected $primaryKey = 'aud_typ_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'aud_typ_name',
        'aud_typ_active',
    ];

    protected $casts = [
        'aud_typ_id' => 'integer',
        'aud_typ_active' => 'integer',
    ];
}
