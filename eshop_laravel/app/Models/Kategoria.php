<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategoria extends Model
{
    protected $table = 'Kategoria';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['nazov', 'kategoria_id'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Kategoria::class, 'kategoria_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Kategoria::class, 'kategoria_id');
    }

    public function produkty(): HasMany
    {
        return $this->hasMany(Produkt::class, 'kategoria_id');
    }
}
