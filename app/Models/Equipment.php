<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    /** @use HasFactory<\Database\Factories\EquipmentFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function equipmentModel(): BelongsTo
    {
        return $this->belongsTo(EquipmentModel::class, 'equipment_model_id', 'id');
    }

    public function cabinet(): BelongsTo
    {
        return $this->belongsTo(Cabinet::class, 'cabinet_id', 'id');
    }
}
