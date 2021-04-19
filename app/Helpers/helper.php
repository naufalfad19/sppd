<?php

namespace App\Helpers;

use Sentinel;

class helper
{
    public static function awalan($kalimat){
        $katas = explode(" ",$kalimat);
        $hasil = '';
        foreach($katas as $kata){
          if(strlen($kata)!=0){
            $hasil .= $kata[0].' ';
          }
        }
        $hasil = substr($hasil,0,7);
        return strtoupper($hasil);
    }

    public static function rupiah($val)
    {
        return number_format($val,0,',','.');
    }

    public static function sekianwaktu($time)
    {
        $selisih = time() - strtotime($time) ;
        $detik = $selisih ;
        $menit = round($selisih / 60 );
        $jam = round($selisih / 3600 );
        $hari = round($selisih / 86400 );
        $minggu = round($selisih / 604800 );
        $bulan = round($selisih / 2419200 );
        $tahun = round($selisih / 29030400 );
        if ($detik <= 60) {
            $waktu = $detik.' '.__('helper.h_sekian_waktu.sw_detik');
        } else if ($menit <= 60) {
            $waktu = $menit.' '.__('helper.h_sekian_waktu.sw_menit');
        } else if ($jam <= 24) {
            $waktu = $jam.' '.__('helper.h_sekian_waktu.sw_jam');
        } else if ($hari <= 7) {
            $waktu = $hari.' '.__('helper.h_sekian_waktu.sw_hari');
        } else if ($minggu <= 4) {
            $waktu = $minggu.' '.__('helper.h_sekian_waktu.sw_minggu');
        } else if ($bulan <= 2) {
            $waktu = $bulan.' '.__('helper.h_sekian_waktu.sw_bulan');
        }else{
          $waktu = $time;
        }
        return $waktu;
    }

}
