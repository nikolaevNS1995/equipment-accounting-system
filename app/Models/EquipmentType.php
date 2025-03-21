<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentType extends Model
{
    /** @use HasFactory<\Database\Factories\EquipmentTypeFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function equipmentBrand(): HasMany
    {
        return $this->hasMany(EquipmentBrand::class, 'equipment_brand_id', 'id');
    }
}
