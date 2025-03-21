<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentBrand extends Model
{
    /** @use HasFactory<\Database\Factories\EquipmentBrandFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function equipmentType(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id', 'id');
    }

    public function equipmentModel(): HasMany
    {
        return $this->hasMany(EquipmentModel::class, 'equipment_brand_id', 'id');
    }
}
