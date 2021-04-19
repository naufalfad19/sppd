<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\satuanKerja as satker;
use App\User;
use Sentinel;

class satuanKerjaController extends Controller
{
  public function index(Request $request)
  {
      try {
        return view('backend.satuanKerja.index');
      } catch (\Exception $e) {
          toast()->error($e->getMessage(), 'Eror');
          return redirect()->back();
      }
  }

  public function store(Request $request)
  {
    $request->validate([
        'name' => 'required|unique:satuan_kerja,name',
        'logo' => 'image|mimes:jpg,png,jpeg,gif',
        'status' => 'required',
    ]);
    try {
        $satker = new satker;
        $satker->name = $request->name;
        $satker->status = $request->status;
        if ($request->hasFile('logo') && $request->logo->isValid()) {
            $path = config('value.img_path.logo');
            $fileext = $request->logo->extension();
            $filename = uniqid("logo-").'.'.$fileext;
            $filepath = $request->file('logo')->storeAs($path, $filename, 'local');
            $realpath = storage_path('app/'.$filepath);

            $satker->path_logo = $filename;
        }
        $satker->save();
        toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
        Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menambahkan Sebuah Satuan Kerja");
        return redirect()->route('satker.index');
    } catch (\Exception $e) {
        toast()->error(__('toast.g_create.c_gagal.g_pesan'), __('toast.g_create.c_gagal.g_label'));
        Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di create Satuan Kerja | error : ".$e->getMessage());
        return redirect()->back();
    }
  }


  public function show($id)
  {
    try {
      $users = null;
      if($id){
          $users = user::where('satker_id',$id)->paginate(8);
      }
      return view('backend.user.index',compact('users'));

    } catch (\Exception $e) {
        toast()->error($e->getMessage(), 'Eror');
        return redirect()->back();
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $request->validate([
          'name' => 'required|unique:satuan_kerja,name,'.$id,
          'logo' => 'image|mimes:jpg,png,jpeg,gif',
          'status' => 'required'
      ]);
      $satker = satker::find($id);
      $satker->name = $request->name;
      $satker->status = $request->status;
      $oldfile = $satker->path_logo;
      $path = config('value.img_path.logo');
      $filename = "";
      if ($request->hasFile('logo') && $request->logo->isValid()) {
          $fileext = $request->logo->extension();
          $filename = uniqid("logo-").'.'.$fileext;
          $filepath = $request->file('logo')->storeAs($path, $filename, 'local');
          $realpath = storage_path('app/'.$filepath);

          $satker->path_logo = $filename;
      }
      $satker->update();
      if ($filename != $oldfile) { //kalau file yang lama dan yang baru namanya tidak sama, maka akan melakukan
        File::delete(storage_path('app'.'/'. $path . '/' . $oldfile));
        File::delete(public_path($path . '/' . $oldfile));
      }
      toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
      Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Sebuah Satuan Kerja");
      return redirect()->route('satker.index');
    } catch (\Exception $e) {
        Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Edit Satuan Kerja | error : ".$e->getMessage());
        toast()->error(__('toast.g_update.up_gagal.g_pesan'), __('toast.g_update.up_gagal.g_label'));
        return redirect()->back();
    }
  }


  public function destroy($id)
  {
    try {
        if(Sentinel::getUser()->satker_id == $id){
          toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
          Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menghapus Dinas Kesehatan");
          return redirect()->back();
        }
        $satker = satker::find($id);
        $satker->delete();
        $path = config('value.img_path.logo');
        File::delete(storage_path('app'.'/'. $path . '/' . $satker->path_logo));
        File::delete(public_path($path . '/' . $satker->path_logo));
        toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
        Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menghapus Sebuah Satuan Kerja");

    } catch (\Exception $e) {
        Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Hapus Satuan Kerja | error : ".$e->getMessage());
        toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
    }
    return redirect()->back();
  }

  public function getData(Request $request)
  {
      $data = [];
      //?data
      if($request->data=="all"){
        $data = satker::orderby('id','desc')->get();
      }
      //?data=&id=
      elseif($request->data=="id"){
        $data = satker::find($request->id);
      }

      return response()->json($data);
  }

}
