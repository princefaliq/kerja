<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','no_hp','status'
    ];
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function pelamar()
    {
        return $this->hasOne(Pelamar::class);
    }
    public function perusahaan()
    {
        return $this->hasOne(Perusahaan::class, 'user_id');
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $appends = ['avatar_url'];
    protected $dates = ['last_login']; // Menambahkan kolom batas_lamaran ke dalam array dates
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getAvatarUrlAttribute()
    {
        return $this->avatar
            ? url('storage/' . $this->avatar)
            : 'https://placehold.co/125x125';
    }
}
