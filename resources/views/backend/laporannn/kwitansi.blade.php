<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Kwitansi</title>
</head>
<body>
    <div class="container">
    <br>
        <div class="row" style="margin-bottom:50px;">
            <div class="col-12">
                <font size="4"><b><center>RINCIAN BIAYA PERJALANAN DINAS</center> </b></font>
            </div>
        </div>

          <table border="0" width="1200px" cellpadding="7"> 
            <tr>
                <td  style="width:800px">Nomor Kwitansi</td>
                <td  style="width:10px">:</td>
                <td></td>
            </tr>
            <tr>
                <td>Lampiran SPD Nomor</td>
                <td>:</td>
                <td>{{$data->suratTugas->no_surat}}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                 <?php
                    function tgl_indo($tanggal){
                        $bulan = array (
                            1 =>   'Januari',
                            'Februari',
                            'Maret',
                            'April',
                            'Mei',
                            'Juni',
                            'Juli',
                            'Agustus',
                            'September',
                            'Oktober',
                            'November',
                            'Desember'
                        );
                        $pecahkan = explode('-', $tanggal);
                        
                        // variabel pecahkan 0 = tanggal
                        // variabel pecahkan 1 = bulan
                        // variabel pecahkan 2 = tahun
                    
                        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
                    }
                ?>
               <td>: <?php echo tgl_indo(date_format($data->suratTugas->created_at,'Y-m-d'));?></td>
            </tr>
            </table>
               

        <div class="row">
            <div class="col-12">
                <table border="1" cellpadding="7"> 
                    <tr >
                        <td  style="width:10px">No</td>
                        <td style="width:600px">PERINCIAN BIAYA</td>
                        <td style="width:600px">JUMLAH</td>
                        <td style="width:600px">KETERANGAN</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Uang Harian <br>
                            <?php 
                                $tanggal_pulang = new DateTime($data->suratTugas->sppd->tanggal_pulang);
                                $tanggal_pergi = new DateTime($data->suratTugas->sppd->tanggal_pergi);
                                $hari = $tanggal_pulang->diff($tanggal_pergi);
                                function rupiah($angka){
                                    
                                    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
                                    return $hasil_rupiah;
                                
                                }
                                
                                function penyebut($nilai) {
                                    $nilai = abs($nilai);
                                    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
                                    $temp = "";
                                    if ($nilai < 12) {
                                        $temp = " ". $huruf[$nilai];
                                    } else if ($nilai <20) {
                                        $temp = penyebut($nilai - 10). " belas";
                                    } else if ($nilai < 100) {
                                        $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
                                    } else if ($nilai < 200) {
                                        $temp = " seratus" . penyebut($nilai - 100);
                                    } else if ($nilai < 1000) {
                                        $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
                                    } else if ($nilai < 2000) {
                                        $temp = " seribu" . penyebut($nilai - 1000);
                                    } else if ($nilai < 1000000) {
                                        $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
                                    } else if ($nilai < 1000000000) {
                                        $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
                                    } else if ($nilai < 1000000000000) {
                                        $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
                                    } else if ($nilai < 1000000000000000) {
                                        $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
                                    }     
                                    return $temp;
                                }
                            
                                function terbilang($nilai) {
                                    if($nilai<0) {
                                        $hasil = "minus ". trim(penyebut($nilai));
                                    } else {
                                        $hasil = trim(penyebut($nilai));
                                    }     		
                                    return $hasil;
                                }
                            ?>
                                    ({{$hari->d}} Hari x {{rupiah($data->kwitansi->uang_harian)}})
                        </td>
                        <td> <br> {{rupiah($hari->d * $data->kwitansi->uang_harian)}}</td>
                        <td></td>
                    </tr>
                    <tr>
                       
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Transport <br>- Tiket <br>- Taxi</td>
                        <td><br>{{rupiah($data->kwitansi->tiket)}} <br>{{rupiah($data->kwitansi->taxi)}}</td>
                        <td></td>
                        
                    </tr>
                    
                    <tr style="height:100px;">
                        <td>3</td>
                        <td>Penginapan</td>
                        <td>{{rupiah($data->kwitansi->penginapan)}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>JUMLAH :</td>
                        <td>{{rupiah(($hari->d * $data->kwitansi->uang_harian) + $data->kwitansi->tiket + $data->kwitansi->taxi + $data->kwitansi->penginapan)}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4" bgcolor='#DCDCDC'> Terbilang : {{terbilang(($hari->d * $data->kwitansi->uang_harian) + $data->kwitansi->tiket + $data->kwitansi->taxi + $data->kwitansi->penginapan)}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <br><br><br>
        <table  border="0"width="2000px"cellpadding="7">
            <tr>
                <td style="width:500px"></td>
                <td >{{$data->suratTugas->sppd->tempat_berangkat}}, <?php echo tgl_indo(date_format($data->suratTugas->created_at,'Y-m-d'));?></td>
            </tr>
            <tr>
                <td>Telah dibayar sejumlah</td>
                <td>Telah menerima uang sebesar</td>
            </tr>
            <tr>
                <td>Rp. ,-</td>
                <td>Rp. ,-</td>
            </tr>
            <tr>
                <td>Bendaharawan Pengeluaran,</td>
                <td>Yang Menerima,</td>
            </tr>
            <tr>
                <td><br><br><b>(<u>-</u>)</b></td>
                <td><br><br><b>(<u>{{$data->pegawai->name}}</u>)</b></td>
            </tr>
            <tr>
                <td><b></b>NIP. -</td>
                <td><b>NIP. {{$data->pegawai->nip}}</b></td>
            </tr>
        </table>
        <hr color="grey" nonshade>
        
        <font size="4"><b><center>PERHITUNGAN SPD RAMPUNG</center> </b></font>
        <table border="0" cellpadding="7">
            <tr>
                <td style="width:500px">Ditetapkan sejumlah</td>
                <td>: {{rupiah(($hari->d * $data->kwitansi->uang_harian) + $data->kwitansi->tiket + $data->kwitansi->taxi + $data->kwitansi->penginapan)}}</td>
            </tr>
            <tr>
                <td>Yang telah dibayar semula</td>
                <td>: {{rupiah($data->kwitansi->uang_muka)}}</td>
            </tr>
            <tr>
                <td>Sisa kurang/lebih</td>
                <td>: {{rupiah(($hari->d * $data->kwitansi->uang_harian) + $data->kwitansi->tiket + $data->kwitansi->taxi + $data->kwitansi->penginapan - $data->kwitansi->uang_muka)}}</td>
            </tr>
            <tr>
                <td></td>
                <td>Pejabat Pembuat Komitmen,</td>
            </tr>
            <tr>
                <td></td>
                <td><br><br><b>(<u>-</u>)</b></td>
            </tr>
            <tr>
                <td></td>
                <td><b>NIP. -</b></td>
            </tr>
        </table>
        
    </div>
</body>
    <?php     			
            header("Content-Type: application/vnd.msword");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("content-disposition: attachment;filename=$data->id_kwitansi.doc"); 
    ?>
</html>