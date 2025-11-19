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
        'acara_id',
    ];
    protected $dates = ['batas_lamaran']; // Menambahkan kolom batas_lamaran ke dalam array dates


    protected static function boot()
    {
        parent::boot();

        // CREATE
        static::creating(function ($lowongan) {
            $userName = ($lowongan->user && isset($lowongan->user->name))
                ? $lowongan->user->name
                : \App\Models\User::where('id', $lowongan->user_id)->value('name');

            $slugBase = Str::slug($lowongan->judul . '-' . $userName);

            // prefix tergantung ada acara atau tidak
            if ($lowongan->acara_id) {
                $acaraSlug = $lowongan->acara ? $lowongan->acara->slug
                    : \App\Models\Acara::where('id', $lowongan->acara_id)->value('slug');
                $prefix = 'job-fair/' . $acaraSlug;
            } else {
                $prefix = 'lowongan-kerja';
            }

            $slug = "{$prefix}/{$slugBase}";

            // pastikan unik
            $count = 1;
            while (self::where('slug', $slug)->exists()) {
                $slug = "{$prefix}/{$slugBase}-{$count}";
                $count++;
            }

            $lowongan->slug = $slug;
        });

        // UPDATE
        static::updating(function ($lowongan) {
            $userIdLama = $lowongan->getOriginal('user_id');
            $userName = \App\Models\User::where('id', $userIdLama)->value('name');

            $slugBase = Str::slug($lowongan->judul . '-' . $userName);

            if ($lowongan->acara_id) {
                $acaraSlug = $lowongan->acara ? $lowongan->acara->slug
                    : \App\Models\Acara::where('id', $lowongan->acara_id)->value('slug');
                $prefix = 'job-fair/' . $acaraSlug;
            } else {
                $prefix = 'lowongan-kerja';
            }

            $slug = "{$prefix}/{$slugBase}";

            $count = 1;
            while (self::where('slug', $slug)->where('id', '!=', $lowongan->id)->exists()) {
                $slug = "{$prefix}/{$slugBase}-{$count}";
                $count++;
            }

            $lowongan->slug = $slug;
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
    public function pelamar()
    {
        return $this->hasMany(Pelamar::class);
    }
    public function acara()
    {
        return $this->belongsTo(Acara::class, 'acara_id');
    }


}
