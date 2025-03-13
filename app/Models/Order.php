<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id', 'order_type', 'status'];

    // Полиморфные связи многие-ко-многим с оборудованием, мебелью и др.
    public function equipments(): MorphToMany
    {
        return $this->morphedByMany(Equipment::class, 'orderable', 'order_items')->withTimestamps();
    }

    public function furnitures(): MorphToMany
    {
        return $this->morphedByMany(Furniture::class, 'orderable', 'order_items')->withTimestamps();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
