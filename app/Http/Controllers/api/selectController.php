<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\inventorisSumber as sumber;
use DB;
use Sentinel;
use App\Helpers\helper;

class selectController extends Controller
{
    public function sumber($satker, $barang, $satuan)
    {
        $sumber = sumber::select('inventoris_sumber.id','inventoris_sumber.name')->where('inventoris_sumber.id','<>',1)->get();
        if($sumber->count()>=0){
          $sumber = $sumber->push(['id'=>'xxx', 'name'=>'Lainnya']);
        }
        if(Sentinel::getUser()->hasAccess(['inventoris.all-data']) && $satker == 1){
          $sumber = sumber::select('inventoris_sumber.id',DB::RAW("concat(inventoris_sumber.name,' (',sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END)-sum(CASE WHEN inventoris_detail.status=1 THEN inventoris_detail.total ELSE 0 END),')') as name"))
                    ->join('inventoris_detail','inventoris_sumber.id','=','inventoris_detail.sumber_id')
                    ->join('inventoris','inventoris_detail.inventoris_id','=','inventoris.id')
                    ->where('inventoris_sumber.id','<>',1)
                    ->where('inventoris.barang_id',$barang)
                    ->where('inventoris.satuan_id',$satuan)
                    ->where(function ($query) use($satker){
                      $query->where('inventoris.satker_id',1)->orwhere('inventoris_detail.status',1);
                    })
                    ->groupby('inventoris_sumber.id')
                    ->orderby(DB::RAW("sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END)-sum(CASE WHEN inventoris_detail.status=1 THEN inventoris_detail.total ELSE 0 END)"),'desc')
                    ->get();
        }

        return response()->json($sumber);
    }
}
