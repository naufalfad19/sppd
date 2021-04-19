<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class inventorisList extends Resource
{
    public function toArray($request)
    {
        $total = $this->details->sum('total') - $this->keluar()->sum('total');
        if($this->satker_id==1){
          $total = $this->masuk()->sum('total') - $this->keluarDinkes()->sum('total');
        }
        return [
          'id' => $this->id,
          'satker' => $this->satker->name,
          'barang' => $this->barang->name,
          'barang_id' => $this->barang->id,
          'satuan' => $this->satuan->name,
          'satuan_id' => $this->satuan->id,
          'total' => $total,
        ];
    }
}
