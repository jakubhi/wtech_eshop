<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolozkaKosika extends Model
{
    use HasFactory;

    protected $table = 'Polozka_kosika';
    public $timestamps = false;

    protected $fillable = [
        'pouzivatel_id',
        'produkt_id',
        'mnozstvo',
    ];

    public function pouzivatel()
    {
        return $this->belongsTo(User::class, 'pouzivatel_id', 'pouzivatel_id');
    }

    public function produkt()
    {
        return $this->belongsTo(Produkt::class, 'produkt_id', 'produkt_id');
    }
}
