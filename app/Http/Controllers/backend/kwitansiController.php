<?php
namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\suratTugas;
use App\Models\kwitansi;
use App\Models\pejabat;
use App\Models\pegawai;
use App\Models\detailSuratTugas as detail;
use App\User;
use Sentinel;
use App\Http\Controllers\DateTime;
use App\Http\Resources\suratTugasList;
use Illuminate\Support\Facades\DB;

class kwitansiController extends Controller
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
    public function store(Request $request,$id)
    {
        try{
            //dd($id);
            $kwitansi = new kwitansi;
            $kwitansi->tiket = $request->tiket;
            $kwitansi->taxi = $request->taxi;
            $kwitansi->uang_harian = $request->uang_harian;
            $kwitansi->penginapan = $request->penginapan;
            $kwitansi->uang_muka = $request->uang_muka;
            $kwitansi->save();

            $detail = detail::where('id_surat_tugas',$id)->where('id_user',$request->kwitansi_pegawai)->first();
            $detail->id_kwitansi = $kwitansi->id;
            $detail->save();

            toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->name." Menambahkan Sebuah Surat Tugas");
            return redirect()->back();
            } catch (\Exception $e) {
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
        //
    }

    public function cetak($id)
    {
        try {
            $data = detail::find($id);
            $pejabat = pejabat::find(1);
            $surat = suratTugas::where('id',$data->id_surat_tugas)->first();
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
            return view('backend.laporan.kwitansi',compact('data','pejabat','surat'));

        } catch (\Exception $e) {
            dd($e);
            Log::error("User ".Sentinel::getUser()->name."Mengalami Eror di Hapus Barang | error : ".$e->getMessage());
            toast()->error(__('Gagal Mencetak Surat Tugas'));
        }
        
    }
    public function riil($id)
    {
        try {
            $data = detail::find($id);
            $pejabat = pejabat::find(1);
            $surat = suratTugas::where('id',$data->id_surat_tugas)->first();
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
            return view('backend.laporan.riil',compact('data','pejabat','surat'));

        } catch (\Exception $e) {
            dd($e);
            Log::error("User ".Sentinel::getUser()->name."Mengalami Eror di Hapus Barang | error : ".$e->getMessage());
            toast()->error(__('Gagal Mencetak Surat Tugas'));
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
        //
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
            $detail = detail::find($id);
            $id_kwitansi = $detail->id_kwitansi;
            $detail->id_kwitansi = 0;
            $detail->save();

            $kwitansi = kwitansi::find($id_kwitansi);
            $kwitansi->delete();
            toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->name."Menghapus Sebuah Barang");

        } catch (\Exception $e) {
            Log::error("User ".Sentinel::getUser()->name."Mengalami Eror di Hapus Barang | error : ".$e->getMessage());
            toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
        }
        return redirect()->back();
    }
}
