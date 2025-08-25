<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class InternalControlComponent extends Model
{
    use HasFactory;

    protected $table = 'tblinternal_control_components';

    // Composite primary key
    protected $primaryKey = ['com_ic_id', 'com_seqnum'];

    public $incrementing = false;

    protected $keyType = 'array';

    protected $fillable = [
        'com_ic_id',
        'com_seqnum',
        'com_desc',
    ];

    protected $casts = [
        'com_ic_id' => 'integer',
        'com_seqnum' => 'integer',
    ];

    /**
     * Get the internal control that the component belongs to.
     */
    public function internalControl(): BelongsTo
    {
        return $this->belongsTo(InternalControl::class, 'com_ic_id', 'ic_id');
    }
}
