<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\inventorisRequest as inreq;
use App\Models\inventorisRequestDetail as inreqde;
use App\Models\inventorisDetail as inde;
use App\Models\barang;
use App\Models\inventorisSumber as sumber;
use App\Models\inventoris;
use App\Models\satuanBarang;
use App\Http\Resources\inventorisRequestList as inreqlist;
use Illuminate\Support\Facades\DB;
use Sentinel;

class inventorisRequestController extends Controller
{
      public function index()
      {
          try {
            return view('backend.inventorisRequest.index');
          } catch (\Exception $e) {
              toast()->error($e->getMessage(), 'Eror');
              return redirect()->back();
          }
      }

      public function acc_one(Request $request, $id)
      {
        try {
          $inreqde = inreqde::find($id);

          $masuk = DB::table('inventoris')
          ->join('inventoris_detail','inventoris.id','=','inventoris_detail.inventoris_id')
          ->select('inventoris_detail.total')
          ->where('satker_id',1)
          ->where('barang_id',$inreqde->barang_id)
          ->where('inventoris_detail.sumber_id',$request->sumber)
          ->where('satuan_id',$inreqde->satuan_id)->get();

          $keluar = DB::table('inventoris')
          ->join('inventoris_detail','inventoris.id','=','inventoris_detail.inventoris_id')
          ->select('inventoris_detail.total')
          ->where('barang_id',$inreqde->barang_id)
          ->where('inventoris_detail.sumber_id',$request->sumber)
          ->where('inventoris_detail.status',1)
          ->where('satuan_id',$inreqde->satuan_id)->get();

          $sum = $masuk->sum('total') - $keluar->sum('total');


          if($inreqde->total <= $sum)
          {
          $inreqde->status = 1;
          $inreqde->save();
          $inv = inreq::find($inreqde->inventoris_request_id);
          try{
            inventoris::create([
              'satker_id' => $inv->satker_id,
              'barang_id' => $inreqde->barang_id,
              'satuan_id'=>$inreqde->satuan_id,]);
            $old = inventoris::where('satker_id',$inv->satker_id)
            ->where('barang_id',$inreqde->barang_id)
            ->where('satuan_id',$inreqde->satuan_id)
            ->first();
            try{
              inde::create([
                'inventoris_id' => $old->id,
                'sumber_id' => $request->sumber,
                'tanggal' => now(),
                'status' => 1,
                'total' => $inreqde->total,]);
            }
            catch(\Exception $e){
              $tanggal = date('Y-m-d');
              $sample = inde::where('inventoris_id',$old->id)
              ->where('sumber_id',$request->sumber)
              ->where('status',1)
              ->where('tanggal',$tanggal)
              ->first();
                $new = $sample->total + $inreqde->total;
                $sample->total = $new;
                $sample->save();
            }
          }catch (\Exception $e) {
            $old = inventoris::where('satker_id',$inv->satker_id)
            ->where('barang_id',$inreqde->barang_id)
            ->where('satuan_id',$inreqde->satuan_id)
            ->first();
            try{
              inde::create([
                'inventoris_id' => $old->id,
                'sumber_id' => $request->sumber,
                'status' => 1,
                'tanggal' => now(),
                'total' => $inreqde->total,]);
            }
            catch(\Exception $e){
              $tanggal = date('Y-m-d');
              $sample = inde::where('inventoris_id',$old->id)
              ->where('status',1)
              ->where('sumber_id',$request->sumber)
              ->where('tanggal',$tanggal)
              ->first();
                $new = $sample->total + $inreqde->total;
                $sample->total = $new;
                $sample->save();
            }
          }

          $details = DB::table('inventoris_request_detail')
          ->where('inventoris_request_id',$inv->id)->get();
          $status[0] = 0;
          $i = 0;
          $x = 1;
          $y = 0;
          $z = 0;
          foreach($details as $detail)
          {
            if($detail->status == 0)
            {
              $status[$i] = 0;
              $i++;
            }
            elseif($detail->status == 1)
            {
              $status[$i] = 1;
              $i++;
            }
            elseif($detail->status == 2)
            {
              $status[$i] = 2;
              $i++;
            }

          }

          for($n=0; $n<$i; $n++)
          {
            if($status[$n]==0){
              $x=0;
            }
            elseif($status[$n]==1){
              $y=1;
            }
            elseif($status[$n]==2){
              $z=2;
            }
          }
          if($x==0){
            $stat = 0;
          }
          elseif($y==1 && $x==1){
            $stat = 1;
          }
          else{
            $stat = 2;
          }
          $inv->status = $stat;
          $inv->save();

          toast()->success(__('toast.g_update.up_berhasil.b_setujui'), __('toast.g_update.up_berhasil.b_label'));
          Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menyetujui Permintaan Barang");
          return redirect()->route('inreq.show',[$inv->id]);
        }
        else{
          toast()->error(__('toast.g_update.up_gagal.g_total'), __('toast.g_update.up_gagal.g_label'));
          return redirect()->back();
        }
        } catch (\Exception $e) {
          toast()->error($e->getMessage(), 'Eror');
          return redirect()->back();
        }
      }

      public function acc(Request $request, $id)
      {
        try {
          $user = Sentinel::getUser()->satker->id;
          $details = DB::table('inventoris_request_detail')
          ->where('inventoris_request_id',$id)->get();

          $i = 0;
          foreach($details as $detail)
          {
            $barang_id[$i] = $detail->barang_id;
            $satuan_id[$i] = $detail->satuan_id;
            $total[$i] = $detail->total;
            $id_inde[$i] = $detail->id;
            $i++;
          }

            $request = inreq::find($id);
            $satker_id = $request->satker_id;
            $satker = DB::table('satuan_kerja')
            ->where('id',$satker_id)->first();
            $name = $satker->name;
            $sumber = DB::table('inventoris_sumber')
            ->where('name',$name)->first();
            
            $sumber = $sumber->id;

            for ($y=0; $y<$i ; $y++) {

              $inventoris = DB::table('inventoris')
              ->where('barang_id',$barang_id[$y])
              ->where('satuan_id',$satuan_id[$y])
              ->where('satker_id',$user)->first();
              $inventoris = $inventoris->id;

              try{
              inde::create([
                'inventoris_id' => $inventoris,
                'sumber_id' => $sumber,
                'tanggal' => now(),
                'total' => $total[$y],]);
              }
              catch (\Exception $e) {
                $tanggal = date('Y-m-d');
                $sample = inde::where('inventoris_id',$inventoris)
                ->where('sumber_id',$sumber)
                ->where('tanggal',$tanggal)
                ->first();

                $new = $sample->total + $total[$y];
                $sample->total = $new;
                $sample->save();
              }

              $inreqde = DB::table('inventoris_request_detail')
              ->where('inventoris_request_id',$id)
              ->update([
                'status' => 1
              ]);

              $inreq = DB::table('inventoris_request')
              ->where('id',$id)
              ->update([
                'status' => 1
              ]);
  
            }
            toast()->success(__('toast.g_update.up_berhasil.b_setujui'), __('toast.g_update.up_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menyetujui Permintaan Barang");
            return redirect()->route('inreq.index');
        }catch (\Exception $e) {
          toast()->error($e->getMessage(), 'Eror');
          return redirect()->back();
        }
      }


      public function reject(Request $request, $id)
      {
          try {
            $inreq = inreq::find($id);
            $inreq->status = 2;
            $inreq->save();

            $inreqde = inreqde::where('inventoris_request_id',$id)->where('status',1)->get();

            foreach ($inreqde as $data) {
                $inven = inventoris::join('inventoris_detail','inventoris.id','=','inventoris_detail.inventoris_id')
                ->where('inventoris.satuan_id',$data->satuan_id)->where('inventoris.barang_id',$data->barang_id)
                ->where('inventoris.satker_id',$data->inventoris->satker_id)->where('inventoris_detail.sumber_id',1)
                ->where('inventoris_detail.total',$data->total)->first();
                $inven->delete();
            }

            $inreqde = DB::table('inventoris_request_detail')
            ->where('inventoris_request_id',$id)
            ->update([
              'status' => 2,
              'pesan' => $request->pesan
            ]);
            toast()->success(__('toast.g_update.up_berhasil.b_tolak'), __('toast.g_update.up_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menolak Permintaan Barang");
            return redirect()->back();
          } catch (\Exception $e) {
              toast()->error($e->getMessage(), 'Eror');
              return redirect()->back();
          }
      }

      public function reject_one(Request $request, $id)
      {
          try {
            $inreqde = inreqde::find($id);
            $inreqde->status = 2;
            $inreqde->pesan = $request->pesan;
            $inreqde->save();
            $inv = inreq::find($inreqde->inventoris_request_id);
            $details = DB::table('inventoris_request_detail')
            ->where('inventoris_request_id',$inv->id)->get();
            $status[0] = 0;
            $i = 0;
            $x = 1;
            $y = 0;
            $z = 0;
            foreach($details as $detail)
            {
              if($detail->status == 0)
              {
                $status[$i] = 0;
                $i++;
              }
              elseif($detail->status == 1)
              {
                $status[$i] = 1;
                $i++;
              }
              elseif($detail->status == 2)
              {
                $status[$i] = 2;
                $i++;
              }

            }

            for($n=0; $n<$i; $n++)
            {
              if($status[$n]==0){
                $x=0;
              }
              elseif($status[$n]==1){
                $y=1;
              }
              elseif($status[$n]==2){
                $z=2;
              }
            }
            if($x==0){
              $stat = 0;
            }
            elseif($y==1 && $x==1){
              $stat = 1;
            }
            else{
              $stat = 2;
            }
            $inv->status = $stat;
            $inv->save();
            toast()->success(__('toast.g_update.up_berhasil.b_tolak'), __('toast.g_update.up_berhasil.b_label'));
            Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menolak Permintaan Barang");
            return redirect()->route('inreq.show',[$inv->id]);
          } catch (\Exception $e) {
              toast()->error($e->getMessage(), 'Eror');
              return redirect()->back();
          }
      }



      public function create()
      {
          try {
            $barang = barang::pluck('name','id');
            $satuan = satuanBarang::pluck('name','id');
            return view('backend.inventorisRequest.create',compact('barang','satuan'));
          } catch (\Exception $e) {
              toast()->error($e->getMessage(), 'Eror');
              return redirect()->back();
          }
      }

      public function store(Request $request)
      {
          $request->validate([
              'barang' => 'required|array',
              'satuan' => 'required|array',
              'total' => 'required|array'
          ]);

          try {
              $date = date("Y-m-d");
              $inreq = new inreq();
              $inreq->satker_id = Sentinel::getUser()->satker_id;
              $inreq->tanggal = $date;
              $inreq->save();

              if($inreq->id){
                for ($i=0; $i < count($request->barang); $i++) {
                    $old = inreqde::where('inventoris_request_id',$inreq->id)
                                  ->where('barang_id',$request->barang[$i])
                                  ->where('satuan_id',$request->satuan[$i])
                                  ->first();

                    if($old){
                        $old->total = $old->total + $request->total[$i];
                        $old->update();
                    }else{
                        $inreqde = new inreqde();
                        $inreqde->inventoris_request_id = $inreq->id;
                        $inreqde->barang_id = $request->barang[$i];
                        $inreqde->satuan_id = $request->satuan[$i];
                        $inreqde->total = $request->total[$i];
                        $inreqde->save();
                    }

                }
              }

              toast()->success(__('toast.g_create.c_berhasil.b_pesan'), __('toast.g_create.c_berhasil.b_label'));
              Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menambahkan Sebuah Request Inventoris");
              return redirect('request-inventoris?status=proses');
          } catch (\Exception $e) {
              Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di create Request Inventoris | error : ".$e->getMessage());
              toast()->error(__('toast.g_create.c_gagal.g_pesan'), __('toast.g_create.c_gagal.g_label'));
              return redirect()->back();
          }
      }

      public function show($id)
      {
          try {
              $data = inreq::find($id);
              if(Sentinel::getUser()->hasAccess(['inreq.self-data'])){
                $data = inreq::where('id',$id)->where('satker_id',Sentinel::getUser()->satker_id)->first();
                if(!$data){
                  toast()->error('Data Not Found', 'Eror');
                  return redirect()->back();
                }
              }
              // dd($data);
              $barang = barang::pluck('name','id');
              $sumber = sumber::select('inventoris_sumber.id','inventoris_sumber.name',DB::RAW("sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END)-sum(CASE WHEN inventoris_detail.status=1 THEN inventoris_detail.total ELSE 0 END) as total"))
              ->leftjoin('inventoris_detail','inventoris_sumber.id','=','inventoris_detail.sumber_id')->leftjoin('inventoris','inventoris_detail.inventoris_id','=','inventoris.id')
              ->where('inventoris_sumber.id','<>',1)->groupby('inventoris_sumber.id')->orderby(DB::RAW("sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END)-sum(CASE WHEN inventoris_detail.status=1 THEN inventoris_detail.total ELSE 0 END)"),'desc')->get();

              $satuan = satuanBarang::pluck('name','id');
              return view('backend.inventorisRequest.show',compact('data','barang','satuan','sumber'));
          } catch (\Exception $e) {
              Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Show Detail Request | error : ".$e->getMessage());
              toast()->error('Terjadi Error', 'Eror');
              return redirect()->back();
          }
      }

      public function destroy($id)
      {
          try {
              $data = inreq::find($id);
              if(Sentinel::getUser()->hasAccess(['inreq.self-data'])){
                $data = inreq::where('id',$id)->where('satker_id',Sentinel::getUser()->satker_id)->first();
                if(!$data){
                  toast()->error('Data Not Found', 'Eror');
                  return redirect()->back();
                }
              }
              $data->delete();
              toast()->success(__('toast.g_delete.d_berhasil.b_pesan'), __('toast.g_delete.d_berhasil.b_label'));
              Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Menghapus Sebuah Request Inventoris");
          } catch (\Exception $e) {
              Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Hapus Request Inventoris | error : ".$e->getMessage());
              toast()->error(__('toast.g_delete.d_gagal.g_pesan'), __('toast.g_delete.d_gagal.g_label'));
          }
          return redirect('request-inventoris?status=proses');
      }

      public function accData(Request $request, $barang_id, $satuan_id)
      {

          //2 role(all, self)
          $data = [];
          //?data=all&status=

            $data = inventoris::select('inventoris_sumber.id','inventoris_sumber.name as sumber_name','barang.name as barang_name','satuan_barang.name as satuan_name',DB::RAW("sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END)-sum(CASE WHEN inventoris_detail.status=1 THEN inventoris_detail.total ELSE 0 END) as total"))
            ->join('inventoris_detail','inventoris.id','=','inventoris_detail.inventoris_id')
            ->join('barang','inventoris.barang_id','=','barang.id')
            ->join('satuan_barang','inventoris.satuan_id','=','satuan_barang.id')
            ->join('inventoris_sumber','inventoris_detail.sumber_id','=','inventoris_sumber.id')
            ->where('inventoris_sumber.id','<>',1)
            ->where('inventoris.barang_id',$barang_id)
            ->where('inventoris.satuan_id',$satuan_id)
            ->where(function ($query){
              $query->where('inventoris.satker_id',1)->orwhere('inventoris_detail.status',1);
            })
            ->groupby('barang.name')
            ->groupby('satuan_barang.name')
            ->groupby('inventoris.barang_id')
            ->groupby('inventoris_sumber.id')
            ->orderby('barang.name','asc')->get();
        if($request->data=="id"){
            $data = inventoris::select('inventoris_sumber.id','inventoris_sumber.name as sumber_name','barang.name as barang_name','satuan_barang.name as satuan_name',DB::RAW("sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END)-sum(CASE WHEN inventoris_detail.status=1 THEN inventoris_detail.total ELSE 0 END) as total"))
            ->join('inventoris_detail','inventoris.id','=','inventoris_detail.inventoris_id')
            ->join('barang','inventoris.barang_id','=','barang.id')
            ->join('satuan_barang','inventoris.satuan_id','=','satuan_barang.id')
            ->join('inventoris_sumber','inventoris_detail.sumber_id','=','inventoris_sumber.id')
            ->where('inventoris_sumber.id','<>',1)
            ->where('inventoris.id',$request->id)
            ->groupby('barang.name')
            ->groupby('satuan_barang.name')
            ->groupby('inventoris.barang_id')
            ->groupby('inventoris_sumber.id')
            ->orderby('barang.name','asc')->get();
          }

          return response()->json($data);
      }

      public function getData(Request $request)
      {
          //2 role(all, self)
          $data = [];
          //?data=all&status=
          if($request->data=="all"){
            $data = inreq::select('inventoris_request.*');
            if(Sentinel::getUser()->hasAccess(['inreq.self-data'])){
              $data = $data->where('satker_id',Sentinel::getUser()->satker_id);
            }elseif(Sentinel::getUser()->hasAccess(['inreq.all-data'])){
              $data->where('status',$request->status);
            }
            $data = $data->orderby('tanggal','desc')->orderby('created_at','desc')->get();
          }
          //?data=&id=
          elseif($request->data=="id"){
            $data = inreq::find($request->id);
            if(Sentinel::getUser()->hasAccess(['inreq.self-data'])){
              $data = inreq::where('satker_id',Sentinel::getUser()->satker_id)->where('id',$request->id)->first();
            }
          }
          if($data){
            return response()->json(inreqlist::collection($data));
          }
          return response()->json($data);
      }

      public function cetak($id)
      {
          try {
            $data = inreq::find($id);
            if(!Sentinel::getUser()->hasAccess('inreq.all-data')){
              $data = inreq::where('id',$id)->where('satker_id',Sentinel::getUser()->satker_id)->first();
            }
            if($data->status!=1){
              toast()->success('Request Belum Bisa Dicetak', 'Warning');
              Log::info("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Gagal Mencetak Request");
              return redirect()->route('inreq.show',$id);
            }

            return view('backend.inventorisRequest.surat',compact('data'));
          } catch (\Exception $e) {
              dd($e);
              Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror di Hapus Request Inventoris | error : ".$e->getMessage());
              toast()->error('Terjadi Error', 'Error');
              return redirect()->route('inreq.show',$id);
          }

      }
}
