<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;

    protected $table = 'rekening';
    protected $primaryKey = 'rekening_id';
    protected $fillable = [
        'kegiatan_id',
        'sub_kegiatan_id',
        'kode_rekening',
        'nama_rekening',
    ];

    public function kegiatan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id', 'kegiatan_id');
    }

    public function sub_kegiatan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SubKegiatan::class, 'sub_kegiatan_id', 'sub_kegiatan_id');
    }

}
