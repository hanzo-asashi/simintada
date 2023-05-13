<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use JeffGreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, TwoFactorAuthenticatable;

     protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'username',
        'email',
        'nomor_surat_tugas',
        'skpd',
        'password',
        'is_admin'
    ];

    protected $hidden = [
        'password',
        'is_admin',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'skpd' => 'array',
        'is_admin' => 'boolean',
    ];

//    protected $with = ['instansi'];

    public function getSkpdAttribute($value)
    {
        return json_decode($value);
    }

    public function setSkpdAttribute($value)
    {
        $this->attributes['skpd'] = json_encode($value);
    }

    public function getSkpdNameAttribute(): string
    {
        $skpd = $this->skpd;
        $instansi = Instansi::whereIn('instansi_id', $skpd)->get();
        $instansi = $instansi->pluck('nama_instansi')->toArray();
        return implode(', ', $instansi);
    }

    public function getSkpdNameShortAttribute(): string
    {
        $skpd = $this->skpd;
        $instansi = Instansi::whereIn('instansi_id', $skpd)->get();
        $instansi = $instansi->pluck('nama_instansi')->toArray();
        return implode(', ', array_slice($instansi, 0, 2));
    }

    public function instansi(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
//        reeturn $this->belongsTo(Instansi::class, 'skpd_id','instansi_id');
        return $this->belongsToMany(Instansi::class, 'instansi', 'skpd_id', 'instansi_id');
    }

    public function userskpd(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserSkpd::class, 'user_id', 'id');
    }

    public function canAccessFilament(): bool
    {
        return str_ends_with($this->email, '@simintada.local') && $this->is_admin === true;
    }

//    public function getFilamentAvatarUrl(): ?string
//    {
//        return $this->avatar_url;
//    }
}
