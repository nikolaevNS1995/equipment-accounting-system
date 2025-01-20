<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentModel extends Model
{
    /** @use HasFactory<\Database\Factories\EquipmentModelFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function equipmentBrend(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EquipmentBrend::class, 'equipment_brend_id', 'id');
    }

    public function equipment(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Equipment::class, 'equipment_model_id', 'id');
    }
}
