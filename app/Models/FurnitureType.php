<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FurnitureType extends Model
{
    /** @use HasFactory<\Database\Factories\FurnitureTypeFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function furniture(): HasMany
    {
        return $this->hasMany(Furniture::class, 'furniture_type_id', 'id');
    }
}
