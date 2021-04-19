<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Sentinel;
use DB;

class profileController extends Controller
{
    public function index()
    {
        $data = Sentinel::getUser();
        return view('profile.index',compact('data'));
    }

    public function editProfile($value='')
    {
        return view('profile.edit');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:30',
            'last_name' => 'max:30',
            'email' => 'required|string|email|max:50|unique:users,email,'.Sentinel::getUser()->id,
            'username' => 'required|string|max:20|unique:users,username,'.Sentinel::getUser()->id,
            'avatar' => 'image|mimes:jpg,png,jpeg,gif',
        ]);

        try {

          $update = Sentinel::getUser();
          $data = $request->all();

          if ($request->hasFile('avatar') && $request->avatar->isValid()) {
              $path = config('value.img_path.avatar');
              $oldfile = $update->avatar;
              $fileext = $request->avatar->extension();
              $filename = "avatars-".$data['first_name'].'-'.$data['username'].'.'.$fileext;
              //Real File
              $filepath = $request->file('avatar')->storeAs($path, $filename, 'local');
              //Avatar File
              $realpath = storage_path('app/'.$filepath);
              $data['avatar'] = $filename;

              if ($filename != $oldfile) { //kalau file yang lama dan yang baru namanya tidak sama, maka akan melakukan
                File::delete(storage_path('app'.'/'. $path . '/' . $oldfile));
                File::delete(public_path($path . '/' . $oldfile));
              }
          }

          $update->update($data);
          Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Data Diri");
          toast()->success(__('toast.t_user.u_update.up_berhasil.b_pesan'), __('toast.t_user.u_update.up_berhasil.b_label'));
          return redirect('profile');
        } catch (\Exception $e) {
          Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Merubah Data Diri | error : ".$e->getMessage());
          toast()->error(__('toast.t_user.u_update.up_gagal.g_pesan'), __('toast.t_user.u_update.up_gagal.g_label'));
          return redirect()->back();
        }
    }

    public function editPassword()
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        try {
          $validator = Validator::make($request->all(), [
              'old_password'          => 'required|string',
              'baru_password'          => 'required|string|min:8',
              'confirm_password'      => 'required|string|min:8|same:baru_password',
          ]);
          if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
          }

          $data = Sentinel::getUser();

          $cek = Sentinel::stateless([
            'email' => Sentinel::getUser()->email,
            'password' => $request->old_password
          ]);

          if(!$cek){
              $validator->errors()->add('old_password','Password not same with old Password');
              return redirect()->back()->withErrors($validator);
          }

          $data->password = bcrypt($request->baru_password);
          $data->update();
          Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Merubah Password");
          toast()->success('Berhasil Merubah Password', 'Berhasil');
          return redirect('profile');
        } catch (\Exception $e) {
          dd($e);
          Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Terjadi Eror dalam Merubah Password | Error : ".$e->getMessage());
          toast()->success('Gagal Merubah Password', 'Gagal');
          return redirect('profile');
        }

    }
}
