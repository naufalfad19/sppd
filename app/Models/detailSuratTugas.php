<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detailSuratTugas extends Model
{
    protected $table = 'detail_surat_tugas';

    protected $fillable = [
        'id_surat_tugas', 'id_user', 'id_kwitansi'
    ];

    public function suratTugas()
    {
        return $this->hasOne(suratTugas::class, 'id', 'id_surat_tugas');
    }

    public function pegawai()
    {
        return $this->hasOne(pegawai::class, 'id', 'id_user');
    }

    public function kwitansi()
    {
        return $this->hasOne(kwitansi::class, 'id', 'id_kwitansi');
    }
}
