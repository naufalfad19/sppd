<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Role;
use App\Models\inventorisSumber as sumber;
use Sentinel;
use Route;

class inventorisSumberController extends Controller
{
  public function index(Request $request)
  {
    try {
      return view('backend.sumber.index');
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
                      if(sumber::whereRaw("UPPER(name) = '".strtoupper($value)."'")->first()){
                        toast()->warning($attribute.' sudah ada sebelumnya.', 'warning');
                        $fail($attribute.' sudah ada sebelumnya.');
                      }
                  }]
    ]);
    try {
        $sumber = new sumber;
        $sumber->name = $request->name;
        $sumber->save();
        toast()->success(__('toast.t_sumber.r_create.c_berhasil.b_pesan'), __('toast.t_sumber.r_create.c_berhasil.b_label'));
        return redirect()->route('sumber.index');
    } catch (\Exception $e) {
        toast()->error($e->getMessage(), 'Eror');
        toast()->error(__('toast.t_sumber.r_create.c_gagal.g_pesan'), __('toast.t_sumber.r_create.c_gagal.g_label'));
        return redirect()->back();
    }
  }


  public function show($id)
  {
    try {
      $users = null;
      if($id){
          $role = Sentinel::findRoleBySlug($id);
          $users = $role->users()::paginate(8);
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
          'name' => 'required'
      ]);

      if(sumber::whereRaw("UPPER(name) = '".strtoupper($request->name)."'")->where('id','<>',$id)->first()){
          $request->validate([
              'name' => [function ($attribute, $value, $fail) {
                            if(sumber::whereRaw("UPPER(name) = '".strtoupper($value)."'")->first()){
                              toast()->warning($attribute.' sudah ada sebelumnya.', 'warning');
                              $fail($attribute.' sudah ada sebelumnya.');
                            }
                        }]
          ]);
      }
      $sumber = sumber::find($id);
      $sumber->name = $request->name;
      $sumber->save();
      toast()->success(__('toast.t_sumber.r_update.up_berhasil.b_pesan'), __('toast.t_sumber.r_update.up_berhasil.b_label'));
      return redirect()->route('sumber.index');
    } catch (\Exception $e) {
        toast()->error($e->getMessage(), 'Eror');
        toast()->error(__('toast.t_sumber.r_update.up_gagal.g_pesan'), __('toast.t_sumber.r_update.up_gagal.g_label'));
        return redirect()->back();
    }
  }


  public function destroy($id)
  {
    try {
        $sumber = sumber::find($id);
        $sumber->delete();
        toast()->success(__('toast.t_sumber.r_delete.d_berhasil.b_pesan'), __('toast.t_sumber.r_delete.d_berhasil.b_label'));
    } catch (\Exception $e) {
        toast()->error($e->getMessage(), 'Eror');
        toast()->error(__('toast.t_sumber.r_delete.d_gagal.g_pesan'), __('toast.t_sumber.r_delete.d_gagal.g_label'));
    }
    return redirect()->back();
  }

  public function permissions($id)
  {
    try {
      $role = Sentinel::findRoleById($id);
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
              $op = str_replace("\-","-",$op);
              array_push($actions,$op.'.all-data', $op.'.part-data',$op.'.self-data');
            }
          }
          $var[$i] = preg_grep('~' . $input . '~', $actions);
          $actions = array_values(array_diff($actions, $var[$i]));
          $i += 1;
      }

      $actions = array_filter($var);
      // $add = 'log-viewer::logs.dashboard';
      // array_push($actions[1],$add);
      return View('backend.roles.permission', compact('role', 'actions'));
    } catch (\Exception $e) {
      toast()->error($e->getMessage(), 'Eror');
      toast()->error('Terjadi Eror Saat Meng-Load Permission, Silakan Ulang Login kembali', 'Gagal');
      return redirect()->back();
    }
  }

  public function simpan($id, Request $request)
  {
    try {
      $role = Sentinel::findRoleById($id);
      $role->permissions = [];
      if($request->permissions){
          foreach ($request->permissions as $permission) {
              if(explode('.', $permission)[1] == 'create'){
                  $role->addPermission($permission);
                  $role->addPermission(explode('.', $permission)[0].".store");
              }
              else if(explode('.', $permission)[1] == 'edit'){
                  $role->addPermission($permission);
                  $role->addPermission(explode('.', $permission)[0].".update");
              }
              else{
                  $role->addPermission($permission);
              }
          }
      }
      $role->save();
      toast()->success('Berhasil Menyimpan Role', 'Berhasil');
      return redirect()->route('roles.index');
    } catch (\Exception $e) {
      toast()->error($e->getMessage(), 'Eror');
      toast()->error('Terjadi Eror Saat Meng-Nyimpan Permission, Silakan Ulang Login kembali', 'Gagal');
      return redirect()->back();
    }
  }

  public function getData(Request $request)
  {
      $data = [];
      //?data
      if($request->data=="all"){
        $data = sumber::orderby('id','desc')->get();
      }
      //?data=&id=
      elseif($request->data=="id"){
        $data = sumber::find($request->id);
      }

      return response()->json($data);
  }

  public function permissionGetData(Request $request)
  {
      $data = false;

      // ?data=permission&permission=
      if($request->data=="permission"){
        $data = Sentinel::getUser()->hasAccess($request->permission);
      }
      // ?data=aplikasi&aplikasi=
      elseif($request->data=="aplikasi"){
        $id = $request->aplikasi;
        $data = Sentinel::getUser()->myapps()->where('aplikasi_id',$id)->where('status',1)->get()->isNotEmpty();
      }

      return ['data'=>$data];
  }


}
