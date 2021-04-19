<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\userList;
use App\Models\pegawai;
use App\Models\pangkatGol;
use App\User;
use App\Role;
use Sentinel;
use Activation;
use Route;
use DB;


class pegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.pegawai.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_pangkat = pangkatGol::select('id',DB::RAW("concat(pangkat,'/' ,golongan) as pangkat"))->get(); 
        $id_pangkat = $id_pangkat->pluck('pangkat','id');
        return view('backend.pegawai.create',compact('id_pangkat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $pegawai = new pegawai;
            $pegawai->nip = $request->nip;
            $pegawai->name = $request->name;
            $pegawai->id_pangkat = $request->id_pangkat;
            $pegawai->jabatan = $request->jabatan;
            $pegawai->tempat_lahir = $request->tempat_lahir;
            $pegawai->tanggal_lahir = $request->tanggal_lahir;
            $pegawai->save();

            toast()->success(__('toast.t_user.u_create.c_berhasil.b_pesan'), __('toast.t_user.u_create.c_berhasil.b_label'));
            return redirect()->route('pegawai.index');
            
        } catch (\Exception $e) {
            dd($e);
            toast()->error(__('toast.t_user.u_create.c_gagal.g_pesan'), __('toast.t_user.u_create.c_gagal.g_label'));
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_pangkat = pangkatGol::select('id',DB::RAW("concat(pangkat,'/' ,golongan) as pangkat"))->get(); 
        $id_pangkat = $id_pangkat->pluck('pangkat','id');
        $data = pegawai::find($id);
        if(!$data){
            toast()->error('Data User Tidak ditemukan', 'Gagal');
            return redirect()->back();
        }
        return view('backend.pegawai.edit',compact('data','id_pangkat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required'
            ]);
            
            $pegawai = pegawai::find($id);
            $pegawai->nip = $request->nip;
            $pegawai->name = $request->name;
            $pegawai->id_pangkat = $request->id_pangkat;
            $pegawai->jabatan = $request->jabatan;
            $pegawai->tempat_lahir = $request->tempat_lahir;
            $pegawai->tanggal_lahir = $request->tanggal_lahir;
            $pegawai->save();
            toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->name." Merubah Sebuah Barang");
            return redirect()->route('pegawai.index');
        } catch (\Exception $e) {
            Log::error("User ".Sentinel::getUser()->name." Mengalami Eror di Edit Barang | error : ".$e->getMessage());
            toast()->error(__('toast.g_update.up_gagal.g_pesan'), __('toast.g_update.up_gagal.g_label'));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
        $pegawai = pegawai::find($id);
        $pegawai->delete();
        toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
        Log::info("User ".Sentinel::getUser()->name." Menghapus Sebuah Pegawai");

        } catch (\Exception $e) {
            Log::error("User ".Sentinel::getUser()->name." Mengalami Eror di Hapus Pegawai | error : ".$e->getMessage());
            toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
        }
        return redirect()->back();
    }

    public function getData(Request $request)
    {
            $data = [];
            //?data=all&status=
            if($request->data=="all"){
                $data = pegawai::orderby('id','desc')->get();
            }
            if($data){
                return response()->json(userList::collection($data));
            }
            return response()->json($data);
    }
}
