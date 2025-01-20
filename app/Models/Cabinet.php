<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cabinet extends Model
{
    /** @use HasFactory<\Database\Factories\CabinetFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function cabinetType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CabinetType::class, 'cabinet_type_id', 'id');
    }

    public function building(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id', 'id');
    }

    public function equipment(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Equipment::class, 'cabinet_id', 'id');
    }

    public function furniture(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Furniture::class, 'cabinet_id', 'id');
    }
}
