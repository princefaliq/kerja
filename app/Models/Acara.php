<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Acara extends Model
{
    use HasFactory;
    protected $table = 'acara';
    protected $fillable = [
        'nama_acara',
        'tanggal_mulai',
        'waktu_mulai',
        'tanggal_selesai',
        'waktu_selesai',
        'deskripsi',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($acara) {
            $baseSlug = Str::slug($acara->nama_acara);
            $slug = $baseSlug;
            $count = 1;

            while (self::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }

            $acara->slug = $slug;
        });

        static::updating(function ($acara) {
            if ($acara->isDirty('nama_acara')) {
                $baseSlug = Str::slug($acara->nama_acara);
                $slug = $baseSlug;
                $count = 1;

                while (self::where('slug', $slug)->where('id', '!=', $acara->id)->exists()) {
                    $slug = "{$baseSlug}-{$count}";
                    $count++;
                }

                $acara->slug = $slug;
            }
        });
    }

    public function lowongan()
    {
        return $this->hasMany(Lowongan::class, 'acara_id');
    }
}
