<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Perusahaan extends Model
{
    use HasFactory;
    protected $table = 'perusahaan';
    protected $fillable = [
        'user_id',
        'bidang',
        'deskripsi',
        'alamat',
        'website',
        'nib',
    ];
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($perusahaan) {
            if ($perusahaan->user && $perusahaan->alamat) {
                $baseSlug = Str::slug($perusahaan->user->name . ' ' . $perusahaan->alamat);
                $slug = $baseSlug;
                $count = 1;

                // kalau update, abaikan slug milik dirinya sendiri
                while (
                static::where('slug', $slug)
                    ->where('id', '!=', $perusahaan->id)
                    ->exists()
                ) {
                    $count++;
                    $slug = "{$baseSlug}-{$count}";
                }

                $perusahaan->slug = $slug;
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected function getFileUrl($field)
    {
        return $this->$field
            ? url('storage/' . $this->$field)
            : null;
    }
    public function getNibUrlAttribute()
    {
        return $this->getFileUrl('nib');
    }
}
