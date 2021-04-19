<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inventoris;
use App\Models\suratTugas;
use App\Models\kwitansi;
use App\Models\inventorisDetail;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $surat_tugas = suratTugas::all();
        $dk = suratTugas::where('jenis_perintah',3)->get();
        $sppd = suratTugas::where('jenis_perintah',1)->get();
        $non_sppd = suratTugas::where('jenis_perintah',2)->get();
        $kwitansi = kwitansi::all();
       return view('backend.index',compact('surat_tugas','dk','non_sppd','kwitansi','sppd'));
    }
}
