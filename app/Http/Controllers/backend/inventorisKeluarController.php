<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use Illuminate\Support\Facades\Log;
use App\Models\inventorisKeluar as id;

class inventorisKeluarController extends Controller
{
    public function store($inventoris_id, Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
            'tanggal' => 'required',
            'total' => 'required'
        ]);
        try {
            $inventorisKeluar = new id();
            $inventorisKeluar->inventoris_id = $inventoris_id;
            $inventorisKeluar->keterangan = $request->keterangan;
            $inventorisKeluar->tanggal = $request->tanggal;
            $inventorisKeluar->total = $request->total;
            $inventorisKeluar->save();
            toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
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
            'keterangan' => 'required',
            'tanggal' => 'required',
            'total' => 'required',
        ]);
        try {
            $inventorisKeluar = id::where('inventoris_id',$inventoris_id)->where('keterangan',$request->keterangan)->where('tanggal',$request->tanggal)->where('id','<>',$id);
            if($inventorisKeluar->get()->count() > 0){
              toast()->warning('Pengeluaran Inventoris Lain Telah Terdaftar, Silakan Update Detail Inventoris yang di inginkan', 'gagal');
              return redirect()->back();
            }else{
              $inventorisKeluar = id::find($id);
              $inventorisKeluar->inventoris_id = $inventoris_id;
              $inventorisKeluar->keterangan = $request->keterangan;
              $inventorisKeluar->tanggal = $request->tanggal;
              $inventorisKeluar->total = $request->total;
              $inventorisKeluar->update();
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
          $inventorisKeluar = id::find($id);
          $inventorisKeluar->delete();
          toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
          Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menghapus Sebuah Detail Inventoris");

      } catch (\Exception $e) {
          Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Hapus Detail Inventoris | error : ".$e->getMessage());
          toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
      }
      return redirect()->back();
    }
}
