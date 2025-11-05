<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelamar extends Model
{
    use HasFactory;
    protected $table = 'pelamar';
    // daftar kolom yang boleh di-mass-assign
    protected $fillable = [
        'user_id',
        'nik',
        'tgl_lahir',
        'jenis_kelamin',
        'status_pernikahan',
        'disabilitas',
        'pendidikan_terahir',
        'jurusan',
        'nama_sekolah',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
        'alamat',
        'ktp',
        'cv',
        'ijazah',
        'ak1',
        'sertifikat',
        'syarat_lain',
    ];
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

    // Accessor untuk masing-masing file upload
    public function getKtpUrlAttribute()
    {
        return $this->getFileUrl('ktp');
    }

    public function getCvUrlAttribute()
    {
        return $this->getFileUrl('cv');
    }

    public function getIjazahUrlAttribute()
    {
        return $this->getFileUrl('ijazah');
    }

    public function getAk1UrlAttribute()
    {
        return $this->getFileUrl('ak1');
    }

    public function getSertifikatUrlAttribute()
    {
        return $this->getFileUrl('sertifikat');
    }

    public function getSyaratLainUrlAttribute()
    {
        return $this->getFileUrl('syarat_lain');
    }
}
