<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pegawai extends Model
{
    protected $table = 'pegawai';

    protected $fillable = [
        'name', 'nip'
    ];

    public function detailSuratTugas()
    {
        return $this->hasMany(detailSuratTugas::class, 'id_user', 'id');
    }

    public function pangkat()
    {
        return $this->hasOne(pangkatGol::class, 'id', 'id_pangkat');
    }
}
