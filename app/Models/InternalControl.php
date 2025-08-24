<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class InternalControl extends Model
{
    use HasFactory;

    protected $table = 'tblinternal_controls';
    protected $primaryKey = 'ic_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'ic_id',
        'ic_ara_id',
        'ic_category',
        'ic_desc',
        'ic_active',
    ];

    protected $casts = [
        'ic_id' => 'integer',
        'ic_ara_id' => 'integer',
        'ic_active' => 'integer',
    ];

    /**
     * Get the audit area that the internal control belongs to.
     */
    public function auditArea(): BelongsTo
    {
        return $this->belongsTo(AuditArea::class, 'ic_ara_id', 'ara_id');
    }

    /**
     * Get the components for the internal control.
     */
    public function components(): HasMany
    {
        return $this
            ->hasMany(InternalControlComponent::class, 'com_ic_id', 'ic_id')
            ->orderBy('com_seqnum');
    }
}
