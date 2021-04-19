<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use DB;
use Sentinel;
use App\Models\satuanKerja as satker;

class laporanController extends Controller
{
      public function lapmingguanfilter(Request $request)
      {
          return view('backend.laporan.filterLaporanMingguan');
      }

      public function lapkeluarfilter(Request $request)
      {
          $satker = satker::pluck('name','id');
          return view('backend.laporan.filterLaporanKeluar',compact('satker'));
      }

      //for mysql
      public function lapmingguanmysql(Request $request)
      {
          $request->validate([
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
            'jenis_laporan' => 'required'
          ]);

          try {

            $tanggal_mulai = date_format(date_create($request->tanggal_mulai),"Ymd");
            $tanggal_akhir = date_format(date_create($request->tanggal_akhir),"Ymd");

            $sqllabel = "
                SET @sqllabel = (
                  select GROUP_CONCAT(
                        CONCAT(
                            'SUM( IF(inventoris.satker_id = ', id , ',inventoris_detail.total,0) ) AS \"', REPLACE(name, ' ', '_'), '\"'
                        )
                    ) from satuan_kerja where id <> 1
                )
            ";

            $sql = "";

            if($request->jenis_laporan==1){
              $sql = "
                SET @SQL = CONCAT( 'select barang.name AS Barang, satuan_barang.name AS Satuan, inventoris_sumber.name AS Sumber, sum(if(inventoris.satker_id=1,inventoris_detail.total,0)) as Masuk, ', @sqllabel , ',
                     sum(if(inventoris_detail.status=1,inventoris_detail.total,0)) as Keluar,
                     sum(if(inventoris.satker_id=1,inventoris_detail.total,0)) - sum(if(inventoris_detail.status=1,inventoris_detail.total,0)) as Sisa from inventoris_detail
                     join inventoris_sumber on inventoris_sumber.id = inventoris_detail.sumber_id join inventoris
                     on inventoris_detail.inventoris_id = inventoris.id
                     join barang on inventoris.barang_id = barang.id join satuan_barang on inventoris.satuan_id = satuan_barang.id
                     where (DATE_FORMAT(inventoris_detail.tanggal, \"%Y%m%d\") >= $tanggal_mulai and  DATE_FORMAT(inventoris_detail.tanggal, \"%Y%m%d\") <= $tanggal_akhir)
                     and (inventoris_detail.status=1 or inventoris.satker_id=1)
                     GROUP BY barang, satuan, sumber'
                );
              ";
            }elseif($request->jenis_laporan==2){
              $sql = "
                SET @SQL = CONCAT( 'select barang.name AS Barang, satuan_barang.name AS Satuan, sum(if(inventoris.satker_id=1,inventoris_detail.total,0)) as Masuk, ', @sqllabel , ',
                     sum(if(inventoris_detail.status=1,inventoris_detail.total,0)) as Keluar,
                     sum(if(inventoris.satker_id=1,inventoris_detail.total,0)) - sum(if(inventoris_detail.status=1,inventoris_detail.total,0)) as Sisa from inventoris_detail
                     join inventoris_sumber on inventoris_sumber.id = inventoris_detail.sumber_id join inventoris
                     on inventoris_detail.inventoris_id = inventoris.id
                     join barang on inventoris.barang_id = barang.id join satuan_barang on inventoris.satuan_id = satuan_barang.id
                     where (DATE_FORMAT(inventoris_detail.tanggal, \"%Y%m%d\") >= $tanggal_mulai and  DATE_FORMAT(inventoris_detail.tanggal, \"%Y%m%d\") <= $tanggal_akhir)
                     and (inventoris_detail.status=1 or inventoris.satker_id=1)
                     GROUP BY barang, satuan'
                );
              ";
            }
            DB::statement($sqllabel);
            DB::statement($sql);
            $newSQL = DB::SELECT("Select @SQL as 'sql'");
            $newSQL = $newSQL ? $newSQL[0]->sql : "";
            $data = DB::SELECT($newSQL);
            if(!$data){
              toast()->warning('Data Pada Rentang Tanggal Tersebut Tidak Ditemukan', 'Warning');
              Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami warning saat mencetak laporan 1");
              return redirect('laporan/filter')->withInput();
            }
            $label = $data ? array_keys(get_object_vars($data[0])) : [];
            return view('backend.laporan.laporanMingguan',compact('label','data'));

          } catch (\Exception $e) {
            dd($e);
          }

      }

      //forpostgresql
      public function lapmingguanpgsql(Request $request)
      {
          $request->validate([
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
            'jenis_laporan' => 'required'
          ]);

          try {

            $tanggal_mulai = date_format(date_create($request->tanggal_mulai),"Ymd");
            $tanggal_akhir = date_format(date_create($request->tanggal_akhir),"Ymd");

            if($request->jenis_laporan==1){
              $sql = "
                with mylabel as (
                  select array_to_string(
                    array(
                     select CONCAT(
                       'SUM( CASE WHEN inventoris.satker_id = ', id , ' THEN inventoris_detail.total ELSE 0 END ) AS ', REPLACE(name, ' ', '_')
                     ) from satuan_kerja where id <> 1
                    ),', '
                  ) as inilabel
                )
                select CONCAT('select barang.name AS Barang, satuan_barang.name AS Satuan, inventoris_sumber.name AS Sumber, sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END) as Masuk, ',inilabel,', sum(CASE WHEN inventoris_detail.status=1 THEN inventoris_detail.total ELSE 0 END) as Keluar,
                sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END) - sum( CASE WHEN inventoris_detail.status=1 THEN inventoris_detail.total ELSE 0 END) as Sisa from inventoris_detail
                join inventoris_sumber on inventoris_sumber.id = inventoris_detail.sumber_id join inventoris
                on inventoris_detail.inventoris_id = inventoris.id
                join barang on inventoris.barang_id = barang.id join satuan_barang on inventoris.satuan_id = satuan_barang.id
                where (inventoris_detail.status=1 or inventoris.satker_id=1)
			  		    and (inventoris_detail.tanggal >= ',E'\'$tanggal_mulai\'',' and inventoris_detail.tanggal <= ',E'\'$tanggal_akhir\'',')
                GROUP BY barang, satuan, sumber') as sql from mylabel
              ";
            }elseif($request->jenis_laporan==2){
                $sql = "
                  with mylabel as (
                    select array_to_string(
                      array(
                       select CONCAT(
                         'SUM( CASE WHEN inventoris.satker_id = ', id , ' THEN inventoris_detail.total ELSE 0 END ) AS ', REPLACE(name, ' ', '_')
                       ) from satuan_kerja where id <> 1
                      ),', '
                    ) as inilabel
                  )
                  select CONCAT('select barang.name AS Barang, satuan_barang.name AS Satuan, sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END) as Masuk, ',inilabel,', sum(CASE WHEN inventoris_detail.status=1 THEN inventoris_detail.total ELSE 0 END) as Keluar,
                  sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END) - sum( CASE WHEN inventoris_detail.status=1 THEN inventoris_detail.total ELSE 0 END) as Sisa from inventoris_detail
                  join inventoris on inventoris_detail.inventoris_id = inventoris.id
                  join barang on inventoris.barang_id = barang.id join satuan_barang on inventoris.satuan_id = satuan_barang.id
                  where (inventoris_detail.status=1 or inventoris.satker_id=1)
  			  		    and (inventoris_detail.tanggal >= ',E'\'$tanggal_mulai\'',' and inventoris_detail.tanggal <= ',E'\'$tanggal_akhir\'',')
                  GROUP BY barang, satuan') as sql from mylabel
                ";
            }
            $newSQL = DB::SELECT($sql);
            $newSQL = $newSQL ? $newSQL[0]->sql : "";
            $data = DB::SELECT($newSQL);
            if(!$data){
              toast()->warning('Data Pada Rentang Tanggal Tersebut Tidak Ditemukan', 'Warning');
              Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami warning saat mencetak laporan 1");
              return redirect('laporan/filter')->withInput();
            }
            $label = $data ? array_keys(get_object_vars($data[0])) : [];
            return view('backend.laporan.laporanMingguan',compact('label','data'));

          } catch (\Exception $e) {
            dd($e);
          }

      }

      //forpostgresql
      public function lapmingguanpgsql2(Request $request)
      {
          $request->validate([
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
            'jenis_laporan' => 'required'
          ]);

          try {

            $tanggal_mulai = date_format(date_create($request->tanggal_mulai),"Ymd");
            $tanggal_akhir = date_format(date_create($request->tanggal_akhir),"Ymd");

            if($request->jenis_laporan==1){
              $sql = "
                with mylabel as (
                  select array_to_string(
                    array(
                     select CONCAT(
                       'SUM( CASE WHEN inventoris.satker_id = ', id , ' and inventoris_detail.tanggal >= ',E'\'$tanggal_mulai\'',' and inventoris_detail.tanggal <= ',E'\'$tanggal_akhir\'', ' THEN inventoris_detail.total ELSE 0 END ) AS ', REPLACE(name, ' ', '_')
                     ) from satuan_kerja where id <> 1
                    ),', '
                  ) as inilabel
                )
                select CONCAT('select barang.name AS Barang, satuan_barang.name AS Satuan, inventoris_sumber.name AS Sumber, (sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END) - sum(CASE WHEN inventoris_detail.status=1 and inventoris_detail.tanggal <= ',E'\'$tanggal_mulai\'',' THEN inventoris_detail.total ELSE 0 END)) as Masuk, ',inilabel,', sum(CASE WHEN inventoris_detail.status=1 and inventoris_detail.tanggal >= ',E'\'$tanggal_mulai\'',' and inventoris_detail.tanggal <= ',E'\'$tanggal_akhir\'',' THEN inventoris_detail.total ELSE 0 END) as Keluar,
                (sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END) - sum(CASE WHEN inventoris_detail.status=1 and inventoris_detail.tanggal <= ',E'\'$tanggal_mulai\'',' THEN inventoris_detail.total ELSE 0 END)) - sum(CASE WHEN inventoris_detail.status=1 and inventoris_detail.tanggal >= ',E'\'$tanggal_mulai\'',' and inventoris_detail.tanggal <= ',E'\'$tanggal_akhir\'',' THEN inventoris_detail.total ELSE 0 END) as Sisa from inventoris_detail
                join inventoris_sumber on inventoris_sumber.id = inventoris_detail.sumber_id join inventoris
                on inventoris_detail.inventoris_id = inventoris.id
                join barang on inventoris.barang_id = barang.id join satuan_barang on inventoris.satuan_id = satuan_barang.id
                where (inventoris_detail.status=1 or inventoris.satker_id=1)
                GROUP BY barang, satuan, sumber') as sql from mylabel
              ";
            }elseif($request->jenis_laporan==2){
                $sql = "
                  with mylabel as (
                    select array_to_string(
                      array(
                       select CONCAT(
                         'SUM( CASE WHEN inventoris.satker_id = ', id , ' and inventoris_detail.tanggal >= ',E'\'$tanggal_mulai\'',' and inventoris_detail.tanggal <= ',E'\'$tanggal_akhir\'', ' THEN inventoris_detail.total ELSE 0 END ) AS ', REPLACE(name, ' ', '_')
                       ) from satuan_kerja where id <> 1
                      ),', '
                    ) as inilabel
                  )
                  select CONCAT('select barang.name AS Barang, satuan_barang.name AS Satuan, (sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END) - sum(CASE WHEN inventoris_detail.status=1 and inventoris_detail.tanggal <= ',E'\'$tanggal_mulai\'',' THEN inventoris_detail.total ELSE 0 END)) as Masuk, ',inilabel,', sum(CASE WHEN inventoris_detail.status=1 and inventoris_detail.tanggal >= ',E'\'$tanggal_mulai\'',' and inventoris_detail.tanggal <= ',E'\'$tanggal_akhir\'',' THEN inventoris_detail.total ELSE 0 END) as Keluar,
                  (sum(CASE WHEN inventoris.satker_id=1 THEN inventoris_detail.total ELSE 0 END) - sum(CASE WHEN inventoris_detail.status=1 and inventoris_detail.tanggal <= ',E'\'$tanggal_mulai\'',' THEN inventoris_detail.total ELSE 0 END)) - sum(CASE WHEN inventoris_detail.status=1 and inventoris_detail.tanggal >= ',E'\'$tanggal_mulai\'',' and inventoris_detail.tanggal <= ',E'\'$tanggal_akhir\'',' THEN inventoris_detail.total ELSE 0 END) as Sisa from inventoris_detail
                  join inventoris on inventoris_detail.inventoris_id = inventoris.id
                  join barang on inventoris.barang_id = barang.id join satuan_barang on inventoris.satuan_id = satuan_barang.id
                  where (inventoris_detail.status=1 or inventoris.satker_id=1)
                  GROUP BY barang, satuan') as sql from mylabel
                ";
            }
            $newSQL = DB::SELECT($sql);
            $newSQL = $newSQL ? $newSQL[0]->sql : "";
            $data = DB::SELECT($newSQL);
            if(!$data){
              toast()->warning('Data Pada Rentang Tanggal Tersebut Tidak Ditemukan', 'Warning');
              Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami warning saat mencetak laporan 1");
              return redirect('laporan/filter')->withInput();
            }
            $label = $data ? array_keys(get_object_vars($data[0])) : [];
            return view('backend.laporan.laporanMingguan',compact('label','data'));

          } catch (\Exception $e) {
            dd($e);
          }

      }


      public function lapkeluar(Request $request)
      {
          $request->validate([
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required',
            'satker' => 'required'
          ]);

          try{
            $datas = DB::table('inventoris')
            ->join('satuan_barang','inventoris.satuan_id','=','satuan_barang.id')
            ->join('satuan_kerja','inventoris.satker_id','=','satuan_kerja.id')
            ->join('barang','inventoris.barang_id','=','barang.id')
            ->join('inventoris_detail','inventoris.id','=','inventoris_detail.inventoris_id')
            ->select('inventoris_detail.total','satuan_barang.name as nama_satuan','satuan_kerja.name as nama_satker','barang.name as nama_barang')
            ->where('inventoris.satker_id',$request->satker)
            ->where('inventoris_detail.status',1)
            ->where('inventoris_detail.tanggal','>=',$request->tanggal_awal)
            ->where('inventoris_detail.tanggal','<=',$request->tanggal_akhir)->get();
            return view('backend.laporan.laporanKeluar',compact('datas'));
          }catch (\Exception $e) {
            Log::error("User ".Sentinel::getUser()->first_name." ".Sentinel::getUser()->last_name." Mengalami Eror Cetak Laporan Keluar | error : ".$e->getMessage());
            toast()->error('Terjadi Error', 'Error');
            return redirect()->back()->withInput();
          }
      }
}
