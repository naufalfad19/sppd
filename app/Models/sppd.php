<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sppd extends Model
{
    protected $table = 'sppd';

    protected $fillable = [
        'tanggal_pergi', 'tanggal_pulang', 'uraian_kegiatan', 'tujuan'
    ];

}
