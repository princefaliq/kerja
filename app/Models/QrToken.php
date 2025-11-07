<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_acara',
        'token',
        'digunakan',
        'expired_at',
    ];

    protected $casts = [
        'digunakan' => 'boolean',
        'expired_at' => 'datetime',
    ];
}
