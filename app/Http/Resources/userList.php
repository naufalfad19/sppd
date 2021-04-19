<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class userList extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nip' => $this->nip,
            'name' => $this->name,
            'pangkat' => $this->pangkat->pangkat.' / '.$this->pangkat->golongan,
            'jabatan' => $this->jabatan,
            'ttl' => $this->tempat_lahir.'/'.$this->tanggal_lahir,
        ];
    }
}
