<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\userList;
use App\Models\pegawai;
use App\Models\pejabat;
use App\User;
use App\Role;
use Sentinel;
use Activation;
use Route;
use DB;

class pejabatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit()
    {
        $data = pejabat::find(1);
        return view('backend.pejabat.edit', compact('data'));
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
            
            $pejabat = pejabat::find($id);
            $pejabat->nama_kkw = $request->nama_kkw;
            $pejabat->nip_kkw = $request->nip_kkw;
            $pejabat->nama_kbtu = $request->nama_kbtu;
            $pejabat->nip_kbtu = $request->nip_kbtu;
            $pejabat->nama_ppk = $request->nama_ppk;
            $pejabat->nip_ppk = $request->nip_ppk;
            $pejabat->nama_bp = $request->nama_bp;
            $pejabat->nip_bp = $request->nip_bp;
            $pejabat->save();
            toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->name." Merubah Sebuah Barang");
            return redirect()->back();
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
        //
    }
}
