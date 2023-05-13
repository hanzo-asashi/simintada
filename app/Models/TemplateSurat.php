<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSurat extends Model
{
    use HasFactory;

    protected $table = 'template_surat';
    protected $primaryKey = 'id_template_surat';
    protected $fillable = [
        'instansi_id',
        'program_id',
        'kegiatan_id',
        'rekening_id',
        'nama_surat',
        'nomor_surat',
        'lampiran',
        'perihal',
        'ditujukan_ke',
        'tujuan',
        'nama_penandatangan',
        'nip_penandatangan',
        'tanggal_surat'
    ];
}
