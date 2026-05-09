<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produkt extends Model
{
    private const CATEGORY_FALLBACKS = [
        1 => 'images/product1.png',
        2 => 'images/product2.png',
        3 => 'images/product6.png',
        7 => 'images/product3.png',
        8 => 'images/product9.png',
        13 => 'images/product5.png',
        14 => 'images/product7.png',
        15 => 'images/product8.png',
        16 => 'images/product4.png',
    ];

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
        'image_path2'
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

    public function getImagePathAttribute(): string
    {
        return $this->getProductGalleryAttribute()[0]['path'];
    }

    public function getSecondImagePathAttribute(): string
    {
        return $this->getProductGalleryAttribute()[1]['path'];
    }

    public function getFinalPriceAttribute(): float
    {
        return $this->hasDiscount()
            ? (float) $this->cena_bez_zlavy
            : (float) $this->cena;
    }

    public function getOriginalPriceAttribute(): ?float
    {
        return $this->hasDiscount() ? (float) $this->cena : null;
    }

    public function getProductGalleryAttribute(): array
    {
        $primaryPath = $this->resolvePrimaryImagePath();
        $secondPath = $this->resolveSecondaryImagePath();
        $isEmptySecondImage = empty($this->image_path2);

        return [
            [
                'path' => $primaryPath,
                'is_grayscale' => false,
            ],
            [
                'path' => $secondPath,
                'is_grayscale' => $isEmptySecondImage,
            ],
        ];
    }

    private function hasDiscount(): bool
    {
        return !is_null($this->cena_bez_zlavy)
            && $this->cena_bez_zlavy > 0
            && $this->cena_bez_zlavy < $this->cena;
    }

    private function resolvePrimaryImagePath(): string
    {
        if (!empty($this->image_path1)) {
            return asset($this->image_path1);
        }

        return $this->getFallbackImagePath();
    }

    private function resolveSecondaryImagePath(): string
    {
        if (!empty($this->image_path2)) {
            return asset($this->image_path2);
        }

        return asset('images/empty.png');
    }

    private function getFallbackImagePath(): string
    {
        $categoryId = (int) $this->kategoria_id;

        if (isset(self::CATEGORY_FALLBACKS[$categoryId])) {
            return asset(self::CATEGORY_FALLBACKS[$categoryId]);
        }

        if (in_array($categoryId, [4, 5, 6], true)) {
            return asset('images/product5.png');
        }

        if (in_array($categoryId, [9, 10, 11, 12], true)) {
            return asset('images/product1.png');
        }

        return asset('images/empty.png');
    }
}
