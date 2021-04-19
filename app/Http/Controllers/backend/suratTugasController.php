<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\suratTugas;
use App\Models\kwitansi;
use App\Models\pegawai;
use App\Models\pejabat;
use App\Models\detailSuratTugas as detail;
use App\User;
use Sentinel;
use App\Http\Controllers\DateTime;
use App\Http\Resources\suratTugasList;
use Illuminate\Support\Facades\DB;

class suratTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $datas = suratTugas::all();
            return view('backend.suratTugas.index', compact('datas'));
        } catch (\Exception $e) {
            toast()->error($e->getMessage(), 'Eror');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $no_surat = suratTugas::count() + 1;
            $bulan = array(
                '01' => 'I',
                '02' => 'II',
                '03' => 'III',
                '04' => 'IV',
                '05' => 'V',
                '06' => 'VI',
                '07' => 'VII',
                '08' => 'VIII',
                '09' => 'IX',
                '10' => 'X',
                '11' => 'XI',
                '12' => 'XII',
            );
            $diff = new \DateTime('NOW');
            $bulan = $bulan[date('m')];
            $no_surat = $no_surat."/ST_13.100/".$bulan."/".$diff->format('Y'); 
            $jenis_perintah = [];
            $jenis_perintah = [1 => 'Perjalanan Dinas', 2 => 'Non Perjalanan Dinas', 3 => 'Dalam Kota'];
            $pegawai = pegawai::select('id',DB::RAW("concat(name,'(NIP.',nip,')') as name"))->get();       
            $id_user = Sentinel::getUser()->name;  
            return view('backend.suratTugas.create',compact('jenis_perintah','id_user','no_surat'));
        } catch (\Exception $e) {
            toast()->error($e->getMessage(), 'Eror');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
        $data = new suratTugas;
        $data->id_sppd = 1;
        $data->menimbang_a = $request->menimbang_a;
        $data->menimbang_b = $request->menimbang_b;
        $data->dasar = $request->dasar;
        $data->tujuan = $request->tujuan;
        $data->id_user = Sentinel::getUser()->id;
        $data->jenis_perintah = $request->jenis_perintah;
        $data->kop_surat = $request->kop_surat;
        $data->ttd = $request->ttd;
        $data->save();

        if($data->jenis_perintah == 1){
            $jenis_perintah = 'sppd';
        }
        elseif($data->jenis_perintah == 1){
            $jenis_perintah = 'non_sppd';
        }
        elseif($data->jenis_perintah == 2){
            $jenis_perintah = 'dalam_kota';
        }


        $update = suratTugas::find($data->id);
        $bulan = array(
                '01' => 'I',
                '02' => 'II',
                '03' => 'III',
                '04' => 'IV',
                '05' => 'V',
                '06' => 'VI',
                '07' => 'VII',
                '08' => 'VIII',
                '09' => 'IX',
                '10' => 'X',
                '11' => 'XI',
                '12' => 'XII',
        );
        $diff = new \DateTime('NOW');
        $bulan = $bulan[date('m')];
        $update->no_surat = $data->id."/ST_13.100/".$bulan."/".$diff->format('Y');
        $update->update();

        $data = suratTugas::find($data->id);

        toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
        Log::info("User ".Sentinel::getUser()->name." Menambahkan Sebuah Surat Tugas");
        //return redirect()->route('tugas.index',"jenis_perintah=$jenis_perintah");
        $pegawai = pegawai::select('id',DB::RAW("concat(name,'(NIP.',nip,')') as name"))->get();       
        $pegawai = $pegawai->pluck('name','id');  
        return view('backend.suratTugas.pegawai',compact('data','pegawai'));
        
        } catch (\Exception $e) {
        dd($e);
        toast()->error(__('toast.g_create.c_gagal.g_pesan'), __('toast.g_create.c_gagal.g_label'));
        Log::error("User ".Sentinel::getUser()->name." Mengalami Eror di create Surat Tugas | error : ".$e->getMessage());
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
        try {
            $data = suratTugas::find($id);
            if($data->status >= 2){
                $kwitansi = detail::where('id_surat_tugas',$id)->where('id_kwitansi','>',0)->get();
                $kwitansi_pegawai = DB::table('detail_surat_tugas')->select('pegawai.name', 'pegawai.id as id_pegawai','id_user')->join('pegawai', 'detail_surat_tugas.id_user', '=', 'pegawai.id')
                ->where('id_surat_tugas',$id)->pluck('name','id_pegawai');
                $pegawai = pegawai::select('id',DB::RAW("concat(name,'(NIP.',nip,')') as name"))->get();       
                $pegawai = $pegawai->pluck('name','id');  
                return view('backend.suratTugas.show',compact('data','pegawai','kwitansi','kwitansi_pegawai'));
            }else{
                toast()->error('Surat Tugas Belum Terlaksana');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            dd($e);
            Log::error("User ".Sentinel::getUser()->name." Mengalami Eror di Show Detail Request | error : ".$e->getMessage());
            toast()->error('Terjadi Error', 'Eror');
            return redirect()->back();
        }
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
            $data = suratTugas::find($id);
            $bulan = array(
                '01' => 'I',
                '02' => 'II',
                '03' => 'III',
                '04' => 'IV',
                '05' => 'V',
                '06' => 'VI',
                '07' => 'VII',
                '08' => 'VIII',
                '09' => 'IX',
                '10' => 'X',
                '11' => 'XI',
                '12' => 'XII',
            );
            $diff = new \DateTime('NOW');
            $bulan = $bulan[date('m')];
            $no_surat = $data->id."/ST_13.100/".$bulan."/".$diff->format('Y'); 
            $jenis_perintah = [];
            $jenis_perintah = [1 => 'Perjalanan Dinas', 2 => 'Non Perjalanan Dinas', 3 => 'Dalam Kota'];
            
            $pegawai = pegawai::select('id',DB::RAW("concat(name,'(NIP.',nip,')') as name"))->get();       
            $id_user = Sentinel::getUser()->name;  
            return view('backend.suratTugas.edit',compact('data','id_user','jenis_perintah','no_surat'));
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
            
            $data = suratTugas::find($id);
            $data->menimbang_a = $request->menimbang_a;
            $data->menimbang_b = $request->menimbang_b;
            $data->dasar = $request->dasar;
            $data->tujuan = $request->tujuan;
            $data->id_user = Sentinel::getUser()->id;
            $data->jenis_perintah = $request->jenis_perintah;
            $data->kop_surat = $request->kop_surat;
            $data->ttd = $request->ttd;
            $data->save();
            if($data->jenis_perintah == 1){
                $jenis_perintah = 'sppd';
            }
            elseif($data->jenis_perintah == 1){
                $jenis_perintah = 'non_sppd';
            }
            elseif($data->jenis_perintah == 2){
                $jenis_perintah = 'dalam_kota';
            }
            toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->name." Merubah Sebuah Barang");
            $pegawai = pegawai::select('id',DB::RAW("concat(name,'(NIP.',nip,')') as name"))->get();       
            $pegawai = $pegawai->pluck('name','id');  
            return view('backend.suratTugas.pegawai',compact('data','pegawai'));
        } catch (\Exception $e) {
            Log::error("User ".Sentinel::getUser()->name." Mengalami Eror di Edit Barang | error : ".$e->getMessage());
            toast()->error(__('toast.g_update.up_gagal.g_pesan'), __('toast.g_update.up_gagal.g_label'));
            return redirect()->back();
        }
    }

    public function status($id)
    {
        try {
            
            $data = suratTugas::find($id);
            if($data->sppd->id>1 && $data->jenis_perintah == 1){
            $data->status = $data->status + 1;
            $data->save();
            if($data->jenis_perintah == 1){
                $jenis_perintah = 'sppd';
            }
            elseif($data->jenis_perintah == 1){
                $jenis_perintah = 'non_sppd';
            }
            elseif($data->jenis_perintah == 2){
                $jenis_perintah = 'dalam_kota';
            }
            toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->name." Merubah Sebuah Barang");
            return redirect()->route('tugas.index',"jenis_perintah=$jenis_perintah");
            }elseif($data->jenis_perintah > 1){
            $data->status = $data->status + 1;
            $data->save();
            if($data->jenis_perintah == 1){
                $jenis_perintah = 'sppd';
            }
            elseif($data->jenis_perintah == 2){
                $jenis_perintah = 'non_sppd';
            }
            elseif($data->jenis_perintah == 3){
                $jenis_perintah = 'dalam_kota';
            }
            toast()->success(__('toast.g_update.up_berhasil.b_pesan'), __('toast.g_update.up_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->name." Merubah Sebuah Barang");
            return redirect()->route('tugas.index',"jenis_perintah=$jenis_perintah");
            }else{
                toast()->error('Isi Form Surat Tugas Terlebih Dahulu');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            dd($e);
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
            $data = suratTugas::find($id);
            $data->delete();
            toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->name."Menghapus Sebuah Barang");

        } catch (\Exception $e) {
            Log::error("User ".Sentinel::getUser()->name."Mengalami Eror di Hapus Barang | error : ".$e->getMessage());
            toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
        }
        return redirect()->back();
    }

    public function cetak($id)
    {
        try {
            $data = suratTugas::find($id);
            $details = detail::where('id_surat_tugas',$id);
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
            if($data->kop_surat == 1){
                return view('backend.laporan.surat_tugas',compact('data','details','pejabat'));
            }else{
                return view('backend.laporan.surat_tugas2',compact('data','details','pejabat'));
            }

        } catch (\Exception $e) {
            dd($e);
            Log::error("User ".Sentinel::getUser()->name."Mengalami Eror di Hapus Barang | error : ".$e->getMessage());
            toast()->error(__('Gagal Mencetak Surat Tugas'));
        }
        
    }

    public function absen($id)
    {
        try {
            $data = suratTugas::find($id);
            $details = detail::where('id_surat_tugas',$id);
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
            return view('backend.laporan.bukti_kehadiran',compact('data','details'));

        } catch (\Exception $e) {
            dd($e);
            Log::error("User ".Sentinel::getUser()->name."Mengalami Eror di Hapus Barang | error : ".$e->getMessage());
            toast()->error(__('Gagal Mencetak Surat Tugas'));
        }
        
    }

    public function getData(Request $request)
    {
        //2 role(all, self)
        $data = [];
        //?data=all&status=
        if($request->data=="all"){
            $data = suratTugas::select('surat_tugas.*');
            if(Sentinel::getUser()->hasAccess(['tugas.self-data'])){
                $data = $data->where('id_user',Sentinel::getUser()->id)->where('jenis_perintah',$request->jenis_perintah);
            }elseif($request->jenis_perintah > 0 && Sentinel::getUser()->hasAccess(['tugas.all-data'])){
                $data->where('jenis_perintah',$request->jenis_perintah);
            }
            $data = $data->orderBy('id','desc')->get();
        }
        //?data=&id=
        elseif($request->data=="id"){
            $data = suratTugas::find($request->id);
            if(Sentinel::getUser()->hasAccess(['tugas.self-data'])){
                $data = suratTugas::where('id_user',Sentinel::getUser()->user_id)->where('id',$request->id)->first();
            }
        }
        if($data){
            return response()->json(suratTugasList::collection($data));
        }
        return response()->json($data);
    }
}
