<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pangkatGol extends Model
{
    protected $table = 'pangkat_gol';

    protected $fillable = [
        'pangkat', 'golongan'
    ];
}
