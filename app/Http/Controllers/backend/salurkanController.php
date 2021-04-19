<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\inventoris;
use App\Models\satuanKerja;
use App\Models\satuanBarang;
use App\Models\barang;
use App\Models\inventorisSumber as sumber;
use App\Models\inventorisDetail as id;
use Sentinel;
use App\Http\Resources\inventorisList as inlist;
use Illuminate\Support\Facades\DB;

class salurkanController extends Controller
{
    public function create(Request $request)
    {
        $barang = barang::pluck('name','id');
        $satker = satuanKerja::where('status',1)->orwhere('id',1)->get()->pluck('name','id');
        if($request->status=="not-available"){
          $satker = satuanKerja::where('status',0)->where('id','<>',1)->get()->pluck('name','id');
        }
        $satuan = satuanBarang::pluck('name','id');
        return view('backend.salurkan.create',compact('barang','satker','satuan'));
    }

    public function store(Request $request)
    {
      $request->validate([
          'barang' => 'required',
          'satuan' => 'required',
          'total' => 'required',
          'sumber' => 'required',
          'tanggal' => 'required'
      ]);
  
      try {
          $satker_id = Sentinel::getUser()->satker_id;
          $status = 0;
          $sumber = $request->sumber;
          if($sumber=='xxx'){
            $sumber = 0;
          }
          if(Sentinel::getUser()->hasAccess(['inventoris.all-data'])){
            $request->validate([
              'satker' => 'required'
            ]);
            $satker_id = $request->satker;
            if($satker_id==1 && $sumber==1){
              toast()->error('Tidak Bisa Menambahkan Barang Dinkes dengan Sumber Dinkes Sendiri', 'Gagal');
              Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di create inventoris");
              return redirect()->back()->withInput();
            }
  
            if($satker_id!=1){
              $status = 1;
              $data = inventoris::where('barang_id',$request->barang)->where('satuan_id',$request->satuan)->where('satker_id', 1)->first();
              if($data){
                if($data->masuk()->where('inventoris_detail.sumber_id',$sumber)->get()->sum('total') < $request->total ){
                  toast()->warning('Barang dengan satuan dan sumber tidak mencukupi', 'warning');
                  Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami warning ketika Menambahkan Barang Satker Lain");
                  return redirect()->back()->withInput();
                }
              }else{
                toast()->warning('Barang dengan satuan dan sumber tidak mencukupi', 'warning');
                Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami warning ketika Menambahkan Barang Satker Lain");
                return redirect()->back()->withInput();
              }
            }
  
          }
          $inventoris = inventoris::where('barang_id',$request->barang)->where('satuan_id',$request->satuan)->where('satker_id',$satker_id);
          if($inventoris->get()->count() > 0){
            $inventoris = $inventoris->first();
          }else{
              $inventoris = new inventoris;
              $inventoris->barang_id = $request->barang;
              $inventoris->satuan_id = $request->satuan;
              $inventoris->satker_id = $satker_id;
              $inventoris->save();
          }
  
          $inventorisDetailOld = id::where('inventoris_id',$inventoris->id)->where('sumber_id',$sumber)->where('tanggal',$request->tanggal)->first();
          if($inventorisDetailOld){
            $inventorisDetailOld->total = $inventorisDetailOld->total + $request->total;
            $inventorisDetailOld->update();
          }else{
            if($sumber==0){
              $request->validate([
                  'sumber_lain' => ['required',
                            function ($attribute, $value, $fail) {
                                if(sumber::whereRaw("UPPER(name) = '".strtoupper($value)."'")->first()){
                                  toast()->warning($attribute.' sudah ada sebelumnya.', 'warning');
                                  $fail($attribute.' sudah ada sebelumnya.');
                                }
                            }]
              ]);
  
              if($request->sumber_lain=="xxx"){
                toast()->warning('Harap Kolom Sumber Lain di isi dengan Benar', 'warning');
                Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Memasukan Sumber XXX");
                return redirect()->back()->withInput();
              }
              $sumber = sumber::create(['name'=>$request->sumber_lain]);
              $sumber = $sumber->id;
              // dd($sumber);
            }
            $inventorisDetail = new id();
            $inventorisDetail->inventoris_id = $inventoris->id;
            $inventorisDetail->sumber_id = $sumber;
            $inventorisDetail->tanggal = $request->tanggal;
            $inventorisDetail->status = $status;
            $inventorisDetail->total = $request->total;
            $inventorisDetail->save();
          }
  
          toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
          Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menambahkan Sebuah inventoris");
          $status = 'available';
          if($inventoris->satker_id!=1){
            $status = $inventoris->satker->status==1 ? 'available' : 'not-available';
          }
          return redirect("inventoris?status=$status");
      } catch (\Exception $e) {
          toast()->error(__('toast.g_create.c_gagal.g_pesan'), __('toast.g_create.c_gagal.g_label'));
          Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di create inventoris | error : ".$e->getMessage());
          return redirect()->back()->withInput();
      }
    }
}
