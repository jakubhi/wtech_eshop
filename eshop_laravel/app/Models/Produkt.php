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
        'skladom',
        'na_predajni',
        'na_objednavku'
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
        
        if (str_contains($name, 'tričko') || str_contains($name, 't-shirt') || $this->kategoria_id == 1) return asset('images/product1.png');
        if (str_contains($name, 'mikina') || str_contains($name, 'hoodie') || $this->kategoria_id == 2) return asset('images/product2.png');
        if (str_contains($name, 'rifle') || str_contains($name, 'jeans') || $this->kategoria_id == 7) return asset('images/product3.png');
        if (str_contains($name, 'šaty') || $this->kategoria_id == 16) return asset('images/product4.png');
        if (str_contains($name, 'bunda') || str_contains($name, 'jacket') || $this->kategoria_id == 13) return asset('images/product5.png'); // Bunda fallback
        if (str_contains($name, 'sukňa') || str_contains($name, 'skirt') || $this->kategoria_id == 3) return asset('images/product6.png');
        if (str_contains($name, 'košeľa') || str_contains($name, 'shirt') || $this->kategoria_id == 14) return asset('images/product7.png');
        if (str_contains($name, 'kraťasy') || str_contains($name, 'shorts') || $this->kategoria_id == 8) return asset('images/product9.png');
        if (str_contains($name, 'batoh') || str_contains($name, 'doplnky') || $this->kategoria_id == 15) return asset('images/product8.png');
        
        // Tenisky, topánky, vysoké podpätky a iné, pre ktoré nemáme perfektnú zhodu
        if (in_array($this->kategoria_id, [4, 5, 6]) || str_contains($name, 'tenisky') || str_contains($name, 'nike') || str_contains($name, 'adidas') || str_contains($name, 'puma')) return asset('images/product5.png'); 
        if (in_array($this->kategoria_id, [9, 10, 11, 12])) return asset('images/product1.png'); // Spodné pr., polo, siltovky, tielka -> fallback tričko

        // Default based on ID if no category or keyword match
        return asset('images/product' . (($this->produkt_id - 1) % 9 + 1) . '.png');
    }
}
