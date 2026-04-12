<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'Pouzivatel';
    protected $primaryKey = 'pouzivatel_id';
    
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'login',
        'email',
        'rola',
        'heslo', // Correcting to 'heslo' to match DB
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'heslo',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'heslo' => 'hashed',
        ];
    }

    public function getAuthPassword()
    {
        return $this->heslo;
    }

    public function cartItems()
    {
        return $this->hasMany(PolozkaKosika::class, 'pouzivatel_id', 'pouzivatel_id');
    }

    public function username()
    {
        return 'login';
    }
}
