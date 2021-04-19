<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\barang;
use Sentinel;

class barangController extends Controller
{
  public function index(Request $request)
  {
      try {
        return view('backend.suratTugas.index');
      } catch (\Exception $e) {
          toast()->error($e->getMessage(), 'Eror');
          return redirect()->back();
      }
  }

  public function store(Request $request)
  {

    $request->validate([
        'name' => ['required',
                  function ($attribute, $value, $fail) {
                      if(barang::whereRaw("UPPER(name) = '".strtoupper($value)."'")->first()){
                        toast()->warning($attribute.' sudah ada sebelumnya.', 'warning');
                        $fail($attribute.' sudah ada sebelumnya.');
                      }
                  }]
    ]);



    try {
        $barang = new barang;
        $barang->name = $request->name;
        $barang->save();
        toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
        Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menambahkan Sebuah Barang");
        return redirect()->route('barang.index');
    } catch (\Exception $e) {
        toast()->error(__('toast.g_create.c_gagal.g_pesan'), __('toast.g_create.c_gagal.g_label'));
        Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di create Barang | error : ".$e->getMessage());
        return redirect()->back();
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $request->validate([
          'name' => 'required'
      ]);

      if(barang::whereRaw("UPPER(name) = '".strtoupper($request->name)."'")->where('id','<>',$id)->first()){
          $request->validate([
              'name' => [function ($attribute, $value, $fail) {
                            if(barang::whereRaw("UPPER(name) = '".strtoupper($value)."'")->first()){
                              toast()->warning($attribute.' sudah ada sebelumnya.', 'warning');
                              $fail($attribute.' sudah ada sebelumnya.');
                            }
                        }]
          ]);
      }
      
      $barang = barang::find($id);
      $barang->name = $request->name;
      $barang->save();
      toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
      Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Sebuah Barang");
      return redirect()->route('barang.index');
    } catch (\Exception $e) {
        Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Edit Barang | error : ".$e->getMessage());
        toast()->error(__('toast.g_update.up_gagal.g_pesan'), __('toast.g_update.up_gagal.g_label'));
        return redirect()->back();
    }
  }


  public function destroy($id)
  {
    try {
        $barang = barang::find($id);
        $barang->delete();
        toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
        Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menghapus Sebuah Barang");

    } catch (\Exception $e) {
        Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Hapus Barang | error : ".$e->getMessage());
        toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
    }
    return redirect()->back();
  }

  public function getData(Request $request)
  {
      $data = [];
      //?data=all
      if($request->data=="all"){
        $data = barang::orderby('id','desc')->get();
      }
      //?data=id&id=
      elseif($request->data=="id"){
        $data = barang::find($request->id);
      }
      //data=select&id=
      elseif($request->data=="select"){
        $id = explode(',',$request->id);
        $data = barang::wherenotin('id', $id)->get();
      }

      return response()->json($data);
  }

}
