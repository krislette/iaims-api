<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class AuditArea extends Model
{
    protected $table = 'tblaudit_areas';

    protected $primaryKey = 'ara_id';

    protected $fillable = [
        'ara_name',
        'ara_ara_id',
        'ara_active',
    ];

    protected $casts = [
        'ara_ara_id' => 'integer',
        'ara_active' => 'integer',
    ];

    public function parentAuditArea(): BelongsTo
    {
        return $this->belongsTo(AuditArea::class, 'ara_ara_id', 'ara_id');
    }

    public function childAuditAreas(): HasMany
    {
        return $this->hasMany(AuditArea::class, 'ara_ara_id', 'ara_id');
    }

    public function getAllDescendants()
    {
        $descendants = collect();

        foreach ($this->childAuditAreas as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->getAllDescendants());
        }

        return $descendants;
    }

    // Scope for active audit areas
    public function scopeActive($query)
    {
        return $query->where('ara_active', 1);
    }

    public function scopeRootLevel($query)
    {
        return $query->whereNull('ara_ara_id');
    }
}
