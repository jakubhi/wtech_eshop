<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Znacka extends Model
{
    protected $table = 'Znacka';
    protected $primaryKey = 'znacka_id';
    public $timestamps = false;

    protected $fillable = ['nazov'];

    public function produkty(): HasMany
    {
        return $this->hasMany(Produkt::class, 'znacka_id');
    }
}
