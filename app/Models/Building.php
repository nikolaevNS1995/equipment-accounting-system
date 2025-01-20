<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    /** @use HasFactory<\Database\Factories\BuildingFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function cabinet(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->HasMany(Cabinet::class, 'building_id', 'id');
    }
}
