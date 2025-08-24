<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class AuditArea extends Model
{
    use HasFactory;

    protected $table = 'tblaudit_areas';
    protected $primaryKey = 'ara_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'ara_id',
        'ara_name',
        'ara_ara_id',
        'ara_active',
    ];

    protected $casts = [
        'ara_id' => 'integer',
        'ara_ara_id' => 'integer',
        'ara_active' => 'integer',
    ];

    /**
     * Get the parent audit area.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(AuditArea::class, 'ara_ara_id', 'ara_id');
    }

    /**
     * Get the child audit areas.
     */
    public function children(): HasMany
    {
        return $this->hasMany(AuditArea::class, 'ara_ara_id', 'ara_id');
    }

    /**
     * Get all descendants (children, grandchildren, etc.)
     */
    public function descendants(): HasMany
    {
        return $this->children()->with('descendants');
    }
}
