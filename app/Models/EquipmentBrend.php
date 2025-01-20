<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentBrend extends Model
{
    /** @use HasFactory<\Database\Factories\EquipmentBrendFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function equipmentType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id', 'id');
    }

    public function equipmentModel(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EquipmentModel::class, 'equipment_brend_id', 'id');
    }
}
