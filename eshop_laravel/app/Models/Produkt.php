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
        'cena_bez_zlavy',
        'kategoria_id',
        'znacka_id',
        'skladom',
        'material',
        'farba',
        'sezona',
        'na_predajni',
        'na_objednavku',
        'image_path1',
        'image_path2',
        'obrazok_hlavny',
        'obrazok_druhy'
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
        return $this->product_gallery[0]['path'];
    }

    public function getSecondImagePathAttribute(): string
    {
        return $this->product_gallery[1]['path'];
    }

    public function getFinalPriceAttribute(): float
    {
        if (!is_null($this->cena_bez_zlavy) && $this->cena_bez_zlavy > 0 && $this->cena_bez_zlavy < $this->cena) {
            return (float) $this->cena_bez_zlavy;
        }

        return (float) $this->cena;
    }

    public function getOriginalPriceAttribute(): ?float
    {
        if (!is_null($this->cena_bez_zlavy) && $this->cena_bez_zlavy > 0 && $this->cena_bez_zlavy < $this->cena) {
            return (float) $this->cena;
        }

        return null;
    }

    public function getProductGalleryAttribute(): array
    {
        $primarySource = $this->image_path1 ?: $this->obrazok_hlavny;
        $secondarySource = $this->image_path2 ?: $this->obrazok_druhy;

        $primaryPath = !empty($primarySource)
            ? asset($primarySource)
            : $this->getFallbackImagePath();

        $hasSecondImage = !empty($secondarySource);
        $secondaryFallbackPath = str_ends_with($primaryPath, '/images/product1.png')
            ? asset('images/product1_2.png')
            : $primaryPath;
        $secondPath = $hasSecondImage
            ? asset($secondarySource)
            : $secondaryFallbackPath;

        return [
            [
                'path' => $primaryPath,
                'is_grayscale' => false,
            ],
            [
                'path' => $secondPath,
                // Temporary visual difference until admin uploads a real second image.
                'is_grayscale' => !$hasSecondImage && $secondPath === $primaryPath,
            ],
        ];
    }

    private function getFallbackImagePath(int $offset = 0): string
    {
        $name = mb_strtolower($this->nazov);
        
        if (str_contains($name, 'tričko') || str_contains($name, 't-shirt') || $this->kategoria_id == 1) return asset('images/product1.png');
        if (str_contains($name, 'mikina') || str_contains($name, 'hoodie') || $this->kategoria_id == 2) return asset('images/product2.png');
        if (str_contains($name, 'rifle') || str_contains($name, 'jeans') || $this->kategoria_id == 7) return asset('images/product3.png');
        if (str_contains($name, 'šaty') || $this->kategoria_id == 16) return asset('images/product4.png');
        if (str_contains($name, 'bunda') || str_contains($name, 'jacket') || $this->kategoria_id == 13) return asset('images/product5.png');
        if (str_contains($name, 'sukňa') || str_contains($name, 'skirt') || $this->kategoria_id == 3) return asset('images/product6.png');
        if (str_contains($name, 'košeľa') || str_contains($name, 'shirt') || $this->kategoria_id == 14) return asset('images/product7.png');
        if (str_contains($name, 'kraťasy') || str_contains($name, 'shorts') || $this->kategoria_id == 8) return asset('images/product9.png');
        if (str_contains($name, 'batoh') || str_contains($name, 'doplnky') || $this->kategoria_id == 15) return asset('images/product8.png');
        
        // Tenisky, topánky, vysoké podpätky a iné, pre ktoré nemáme perfektnú zhodu
        if (in_array($this->kategoria_id, [4, 5, 6]) || str_contains($name, 'tenisky') || str_contains($name, 'nike') || str_contains($name, 'adidas') || str_contains($name, 'puma')) return asset('images/product5.png'); 
        if (in_array($this->kategoria_id, [9, 10, 11, 12])) return asset('images/product1.png'); // Spodné pr., polo, siltovky, tielka -> fallback tričko

        // Default based on ID if no category or keyword match
        $productId = $this->produkt_id ?? 1;
        return asset('images/product' . (($productId - 1 + $offset) % 9 + 1) . '.png');
    }
}
