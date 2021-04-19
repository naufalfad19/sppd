<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\inventorisRequestDetail as inreqde;
use App\Models\inventorisRequest as inreq;
use Sentinel;

class inventorisRequestDetailController extends Controller
{
    public function store($id, Request $request)
    {
      // id = inventoris request id;
        $request->validate([
            'barang' => 'required',
            'satuan' => 'required',
            'total' => 'required'
        ]);

        try {

          $inreq = inreq::where('satker_id',Sentinel::getUser()->satker_id)->where('id',$id)->first();
          if($inreq){
            if($inreq->status!=0){
              Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Data Request yang Telah diSetujui ");
              toast()->error('Tidak Bisa Merubah Data yang Telah diSetujui', __('toast.g_create.c_gagal.g_label'));
              return redirect()->back();
            }
          }
          $old = inreqde::where('inventoris_request_id',$id)
                        ->where('barang_id',$request->barang)
                        ->where('satuan_id',$request->satuan)
                        ->first();

          if($old){
              $old->total = $old->total + $request->total;
              $old->update();
          }else{
              $inreqde = new inreqde();
              $inreqde->inventoris_request_id = $id;
              $inreqde->barang_id = $request->barang;
              $inreqde->satuan_id = $request->satuan;
              $inreqde->total = $request->total;
              $inreqde->save();
          }
          toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
          Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menambahkan Sebuah Detail Request Inventoris");
        } catch (\Exception $e) {
          Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di create Detail Request Inventoris | error : ".$e->getMessage());
          toast()->error(__('toast.g_create.c_gagal.g_pesan'), __('toast.g_create.c_gagal.g_label'));
        }
        return redirect()->back();

    }

    public function update($id, Request $request)
    {
        $request->validate([
            'total' => 'required'
        ]);

        if(!Sentinel::getUser()->hasAccess('inventoris.all-data')){
            $request->validate([
              'barang' => 'required',
              'satuan' => 'required',
            ]);
        }

        try {
          $inreqde = inreqde::find($id);
          $inreq = inreq::where('satker_id',Sentinel::getUser()->satker_id)->where('id',$inreqde->inventoris_id)->first();
          if($inreq){
            if($inreq->status!=0){
              Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Data Request yang Telah diSetujui ");
              toast()->error('Tidak Bisa Merubah Data yang Telah diSetujui', __('toast.g_create.c_gagal.g_label'));
              return redirect()->back();
            }
          }
          if(!Sentinel::getUser()->hasAccess('inventoris.all-data')){
            $inreqde->barang_id = $request->barang;
            $inreqde->satuan_id = $request->satuan;
          }
          $inreqde->total = $request->total;
          $inreqde->update();
          toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
          Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menambahkan Sebuah Detail Request Inventoris");
        } catch (\Exception $e) {
          Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di update Detail Request Inventoris | error : ".$e->getMessage());
          toast()->error(__('toast.g_update.up_gagal.g_pesan'), __('toast.g_update.up_gagal.g_label'));
        }
        return redirect()->back();
    }

    public function destroy($id)
    {

      try {
          $data = inreqde::find($id);
          $id = $data->inventoris_request_id;
          $inreq = inreq::where('satker_id',Sentinel::getUser()->satker_id)->where('id',$id)->first();
          if($inreq){
            if($inreq->status!=0){
              Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Data Request yang Telah diSetujui ");
              toast()->error('Tidak Bisa Merubah Data yang Telah diSetujui', __('toast.g_create.c_gagal.g_label'));
              return redirect()->back();
            }
          }
          if(inreqde::where('inventoris_request_id',$id)->get()->count()<=1){
            $inreq = inreq::find($id);
            $inreq->delete();
            return redirect()->route('inreq.index');
          }
          $data->delete();
          toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
          Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menghapus Sebuah Request Inventoris");
      } catch (\Exception $e) {
          Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Hapus Request Inventoris | error : ".$e->getMessage());
          toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
      }
      return redirect()->route('inreq.show',$id);

    }
}
