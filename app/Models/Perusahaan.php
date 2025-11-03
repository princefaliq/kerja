<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function user()
    {
        return $this->hasOne(User::class);
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
