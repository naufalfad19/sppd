<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\suratTugas;
use App\Models\kwitansi;
use App\Models\detailSuratTugas as detail;
use App\User;
use Sentinel;
use App\Http\Controllers\DateTime;
use App\Http\Resources\suratTugasList;
use Illuminate\Support\Facades\DB;

class detailController extends Controller
{
    public function store(Request $request, $id)
    {
        dd($id);
        $kwitansi = new kwitansi;
        $kwitansi->save();

        $detail = new detail;
        $detail->id_surat_tugas = $id;
        $detail->id_user = $request->pegawai;
        $detail->id_kwitansi = $kwitansi->id;
        $detail->save();
    }
}
