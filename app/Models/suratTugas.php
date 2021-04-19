<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class suratTugas extends Model
{
    protected $table = 'surat_tugas';

    protected $fillable = [
        'id_sppd', 'no_surat', 'tujuan', 'jenis_perintah','kop_surat','ttd'
    ];

    public function sppd()
    {
        return $this->hasOne(sppd::class, 'id', 'id_sppd');
    }

    public function pengaju()
    {
        return $this->hasOne(user::class, 'id', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(detailSuratTugas::class, 'id_surat_tugas', 'id');
    }
}
