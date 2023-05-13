<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketPengadaan extends Model
{
    use HasFactory;

    protected $table = 'paket_pengadaan';
    protected $primaryKey = 'paket_pengadaan_id';
    protected $fillable = [
        'nama_paket_pengadaan',
        'kode_rup',
        'pagu_hps',
    ];
}
