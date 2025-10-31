<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;
    protected $table = 'lamaran';
    protected $fillable = [
        'user_id',
        'lowongan_id',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 🔗 Relasi ke model Lowongan
     */
    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }
    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class, 'user_id', 'user_id');
    }
}
