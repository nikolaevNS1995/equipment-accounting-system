<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Furniture extends Model
{
    /** @use HasFactory<\Database\Factories\FurnitureFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function furnitureType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(FurnitureType::class, 'furniture_type_id', 'id');
    }

    public function cabinet(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cabinet::class, 'cabinet_id', 'id');
    }
}
