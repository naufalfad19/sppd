<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class inventorisRequestList extends Resource
{
    public function toArray($request)
    {
        $status = "Diproses";
        if($this->status==1){
          $status = "Diterima";
        }elseif($this->status==2){
          $status = "Ditolak";
        }
        return [
            'id' => $this->id,
            'tanggal' => $this->tanggal,
            'satker' => $this->satker->name,
            'status' => $status,
            'total' => $this->details->count()
        ];
    }
}
