<?php

namespace App\Http\Controllers\Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\satuanKerja as satker;
use App\Models\inventorisSumber as sumber;
use Sentinel;
use Activation;

class RegisterController extends Controller
{
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
      //fungsi cek untuk mengetahui user sudah login atau belum
      if(Sentinel::check()){
        return redirect()->back();
      }else{
        return view('auth.register');
      }
    }

    protected function register(Request $request)
    {
      
        $request->validate([
            'first_name' => 'required|string|max:30',
            'last_name' => 'max:30',
            'email' => 'required|string|email|max:50|unique:users,email',
            'username' => 'required|string|max:20|min:4|unique:users,username',
            'password' => 'required|string|min:8|same:password_confirmation',
        ]);
    
    
        try {
          $data = $request->all();
          $sumber = new sumber;
          $sumber->name = $request->first_name.' '.$request->last_name;
          $sumber->save();
          $satker = new satker;
          $satker->name = $request->first_name.' '.$request->last_name;
          $satker->status = 3;
          $satker->save();
          $satker = satker::where('name',$request->first_name.' '.$request->last_name)->first();
          $role = 3;
          $data['satker_id'] = $satker->id;
          $data['role'] = $role;
          $data['password'] = bcrypt($request->password);
    
          if ($request->hasFile('avatar') && $request->avatar->isValid()) {
              $path = config('value.img_path.avatar');
              $oldfile = $data['avatar'];
              $fileext = $request->avatar->extension();
              $filename = "avatars-".$data['first_name'].'-'.$data['username'].'.'.$fileext;
              //Real File
              $filepath = $request->file('avatar')->storeAs($path, $filename, 'local');
              //Avatar File
              $realpath = storage_path('app/'.$filepath);
    
              $data['avatar'] = $filename;
          }
    
          $user = User::create($data);
    
          if($user->id){
            $activation = Activation::create($user);
            $activation = Activation::complete($user, $activation->code);
    
            if(Sentinel::getUser()->hasAccess(['users.part-data']) && $request->role==1){
              $request->role=0;
            }
    
            $user->roles()->sync($role);
            toast()->success(__('toast.t_user.u_create.c_berhasil.b_pesan'), __('toast.t_user.u_create.c_berhasil.b_label'));
            return redirect()->route('users.index');
          }
        } catch (\Exception $e) {
    
          toast()->error(__('toast.t_user.u_create.c_gagal.g_pesan'), __('toast.t_user.u_create.c_gagal.g_label'));
          return redirect()->back();
        }
      }
}
