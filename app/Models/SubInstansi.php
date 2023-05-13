<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubInstansi extends Model
{
    use HasFactory;

    protected $table = 'sub_instansi';
    protected $primaryKey = 'sub_instansi_id';
    protected $fillable = [
        'instansi_id',
        'kode_sub_instansi',
        'short_sub_name',
        'nama_sub_instansi',
    ];

    public function instansi(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Instansi::class, 'instansi_id', 'instansi_id');
    }
}
