<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul',
        'slug',
        'gambar',
        'ringkasan',
        'link',
        'urutan',
        'is_active',
        'published_at',
    ];
}
