<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;
    protected $table = 'testimoni';
    protected $fillable = ['pelamar_id', 'isi', 'is_approved'];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class, 'pelamar_id');
    }
    public function user()
    {
        // relasi langsung lewat pelamar
        return $this->hasOneThrough(User::class, Pelamar::class, 'id', 'id', 'pelamar_id', 'user_id');
    }
}
