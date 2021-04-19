<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\User;
use App\Role;
use Sentinel;
use Activation;
use Route;
use DB;

class UserController extends Controller
{
  public function index(Request $request)
  {
    $datas  = User::select('users.*');


    // dd($datas->lastItem());
    $datas = $datas->paginate(8);
    if($request->ajax==true){
      return $datas;
    }

    return view('backend.users.index',compact('datas'));
  }

  public function create()
  {
    $role = Role::get()->pluck('name', 'id');
    return view('backend.users.create',compact('role'));
  }

  public function store(Request $request)
  {
    $request->validate([
        'name' => 'required|string|max:100',
        'username' => 'required|string|max:20|min:4|unique:users,username',
        'password' => 'required|string|min:8|same:password_confirmation',
        'avatar' => 'image|mimes:jpg,png,jpeg,gif',
        'role' => 'required',
    ]);


    try {
      $data = $request->all();
      $data['password'] = bcrypt($request->password);

      $user = new User;
      $user->name = $request->name;
      $user->username = $request->username;
      $user->password = $data['password'];
      $user->save();

      $activation = Activation::create($user);
      $activ = new Activation();
      $user = User::where('username',$user->username)->first();
      $activation = Activation::complete($user, $activation->code);

        $user->roles()->sync($request->role);
        toast()->success(__('toast.t_user.u_create.c_berhasil.b_pesan'), __('toast.t_user.u_create.c_berhasil.b_label'));
        return redirect()->route('users.index');
      
    } catch (\Exception $e) {
      dd($e);
      toast()->error(__('toast.t_user.u_create.c_gagal.g_pesan'), __('toast.t_user.u_create.c_gagal.g_label'));
      return redirect()->back();
    }
  }

  public function show($id)
  {
      try {
        $data = User::find($id);
        if(Sentinel::getUser()->hasAccess(['users.part-data'])){
          $data = User::select('users.*')->join('role_users','users.id','=','role_users.user_id')->where('role_users.role_id','<>','1')->where('users.id',$id)->first();
        }

        if(!$data){
          toast()->error('Data User Tidak ditemukan', 'Gagal');
          return redirect()->back();
        }
        return view('backend.users.show',compact('data'));
      } catch (\Exception $e) {
        toast()->error('Gagal Mengambil Data User', 'Gagal');
        return redirect()->back();
      }

  }

  public function edit($id)
  {
      $data = User::find($id);
      $role = Role::get()->pluck('name', 'id');
      if(Sentinel::getUser()->hasAccess(['users.part-data'])){
        $role = Role::where('id','<>',1)->get()->pluck('name', 'id');
        $data = User::select('users.*')->join('role_users','users.id','=','role_users.user_id')->where('role_users.role_id','<>','1')->where('users.id',$id)->first();
      }
      if(!$data){
        toast()->error('Data User Tidak ditemukan', 'Gagal');
        return redirect()->back();
      }
      return view('backend.users.edit',compact('data','role'));
  }

  public function update($id, Request $request)
  {
    $request->validate([
        'first_name' => 'required|string|max:30',
        'last_name' => 'max:30',
        'email' => 'required|string|email|max:50|unique:users,email,'.$id,
        'username' => 'required|string|max:20|unique:users,username,'.$id,
        'avatar' => 'image|mimes:jpg,png,jpeg,gif',
        'role' => 'required',
        'satuan_kerja' => 'required',
    ]);

    try {
      $data = $request->except(['password','password_confirmation']);

      if($request->password){
        $request->validate([
            'password' => 'required|string|min:8|same:password_confirmation',
        ]);
        $request['password'] = bcrypt($request->password);
      }

      $update = User::find($id);

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
      if ($request->role) {
        if(Sentinel::getUser()->hasAccess(['users.part-data']) && $request->role==1){
          $request->role=0;
        }
        $update->roles()->sync($request->role);
      }
      toast()->success(__('toast.t_user.u_update.up_berhasil.b_pesan'), __('toast.t_user.u_update.up_berhasil.b_label'));

      return redirect()->route('users.index');

    } catch (\Exception $e) {
      toast()->error(__('toast.t_user.u_update.up_gagal.g_pesan'), __('toast.t_user.u_update.up_gagal.g_label'));
      return redirect()->back();
    }

  }

  public function destroy($id)
  {
      try {
        $update = User::find($id);
        
        // if(Sentinel::getUser()->hasAccess(['users.part-data'])){
        //   $update = User::select('users.*')->join('role_users','users.id','=','role_users.user_id')->where('role_users.role_id','<>','1')->where('users.id',$id)->first();
        // }
        toast()->success(__('toast.t_user.u_delete.d_berhasil.b_pesan'), __('toast.t_user.u_delete.d_berhasil.b_label'));
        $path = config('value.img_path.avatar');
        File::delete(storage_path('app'.'/'. $path . '/' . $update->avatar));
        File::delete(public_path($path . '/' . $update->avatar));
        $update->delete();
      } catch (\Exception $e) {
        dd($e);
        toast()->error(__('toast.t_user.u_delete.d_gagal.g_pesan'), __('toast.t_user.u_delete.d_gagal.g_label'));
      }
      return redirect()->route('users.index');
  }

  public function permissions($id){
      $user = Sentinel::findById($id);
      $routes = Route::getRoutes();

      $actions = [];
      foreach ($routes as $route) {
          if ($route->getName() != "" && !substr_count($route->getName(), 'payment')) {
              $actions[] = $route->getName();
          }
      }
      //remove store option
      $input = preg_quote("store", '~');
      $var = preg_grep('~' . $input . '~', $actions);
      $actions = array_values(array_diff($actions, $var));

      //remove update option
      $input = preg_quote("update", '~');
      $var = preg_grep('~' . $input . '~', $actions);
      $actions = array_values(array_diff($actions, $var));

      $var = [];
      $i = 0;
      foreach ($actions as $action) {
          $input = preg_quote(explode('.', $action )[0].".", '~');
          if(count(explode('.', $action )) > 1 ){
            if(preg_quote(explode('.', $action )[1], '~') == 'index' || preg_quote(explode('.', $action )[1], '~') == 'dashboard'){
              $op = preg_quote(explode('.', $action )[0], '~');
              array_push($actions,$op.'.all-data', $op.'.part-data',$op.'.self-data');
            }
          }
          $var[$i] = preg_grep('~' . $input . '~', $actions);
          $actions = array_values(array_diff($actions, $var[$i]));
          $i += 1;
      }
      $actions = array_filter($var);
      $add = ['data.semua','data.toko'];
      // array_push($actions,$add);
      // dd([$actions]);

      return View('backend.users.permission', compact('user', 'actions'));
  }

  public function simpan(Request $request, $id){
      $user = Sentinel::findById($id);
      $user->permissions = [];
      if($request->permissions){
          foreach ($request->permissions as $permission) {
              if(explode('.', $permission)[1] == 'create'){
                  $user->addPermission($permission);
                  $user->addPermission(explode('.', $permission)[0].".store");
              }
              else if(explode('.', $permission)[1] == 'edit'){
                  $user->addPermission($permission);
                  $user->addPermission(explode('.', $permission)[0].".update");
              }
              else{
                  $user->addPermission($permission);
              }
          }
      }

      $user->save();
      return redirect()->route('users.index');
  }

  public function active($id){
    try {
      $user = Sentinel::findById($id);

      $activation = Activation::completed($user);

      if($activation){
          //pemberitahuan kalau sudah aktiv
          return redirect()->route('users.index');
      }
      $activation = Activation::create($user);
      $activation = Activation::complete($user, $activation->code);
      toast()->success(__('toast.t_user.u_activ.ac_berhasil.b_pesan'), __('toast.t_user.u_activ.ac_berhasil.b_label'));
    } catch (\Exception $e) {
      toast()->success(__('toast.t_user.u_activ.ac_gagal.g_pesan'), __('toast.t_user.u_activ.ac_gagal.g_label'));
    }

    return redirect()->back();
  }

  public function deactivate($id){
    try {
      $user = Sentinel::findById($id);
      //dd([$id,$user]);
      Activation::remove($user);
      toast()->success(__('toast.t_user.u_deactiv.de_berhasil.b_pesan'), __('toast.t_user.u_deactiv.de_berhasil.b_label'));
    } catch (\Exception $e) {
      toast()->success(__('toast.t_user.u_deactiv.de_gagal.g_pesan'), __('toast.t_user.u_deactiv.de_gagal.g_label'));
    }

      //pemberitahuan user di non aktivkan
      return redirect()->back();
      // return redirect()->route('users.index');
  }

  public function ajax_all(Request $request){
      if ($request->action=='delete') {
         foreach ($request->all_id as $id) {
           $user = User::findOrFail($id);
           $user->delete();
           toast()->success(__('toast.t_user.u_delete.d_berhasil.b_pesan'), __('toast.t_user.u_delete.d_berhasil.b_label'));
          }
          return response()->json(['success' => true, 'status' => 'Sucesfully Deleted']);
      }
      if ($request->action=='deactivate') {
         foreach ($request->all_id as $id) {
           $user = User::findOrFail($id);
           $activation = Activation::completed($user);
           if ($activation){
             Activation::remove($user);
             toast()->success(__('toast.t_user.u_deactiv.de_berhasil.b_pesan'), __('toast.t_user.u_deactiv.de_berhasil.b_label'));
           }
          }
          return response()->json(['success' => true, 'status' => 'Sucesfully deactivate']);
      }
      if ($request->action=='activate') {
         foreach ($request->all_id as $id) {
           $user = User::findOrFail($id);
           $activation = Activation::completed($user);
           if ($activation==''){
              $activation = Activation::create($user);
              $activation = Activation::complete($user, $activation->code);
              toast()->success(__('toast.t_user.u_activ.ac_berhasil.b_pesan'), __('toast.t_user.u_activ.ac_berhasil.b_label'));
              }
          }
          return response()->json(['success' => true, 'status' => 'Sucesfully Activated']);
      }
  }

  public function getData(Request $request)
  {
      $data = [];
      //?data
      if($request->data=="all"){
        $data = User::select('users.*',DB::RAW("concat(first_name,' ',COALESCE(users.last_name,'')) as fullname"))->orderby('id','desc')->get();
      }
      //?data=&id=
      elseif($request->data=="id"){
        $data = User::select('users.*',DB::RAW("concat(first_name,' ',COALESCE(users.last_name,'')) as fullname"))->where($request->id)->first();
      }
      //?data=aplikasi_user&aplikasi=
      elseif($request->data=="aplikasi_user"){
        $id = $request->aplikasi;
        $data = User::select('users.*',DB::RAW("concat(first_name,' ',COALESCE(users.last_name,'')) as fullname"))->whereraw("id not in (select user_id from aplikasi_user where aplikasi_id = $id)")->get();
      }

      return response()->json($data);
  }

  public function aktivation_account($kode,$username)
  {
      try {
        $activ = new Activation();
        $user = User::where('username',$username)->first();
        $activation = Activation::complete($user, $kode);
        if($activation){
          toast()->success(__('toast.t_aktivasi.a_berhasil.b_pesan'), __('toast.t_aktivasi.a_berhasil.b_label'));
          Log::info("Ip ".\Request::ip()." Mengaktifkan Akun ".$user->first_name." ".$user->last_name);
        }else{
          toast()->error(__('toast.t_aktivasi.a_gagal.g_pesan'), __('toast.t_aktivasi.a_gagal.g_label'));
          Log::info("Ip ".\Request::ip()." Gagal Mengaktifkan Akun ".$user->first_name." ".$user->last_name);
        }

      } catch (\Exception $e) {
        dd($e);
        toast()->error(__('toast.t_user.u_create.c_gagal.g_pesan'), __('toast.t_user.u_create.c_gagal.g_label'));
      }
      return redirect('login');
  }

}
