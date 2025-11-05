<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lowongan extends Model
{
    use HasFactory;
    protected $table = 'lowongan';
    protected $fillable = [
        'user_id',
        'judul',
        'slug',
        'lokasi',
        'bidang_pekerjaan',
        'jenis_pekerjaan',
        'tipe_pekerjaan',
        'jenis_kelamin',
        'rentang_gaji',
        'batas_lamaran',
        'status',
        'jumlah_lowongan',
        'deskripsi_pekerjaan',
        'persyaratan_khusus',
        'pendidikan_minimal',
        'status_pernikahan',
        'pengalaman_minimal',
        'kondisi_fisik',
        'keterampilan',
    ];
    protected $dates = ['batas_lamaran']; // Menambahkan kolom batas_lamaran ke dalam array dates

    protected static function boot()
    {
        parent::boot();

        // Saat membuat data baru
        static::creating(function ($lowongan) {
            if ($lowongan->user) {
                $baseSlug = Str::slug($lowongan->judul . '-' . $lowongan->user->name);
            } else {
                // fallback jika relasi belum terload
                $userName = \App\Models\User::where('id', $lowongan->user_id)->value('name');
                $baseSlug = Str::slug($lowongan->judul . '-' . $userName);
            }

            $slug = $baseSlug;
            $count = 1;

            // Pastikan slug unik
            while (self::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }

            $lowongan->slug = $slug;
        });

        // Saat mengupdate data
        static::updating(function ($lowongan) {
            if ($lowongan->isDirty('judul') || $lowongan->isDirty('user_id')) {

                if ($lowongan->user) {
                    $baseSlug = Str::slug($lowongan->judul . '-' . $lowongan->user->name);
                } else {
                    $userName = \App\Models\User::where('id', $lowongan->user_id)->value('name');
                    $baseSlug = Str::slug($lowongan->judul . '-' . $userName);
                }

                $slug = $baseSlug;
                $count = 1;

                // Pastikan tidak tabrakan dengan slug lain
                while (self::where('slug', $slug)
                    ->where('id', '!=', $lowongan->id)
                    ->exists()) {
                    $slug = "{$baseSlug}-{$count}";
                    $count++;
                }

                $lowongan->slug = $slug;
            }
        });
    }


    // Relasi ke user (perusahaan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function perusahaan()
    {
        return $this->hasOne(Perusahaan::class, 'user_id', 'user_id');
    }


}
