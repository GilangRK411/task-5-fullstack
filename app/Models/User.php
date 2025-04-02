<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; // Tambahkan ini

class User extends Authenticatable implements JWTSubject // Implementasikan JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Implementasikan metode dari JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Mengembalikan primary key (biasanya 'id')
    }

    public function getJWTCustomClaims()
    {
        return []; // Bisa ditambahkan jika ada custom claims yang ingin dimasukkan
    }
}
