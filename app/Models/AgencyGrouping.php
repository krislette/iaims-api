<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyGrouping extends Model
{
    use HasFactory;

    protected $table = 'tblagency_groupings';
    protected $primaryKey = 'agn_grp_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'agn_grp_code',
        'agn_grp_name',
    ];

    // Relationship with agencies
    public function agencies()
    {
        return $this->hasMany(Agency::class, 'agn_grp_code', 'agn_grp_code');
    }
}
