<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\suratTugas;
use App\Models\pegawai;
use App\Models\kwitansi;
use App\Models\detailSuratTugas as detail;
use App\User;
use Sentinel;
use App\Http\Controllers\DateTime;
use App\Http\Resources\suratTugasList;
use Illuminate\Support\Facades\DB;

class suratTugasDetailController extends Controller
{
    public function store(Request $request, $id)
    {
        try{
            $status = 0;
            $surat = suratTugas::find($id);
            foreach($surat->details as $detail_pegawai){
                if($detail_pegawai->pegawai->id == $request->pegawai){
                    $status = 1;
                }
            }
            $data = suratTugas::find($id);

            $pegawai = pegawai::select('id',DB::RAW("concat(name,'(NIP.',nip,')') as name"))->get();       
        $pegawai = $pegawai->pluck('name','id');  
            if($status == 0){
            $detail = new detail;
            $detail->id_surat_tugas = $id;
            $detail->id_user = $request->pegawai;
            $detail->id_kwitansi = 0;
            $detail->save();
            }else{
                toast()->error(__('Nama Pegawai telah Terdaftar'));
                Log::info("User ".Sentinel::getUser()->name." Menambahkan Sebuah Surat Tugas");
                return view('backend.suratPerintah.pegawai',compact('data','pegawai'));
            }       

            toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->name." Menambahkan Sebuah Surat Tugas");
            return view('backend.suratPerintah.pegawai',compact('data','pegawai'));
        } catch (\Exception $e) {
       
            toast()->error(__('toast.g_create.c_gagal.g_pesan'), __('toast.g_create.c_gagal.g_label'));
            Log::error("User ".Sentinel::getUser()->name." Mengalami Eror di create Surat Tugas | error : ".$e->getMessage());
            return view('backend.suratPerintah.pegawai',compact('data','pegawai'));
        }

    }

    public function destroy($id)
    {
        try {
           
            $data = detail::find($id);
            
            $id = $data->id_surat_tugas;
            $data->delete();


            $data = suratTugas::find($id);            
            

            $pegawai = pegawai::select('id',DB::RAW("concat(name,'(NIP.',nip,')') as name"))->get();       
            $pegawai = $pegawai->pluck('name','id');  
            
            toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->name."Menghapus Sebuah Barang");

        } catch (\Exception $e) {
            Log::error("User ".Sentinel::getUser()->name."Mengalami Eror di Hapus Barang | error : ".$e->getMessage());
            toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
        }
        return view('backend.suratPerintah.pegawai',compact('data','pegawai'));
    }
}
