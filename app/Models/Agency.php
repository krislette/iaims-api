<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $table = 'tblagencies';
    protected $primaryKey = 'agn_id';
    public $incrementing = true;
    protected $keyType = 'integer';

    protected $fillable = [
        'agn_name',
        'agn_acronym',
        'agn_grp_code',
        'agn_address',
        'agn_head_name',
        'agn_head_position',
        'agn_contact_details',
        'agn_active',
    ];

    // Relationship with agency groupings
    public function agencyGroup()
    {
        return $this->belongsTo(AgencyGrouping::class, 'agn_grp_code', 'agn_grp_code');
    }
}
