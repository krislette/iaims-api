<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $table = 'tbldocument_types';
    protected $primaryKey = 'doc_typ_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'doc_typ_name',
        'doc_typ_active',
    ];

    protected $casts = [
        'doc_typ_id' => 'integer',
        'doc_typ_active' => 'integer',
    ];
}
