<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\suratTugas;
use App\Models\pegawai;
use App\Models\sppd;
use App\Models\pejabat;
use Sentinel;
use App\Http\Resources\suratTugasList;
use Illuminate\Support\Facades\DB;

class sppdController extends Controller
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
    public function create($id)
    {
        try {
            $penandatanganan = [];
            $penandatanganan = [1 => 'Kakanwil', 2 => 'Selain Kakanwil'];
            $angkutan = [];
            $angkutan = [1 => 'Pesawat', 2 => 'Kendaraan Pribadi', 3 => 'Kendaraan Dinas', 4 => 'Angkutan Umum'];
            $sumber_dana = [];
            $sumber_dana = [1 => 'DIPA Kanwil', 2 => 'DIPA Kementrian ATR/BPN', 3 => 'DIPA Kantah'];
            $pengemban_anggaran = [];
            $pengemban_anggaran = [1 => 'DIPA Kanwil', 2 => 'DIPA Kementrian ATR/BPN', 3 => 'DIPA Kantah'];
            $pegawai = pegawai::select('id',DB::RAW("concat(name,'(NIP.',nip,')') as name"))->get();       
        $pegawai = $pegawai->pluck('name','id');  
            $surat = suratTugas::find($id);
            if($surat->id_sppd>1){
                $id = $surat->id_sppd;
                $data = sppd::find($id);
                $penandatanganan = [];
                $penandatanganan = [1 => 'Kakanwil', 2 => 'Selain Kakanwil'];
                $pegawai = pegawai::select('id',DB::RAW("concat(name,'(NIP.',nip,')') as name"))->get();       
        $pegawai = $pegawai->pluck('name','id');  
                return view('backend.suratPerintah.edit',compact('penandatanganan','pegawai','data','angkutan','sumber_dana','pengemban_anggaran'));
            }
            return view('backend.suratPerintah.create',compact('penandatanganan','pegawai','id','angkutan','sumber_dana','pengemban_anggaran'));
        } catch (\Exception $e) {
            toast()->error($e->getMessage(), 'Eror');
            return redirect()->back();
        }
    }

    public function cetak($id)
    {
        try {
            $data = suratTugas::find($id);
            $sppd = sppd::find($data->id_sppd);
            $pejabat = pejabat::find(1);
            // $document = file_get_contents("surat.rtf");
            // // isi dokumen dinyatakan dalam bentuk string
            // $document = str_replace("#menimbang_a", $menimbang_a, $document);
            // $document = str_replace("#menimbang_b", $menimbang_b, $document);
            // $document = str_replace("#dasar", $dasar, $document);
            // $document = str_replace("#untuk", $tujuan, $document);
            // // header untuk membuka file output RTF dengan MS. Word
            // header("Content-type: application/msword");
            // header("Content-disposition: inline; filename=suratIjin.doc");
            // header("Content-length: ".strlen($document));
            // echo $document;
            return view('backend.laporan.sppd',compact('data','sppd','pejabat'));

        } catch (\Exception $e) {
            
            Log::error("User ".Sentinel::getUser()->name."Mengalami Eror di Hapus Barang | error : ".$e->getMessage());
            toast()->error(__('Gagal Mencetak Surat Tugas'));
        }
        
    }

    public function lpd($id)
    {
        try {
            $data = suratTugas::find($id);
            if($data->status>=2){
            $sppd = sppd::find($data->id_sppd);
            // $document = file_get_contents("surat.rtf");
            // // isi dokumen dinyatakan dalam bentuk string
            // $document = str_replace("#menimbang_a", $menimbang_a, $document);
            // $document = str_replace("#menimbang_b", $menimbang_b, $document);
            // $document = str_replace("#dasar", $dasar, $document);
            // $document = str_replace("#untuk", $tujuan, $document);
            // // header untuk membuka file output RTF dengan MS. Word
            // header("Content-type: application/msword");
            // header("Content-disposition: inline; filename=suratIjin.doc");
            // header("Content-length: ".strlen($document));
            // echo $document;
            return view('backend.laporan.lpd',compact('data','sppd'));
            }else{
                toast()->error('Surat Tugas Belum Terlaksana');
                return redirect()->back();
            }

        } catch (\Exception $e) {
            
            Log::error("User ".Sentinel::getUser()->name."Mengalami Eror di Hapus Barang | error : ".$e->getMessage());
            toast()->error(__('Gagal Mencetak Surat Tugas'));
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        try{
        $data = new sppd;
        $data->no_sppd = $request->no_sppd;
        $data->tanggal_pergi = $request->tanggal_pergi;
        $data->tanggal_pulang = $request->tanggal_pulang;
        $data->tujuan = $request->tujuan;
        $data->angkutan = $request->angkutan;
        $data->tempat_berangkat = $request->tempat_berangkat;
        $data->tempat_tujuan = $request->tempat_tujuan;
        $data->dibuat_di = $request->dibuat_di;
        $data->sub_bagian = $request->sub_bagian;
        $data->ttd_oleh = $request->ttd_oleh;
        $data->nip_pejabat = $request->nip_pejabat;
        $data->nama_kakanwil = $request->nama_kakanwil;
        $data->nip_kakanwil = $request->nip_kakanwil;
        $data->penandatanganan = $request->penandatanganan;
        $data->pengemban_anggaran = $request->pengemban_anggaran;
        $data->skpa = $request->skpa;
        $data->sumber_dana = $request->sumber_dana;
        $data->mata_anggaran = $request->mata_anggaran;
        $data->keterangan = $request->keterangan;
        $data->save();

        $update = suratTugas::find($id);
        $update->id_sppd = $data->id;
        $update->update();

        $pegawai = pegawai::select('id',DB::RAW("concat(name,'(NIP.',nip,')') as name"))->get();       
        $pegawai = $pegawai->pluck('name','id');  

        toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
        Log::info("User ".Sentinel::getUser()->name." Menambahkan Sebuah Surat Tugas");
        //return view('backend.suratPerintah.pegawai',compact('data','pegawai'));
        return redirect()->route('tugas.index',"jenis_perintah=sppd");
        } catch (\Exception $e) {
        
        toast()->error(__('toast.g_create.c_gagal.g_pesan'), __('toast.g_create.c_gagal.g_label'));
        Log::error("User ".Sentinel::getUser()->name." Mengalami Eror di create Surat Tugas | error : ".$e->getMessage());
        return redirect()->back();
        }
    }

    public function pegawai($data, $pegawai)
    {
        dd($data);
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
        try {
            $surat = suratTugas::find($id);
            $id = $surat->id_sppd;
            $data = sppd::find($id);
            $penandatanganan = [];
            $penandatanganan = [1 => 'Kakanwil', 2 => 'Selain Kakanwil'];
            $angkutan = [];
            $angkutan = [1 => 'Pesawat', 2 => 'Kendaraan Pribadi', 3 => 'Kendaraan Dinas', 4 => 'Angkutan Umum'];
            $sumber_dana = [];
            $sumber_dana = [1 => 'DIPA Kanwil', 2 => 'DIPA Kementrian ATR/BPN'];
            $pengemban_anggaran = [];
            $pengemban_anggaran = [1 => 'DIPA Kanwil', 2 => 'DIPA Kementrian ATR/BPN'];
            $pegawai = pegawai::select('id',DB::RAW("concat(name,'(NIP.',nip,')') as name"))->get();       
        $pegawai = $pegawai->pluck('name','id');  
            return view('backend.suratPerintah.edit',compact('penandatanganan','pegawai','data','angkutan','pengemban_anggaran','sumber_dana'));
        } catch (\Exception $e) {
            toast()->error($e->getMessage(), 'Eror');
            return redirect()->back();
        }
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
            $data = sppd::find($id);
            $data->no_sppd = $request->no_sppd;
            $data->tanggal_pergi = $request->tanggal_pergi;
            $data->tanggal_pulang = $request->tanggal_pulang;
            $data->tujuan = $request->tujuan;
            $data->angkutan = $request->angkutan;
            $data->tempat_berangkat = $request->tempat_berangkat;
            $data->tempat_tujuan = $request->tempat_tujuan;
            $data->dibuat_di = $request->dibuat_di;
            $data->sub_bagian = $request->sub_bagian;
            $data->ttd_oleh = $request->ttd_oleh;
            $data->nip_pejabat = $request->nip_pejabat;
            $data->nama_kakanwil = $request->nama_kakanwil;
            $data->nip_kakanwil = $request->nip_kakanwil;
            $data->penandatanganan = $request->penandatanganan;
            $data->pengemban_anggaran = $request->pengemban_anggaran;
            $data->skpa = $request->skpa;
            $data->sumber_dana = $request->sumber_dana;
            
            $data->mata_anggaran = $request->mata_anggaran;
            $data->keterangan = $request->keterangan;
            $data->update();
            toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->name." Merubah Sebuah Barang");
            return redirect()->route('tugas.index',"jenis_perintah=sppd");
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
