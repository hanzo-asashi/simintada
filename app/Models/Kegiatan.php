<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';
    protected $primaryKey = 'kegiatan_id';
    protected $fillable = ['kode_kegiatan','nama_kegiatan'];

    public function sub_kegiatan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SubKegiatan::class, 'kegiatan_id', 'kegiatan_id');
    }

    public function paket_pengadaan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PaketPengadaan::class, 'kegiatan_id', 'kegiatan_id');
    }
}
