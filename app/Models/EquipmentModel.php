<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentModel extends Model
{
    /** @use HasFactory<\Database\Factories\EquipmentModelFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function equipmentBrand(): BelongsTo
    {
        return $this->belongsTo(EquipmentBrand::class, 'equipment_brand_id', 'id');
    }

    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class, 'equipment_model_id', 'id');
    }
}
