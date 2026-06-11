<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    use HasFactory;
    protected $fillable = [
        'acara_id',
        'token',
        'digunakan',
        'expired_at',
    ];

    protected $casts = [
        'digunakan' => 'boolean',
        'expired_at' => 'datetime',
    ];
    public function acara()
    {
        return $this->belongsTo(Acara::class);
    }
}
