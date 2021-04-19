<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use Illuminate\Support\Facades\Log;
use App\Models\inventorisDetail as id;
use App\Models\inventoris;
use App\Models\inventorisSumber as sumber;
use Illuminate\Support\Facades\DB;

class inventorisDetailController extends Controller
{
    public function store($inventoris_id, Request $request)
    {
        $request->validate([
            'sumber' => 'required',
            'tanggal' => 'required',
            'total' => 'required'
        ]);
        try {
            $status = 0;
            $sumber = $request->sumber;
            if($sumber=='xxx'){
              $sumber = 0;
            }

            $inventorisDetailOld = id::where('inventoris_id',$inventoris_id)->where('sumber_id',$sumber)->where('tanggal',$request->tanggal)->first();
            if(Sentinel::getUser()->hasAccess(['inventoris.all-data'])){
              $data = inventoris::find($inventoris_id);
              if($data->satker_id!=1){
                $status = 1;
                $data = inventoris::where('barang_id',$data->barang_id)->where('satuan_id',$data->satuan_id)->where('satker_id', 1)->first();
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
            };
            if($inventorisDetailOld){
              $inventorisDetailOld->total = $inventorisDetailOld->total + $request->total;
              $inventorisDetailOld->update();
              toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
            }else{
              if($sumber== 0){
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
              $inventorisDetail->inventoris_id = $inventoris_id;
              $inventorisDetail->sumber_id = $sumber;
              $inventorisDetail->tanggal = $request->tanggal;
              $inventorisDetail->status = $status;
              $inventorisDetail->total = $request->total;
              $inventorisDetail->save();
              toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
            }
            Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menambahkan Sebuah Detail inventoris");
        } catch (\Exception $e) {
            toast()->error(__('toast.g_create.c_gagal.g_pesan'), __('toast.g_create.c_gagal.g_label'));
            Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di create Detail inventoris | error : ".$e->getMessage());
        }
        return redirect()->back();
    }

    public function update($inventoris_id, Request $request, $id)
    {
        $request->validate([
            'sumber' => 'required',
            'tanggal' => 'required',
            'total' => 'required',
        ]);
        try {
            $sumber = $request->sumber;
            if($sumber=='xxx'){
              $sumber = 0;
            }
            $inventorisDetail = id::where('inventoris_id',$inventoris_id)->where('sumber_id',$sumber)->where('tanggal',$request->tanggal)->where('id','<>',$id);
            if($inventorisDetail->get()->count() > 0){
              toast()->warning('Detail Inventoris Lain Telah Terdaftar, Silakan Update Detail Inventoris yang di inginkan', 'gagal');
              return redirect()->back();
            }else{
              if($sumber==0){
                $request->validate([
                  'sumber_lain' => 'required'
                ]);

                if($request->sumber_lain=="xxx"){
                  toast()->warning('Harap Kolom Sumber Lain di isi dengan Benar', 'warning');
                  Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Memasukan Sumber XXX");
                  return redirect()->back()->withInput();
                }
                $sumber = sumber::create(['name'=>$request->sumber_lain]);
                $sumber = $sumber->id;
              }
              $inventorisDetail = id::find($id);
              if($inventorisDetail->inventoris_id!=1){
                $inventoris = inventoris::find($inventorisDetail->inventoris_id);
                if((($inventoris->details->sum('total')-$inventorisDetail->total)-$inventoris->keluar()->sum('total'))+$request->total <= 0){
                  Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Data inventoris masuk yang menyebabkan sisa minus ");
                  toast()->error('Tidak Bisa Merubah Data, Perubahan data menyebabkan sisa inventory minus', __('toast.g_create.c_gagal.g_label'));
                  return redirect()->back();
                }
              }else{
                $inventoris = inventoris::find($inventorisDetail->inventoris_id);
                if((($inventoris->details->sum('total')-$inventorisDetail->total)-$inventoris->keluarDinkes()->sum('total'))+$request->total <= 0){
                  Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Data inventoris masuk yang menyebabkan sisa minus ");
                  toast()->error('Tidak Bisa Merubah Data, Perubahan data menyebabkan sisa inventory minus', __('toast.g_create.c_gagal.g_label'));
                  return redirect()->back();
                }
              }
              $inventorisDetail->inventoris_id = $inventoris_id;
              $inventorisDetail->sumber_id = $sumber;
              $inventorisDetail->tanggal = $request->tanggal;
              $inventorisDetail->total = $request->total;
              $inventorisDetail->update();
            }
            toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Sebuah Detail inventoris");
        } catch (\Exception $e) {
            toast()->error(__('toast.g_update.up_gagal.g_pesan'), __('toast.g_update.up_gagal.g_label'));
            Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Update Detail inventoris | error : ".$e->getMessage());
        }
        return redirect()->back();
    }

    public function destroy($inventoris_id, $id)
    {
      try {
          $inventorisDetail = id::find($id);
          if($inventorisDetail->inventoris_id!=1){
            $inventoris = inventoris::find($inventorisDetail->inventoris_id);
            if(($inventoris->details->sum('total')-$inventoris->keluar()->sum('total'))-$inventorisDetail->total <=0){
              Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menghapus Data inventoris masuk yang menyebabkan sisa minus ");
              toast()->error('Tidak Bisa Menghapus Data, Penghapusan data menyebabkan sisa inventory minus', __('toast.g_create.c_gagal.g_label'));
              return redirect()->back();
            }
          }else{
            $inventoris = inventoris::find($inventorisDetail->inventoris_id);
            if(($inventoris->details->sum('total')-$inventoris->keluarDinkes()->sum('total'))-$inventorisDetail->total <=0){
              Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menghapus Data inventoris masuk yang menyebabkan sisa minus ");
              toast()->error('Tidak Bisa Menghapus Data, Penghapusan data menyebabkan sisa inventory minus', __('toast.g_create.c_gagal.g_label'));
              return redirect()->back();
            }
          }
          $inventorisDetail->delete();
          toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
          Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menghapus Sebuah Detail Inventoris");

      } catch (\Exception $e) {
          Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Hapus Detail Inventoris | error : ".$e->getMessage());
          toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
      }
      return redirect()->back();
    }
}
