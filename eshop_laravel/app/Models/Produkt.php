<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produkt extends Model
{
    protected $table = 'Produkt';
    protected $primaryKey = 'produkt_id';
    public $timestamps = false;

    protected $fillable = [
        'nazov',
        'pouzivatel_id',
        'cena',
        'kategoria_id',
        'znacka_id',
        'skladom'
    ];

    public function kategoria(): BelongsTo
    {
        return $this->belongsTo(Kategoria::class, 'kategoria_id');
    }

    public function znacka(): BelongsTo
    {
        return $this->belongsTo(Znacka::class, 'znacka_id');
    }

    public function predajca(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pouzivatel_id');
    }

    /**
     * Get the image path based on product name/keywords.
     */
    public function getImagePathAttribute(): string
    {
        $name = mb_strtolower($this->nazov);
        
        if (str_contains($name, 'tričko')) return asset('images/product1.png');
        if (str_contains($name, 'mikina')) return asset('images/product2.png');
        if (str_contains($name, 'rifle') || str_contains($name, 'jeans')) return asset('images/product3.png');
        if (str_contains($name, 'šaty')) return asset('images/product4.png');
        if (str_contains($name, 'bunda') || str_contains($name, 'jacket')) return asset('images/product5.png');
        if (str_contains($name, 'sukňa')) return asset('images/product6.png');
        if (str_contains($name, 'košeľa')) return asset('images/product7.png');
        if (str_contains($name, 'kraťasy')) return asset('images/product9.png');
        if (str_contains($name, 'batoh')) return asset('images/product8.png');
        if (str_contains($name, 'tenisky') || str_contains($name, 'nike') || str_contains($name, 'adidas') || str_contains($name, 'puma')) return asset('images/product5.png'); // Fallback to something shoes/generic
        
        // Default based on ID if no keyword match
        return asset('images/product' . (($this->produkt_id - 1) % 9 + 1) . '.png');
    }
}
