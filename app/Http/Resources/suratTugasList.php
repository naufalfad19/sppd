<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class suratTugasList extends Resource
{
    public function toArray($request)
    {
        $tgl = date_format($this->created_at,"d-m-Y");
        
            //$tgl = date_format($this->sppd->tanggal_pulang,"d-m-Y");
            $tanggal_pulang = date('d-m-Y', strtotime($this->sppd->tanggal_pulang));
            $tanggal_pergi = date('d-m-Y', strtotime($this->sppd->tanggal_pergi));
        if(!$this->sppd->tanggal_pulang){
            $tanggal_pulang = "";
        }
        if(!$this->sppd->tanggal_pergi){
            $tanggal_pergi = "";
        }
        
        //$tanggal_pergi = date_format($this->sppd->tanggal_pergi,"d-m-Y");
        if($this->sppd->id>1 && $this->jenis_perintah == 1){
            if($this->status == 0)
            {
                $status = "<a class='btn btn-default btn-sm' onclick='status($this->id)' href='javascript::void(0)'>Telah Dibuat</a>";
            }elseif($this->status == 1){
                $status = "<a class='btn btn-warning btn-sm' onclick='status($this->id)' href='javascript::void(0)'>Sedang Dilaksanakan</a>";
            }elseif($this->status == 2){
                $status = "<a class='btn btn-info btn-sm' onclick='status($this->id)' href='javascript::void(0)'>Telah Dilaksanakan</a>";
            }elseif($this->status == 3){
                $status = "<a class='btn btn-success btn-sm'>Selesai</a>";
            }
        }elseif($this->jenis_perintah == 1){
            if($this->status == 0)
            {
                $status = "<a class='btn btn-default btn-sm' onclick='status1($this->id)' href='javascript::void(0)'>Telah Dibuat</a>";
            }elseif($this->status == 1){
                $status = "<a class='btn btn-warning btn-sm' onclick='status1($this->id)' href='javascript::void(0)'>Sedang Dilaksanakan</a>";
            }elseif($this->status == 2){
                $status = "<a class='btn btn-info btn-sm' onclick='status1($this->id)' href='javascript::void(0)'>Telah Dilaksanakan</a>";
            }elseif($this->status == 3){
                $status = "<a class='btn btn-success btn-sm'onclick='status1($this->id)' href='javascript::void(0)'>Selesai</a>";
            }
        }else{
            if($this->status == 0)
            {
                $status = "<a class='btn btn-default btn-sm' onclick='status($this->id)' href='javascript::void(0)'>Telah Dibuat</a>";
            }elseif($this->status == 1){
                $status = "<a class='btn btn-warning btn-sm' onclick='status($this->id)' href='javascript::void(0)'>Sedang Dilaksanakan</a>";
            }elseif($this->status == 2){
                $status = "<a class='btn btn-info btn-sm' onclick='status($this->id)' href='javascript::void(0)'>Telah Dilaksanakan</a>";
            }elseif($this->status == 3){
                $status = "<a class='btn btn-success btn-sm'>Selesai</a>";
            }
        }

        if($this->jenis_perintah == 1){
            $jenis_perintah = "Perjalanan Dinas";
        }elseif($this->jenis_perintah == 2){
            $jenis_perintah = "Non Perjalanan Dinas";
        }elseif($this->jenis_perintah == 3){
            $jenis_perintah = "Dalam Kota";
        }

        $bulan = array(
            '01' => 'I',
            '02' => 'II',
            '03' => 'III',
            '04' => 'IV',
            '05' => 'V',
            '06' => 'VI',
            '07' => 'VII',
            '08' => 'VIII',
            '09' => 'IX',
            '10' => 'X',
            '11' => 'XI',
            '12' => 'XII',
        );
        $diff = new \DateTime('NOW');
        $bulan = $bulan[date('m')];
        if($this->sppd->no_sppd){
            $no_sppd = $this->sppd->no_sppd."/SPPD_13.100/".$bulan."/".$diff->format('Y');
        }
        else{
            $no_sppd = $this->sppd->no_sppd;
        }
        return [
            'id' => $this->id,
            'no_surat' => $this->no_surat,
            'no_sppd' => $no_sppd,
            'tgl_pergi' => $tanggal_pergi,
            'tgl_pulang' => $tanggal_pulang,
            'tujuan' => $this->sppd->tujuan,
            'tgl' => $tgl,
            'pengaju' => $this->pengaju->name,
            'status' => $status,
            'jenis_perintah' => $jenis_perintah,
        ];
    }
}
