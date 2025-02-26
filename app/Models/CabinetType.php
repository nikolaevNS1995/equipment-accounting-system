<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CabinetType extends Model
{
    /** @use HasFactory<\Database\Factories\CabinetTypeFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function cabinet(): HasMany
    {
        return $this->hasMany(Cabinet::class, 'cabinet_type_id', 'id');
    }
}
