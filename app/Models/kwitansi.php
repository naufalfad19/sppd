<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kwitansi extends Model
{
    protected $table = 'kwitansi';

    protected $fillable = [
        'transport', 'uang_harian'
    ];

    public function detailSuratTugas()
    {
        return $this->hasMany(detailSuratTugas::class, 'id_kwitansi', 'id');
    }
}
