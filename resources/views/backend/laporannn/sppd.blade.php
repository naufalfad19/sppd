<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Surat Perjalanan Dinas</title>
</head>
<?php function tgl_indo($tanggal){
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
} ?>
<body>
    @foreach($data->details as $detail)
    <div class="container">
    <br>
        <div class="row">
            <table>
                <tr>
                    <td style="text-align:right;width: 350px;"><img src="{{asset('image/BPN.png')}}" style="width:80px;height:80px;align:left"></td>
                    <td style="text-align:center;width: 1000px;"><p><b><center>BADAN PERTANAHAN NASIONAL</center> </b></p>   
                        <p><b><center> KANTOR WILAYAH PROVINSI SUMATERA BARAT</center></b></p>
                    </td>
                </tr>
            </table>
            <div class="col-3">
                <table>
                    <tr>
                        <td>Lembar ke</td>
                        <td>:</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>Kode No</td>
                        <td>:</td>
                        <td>SPPDBNSP</td>
                    </tr>
                    <?php $bulan = array(
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
                    $bulan = $bulan[date('m')]; ?>
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td><?php echo $data->sppd->no_sppd."/SPPD_13.100/".$bulan."/".$diff->format('Y'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            <p><b><center>SURAT PERJALANAN DINAS (SPD)</center> </b></p> 
                <table border="1" width="1100px" cellpadding="7"> 
                    <tr>
                        <td width="40px" style="text-align:center">1</td>
                        <td width="500px">Pejabat Pembuat Komitmen</td>
                        <td colspan="2" width="300px"><b> {{$pejabat->ppk}}</b></td>
                    </tr>
                    <tr>
                        <td style="text-align:center">2</td>
                        
                        <td>Nama / NIP Pegawai yang melaksanakan perjalanan dinas</td>
                        <td colspan="2"><b>{{$detail->pegawai->name}} &emsp; &emsp; &emsp; NIP.{{$detail->pegawai->nip}}</b></td>                  
                    </tr>
                    <tr>
                        <td style="text-align:center">3</td>
                        <td>a. Pangkat dan golongan <br> b. Jabatan/ Instansi <br> c. Tingkat Biaya Perjalanan Dinas</td>
                        <td colspan="2">a. {{$detail->pegawai->pangkat->pangkat}} / {{$detail->pegawai->pangkat->golongan}} <br>b. {{$detail->pegawai->jabatan}} <br>c. C</td>
                       
                    </tr>
                    <tr>
                        <td style="text-align:center">4</td>
                        <td>Maksud perjalanan dinas</td>
                        <td colspan="2">{{$data->sppd->tujuan}}</td>
                        
                    </tr>
                    <tr>
                        <td style="text-align:center">5</td>
                        <td>Alat angkutan yang dipergunakan</td>
                        <td colspan="2">
                            <?php if($data->sppd->angkutan==1){
                                echo "Pesawat";
                            }elseif($data->sppd->angkutan==2){
                                echo "Kendaraan Pribadi";
                            }elseif($data->sppd->angkutan==3){
                                echo "Kendaraan Dinas";
                            }elseif($data->sppd->angkutan==4){
                                echo "Angkutan Umum";
                            }
                            
                            ?>
                        </td>
                    
                    </tr>
                    <tr>
                        <td style="text-align:center">6</td>
                        <td>a. Tempat berangkat <br>b. Tempat Tujuan</td>
                        <td colspan="2">a. {{$data->sppd->tempat_tujuan}} <br>b. {{$data->sppd->tempat_berangkat}} </td>
                   
                    </tr>
                    <tr>
                        <td style="text-align:center">7</td>
                        <td>a. Lamanya Perjalanan Dinas <br>b. Tanggal berangkat <br>c. Tanggal harus kembali/tiba di tempat baru</td>
                        <td colspan="2">a. <?php 
                        $tanggal_pulang = new DateTime($data->sppd->tanggal_pulang);
                        $tanggal_pergi = new DateTime($data->sppd->tanggal_pergi);
                        $diff =$tanggal_pulang->diff($tanggal_pergi); echo $diff->d; ?> Hari <br>b. <?php echo tgl_indo($data->sppd->tanggal_pergi) ; ?> <br>c. <?php echo tgl_indo($data->sppd->tanggal_pulang) ; ?> </td>
                      
                    </tr>
                    <tr>
                        <td style="text-align:center">8</td>
                        <td>Pengikut : &emsp; &emsp; &emsp; Nama </td>
                        <td>Umur/Tgl. Lahir</td>
                        <td>Keterangan</td>
                    </tr>
                    <tr>
                        <td style="text-align:center"></td>
                        <td>1. </td>
                        <td>Tahun 
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align:center">9</td>
                        <td>Pembebanan Anggaran <br>a. Instansi <br>b. Mata Anggaran</td>
                        <td colspan="2"><br>a. <?php if($data->sppd->pengemban_anggaran == 1){echo "DIPA Kanwil";}else{echo "DIPA Kementrian ATR/BPN";} ?><br>b. {{$data->sppd->mata_anggaran}}</td>
                       
                    </tr>
                    <tr>
                        <td style="text-align:center">10</td>
                        <td>Keterangan lain-lain</td>
                        <td colspan="2">SURAT TUGAS <br>a. {{$data->no_surat}} <br>b. Tanggal <?php echo tgl_indo(date('Y-m-d', strtotime($data->created_at))) ; ?></td>
                       
                    </tr>
                </table>
            </div>
        </div>
        <br><br><br><br>
        <div class="row">
            <div class="col-8">
                <p>Ket: Coret Yang Tidak Perlu</p>
            </div>
            <div class="col-4" style="align:right">
                    <table>
                        <tr>
                            <td>Dikeluarkan di &emsp;&emsp;&emsp;</td>
                            <td>:</td>
                            <td>{{$data->dibuat_di}}</td>
                        </tr>
                        <tr>
                            <td>Pada tanggal &emsp;&emsp;&emsp;</td>
                            <td>:</td>
                            <td><?php echo tgl_indo(date('Y-m-d', strtotime($data->sppd->created_at))) ; ?></td>
                        </tr>
                    </table>
                    <hr color="black" nonshade>
                    <p>Pejabat Pembuat Komitmen</p>
                    <br><br><br>
                    <p><b>(<u>{{$pejabat->nama_ppk}}</u>)</b></p>
                    <p><b>NIP. {{$pejabat->nip_pkk}}</b></p>
            </div>
        </div>
        
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="container">
        <table border="1"width="1100px" cellpadding="7">
            <tr>
                <td style="width:60px; text-align:center">I</td>
                <td style="width:500px;"></td>
                <td style="width:540px;">
                    <div class="row">
                        <div class="col-3">
                            <p>Berangkat dari</p>
                            <p></p>
                            <p>Pada Tanggal</p>
                            <p>Ke </p>
                        </div>
                        <div class="col-6">
                            <p>: {{$data->sppd->tempat_berangkat}}</p>
                            <p> (tempat kedudukan)</p>
                            <p><?php echo tgl_indo(date('Y-m-d', strtotime($data->sppd->tanggal_pergi))) ; ?></p>
                            <p>Kota Padang Panjang</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" style="text-align:center">
                            <p>An. KEPALA KANTOR WILAYAH BADAN PERTANAHAN NASIONAL</p>
                            <p>PROVINSI SUMATERA BARAT</p>
                            <p><b>Kepala Bagian Tata Usaha</b></p>
                            <br>
                            <p><b><u>{{$pejabat->nama_kbtu}}</u></b></p>
                            <p><b>NIP. {{$pejabat->nip_kbtu}}</b></p>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>II</td>
                <td>
                    <div class="row">
                        <div class="col-4">
                            <p>Tiba di</p>
                            <p>Pada Tanggal</p>
                        </div>
                        <div class="col-8">
                            <p>: {{$data->sppd->tempat_tujuan}}</p>
                            <p>: <?php echo tgl_indo(date('Y-m-d', strtotime($data->sppd->tanggal_pergi))) ; ?></p>
                        </div>
                    </div>                
                </td>
                <td>
                    <div class="row">
                        <div class="col-3">
                            <p>Berangkat dari</p>
                            <p>Ke </p>
                            <p>Pada Tanggal</p>
                        </div>
                        <div class="col-6">
                            <p>: {{$data->sppd->tempat_berangkat}}</p>
                            <p>:</p>
                            <p>: <?php echo tgl_indo(date('Y-m-d', strtotime($data->sppd->tanggal_pergi))) ; ?></p>
                        </div>
                    </div>   
                </td>
            </tr>
            <tr>
                <td>III</td>
                <td>
                    <div class="row">
                        <div class="col-4">
                            <p>Tiba di</p>
                            <p>Pada Tanggal</p>
                        </div>
                        <div class="col-8">
                            <p>: </p>
                            <p>: </p>
                        </div>
                    </div>                
                </td>
                <td>
                    <div class="row">
                        <div class="col-3">
                            <p>Berangkat dari</p>
                            <p>Ke </p>
                            <p>Pada Tanggal</p>
                        </div>
                        <div class="col-6">
                            <p>: </p>
                            <p>:</p>
                            <p>: </p>
                        </div>
                    </div>   
                </td>
            </tr>
            <tr>
                <td>IV</td>
                <td>
                    <div class="row">
                        <div class="col-4">
                            <p>Tiba di</p>
                            <p>Pada Tanggal</p>
                        </div>
                        <div class="col-8">
                            <p>:</p>
                            <p>:</p>
                        </div>
                    </div>  
                </td>
                <td>
                    <div class="row">
                        <div class="col-3">
                            <p>Berangkat dari</p>
                            <p>Ke </p>
                            <p>Pada Tanggal</p>
                        </div>
                        <div class="col-6">
                            <p>:</p>
                            <p>:</p>
                            <p>:</p>
                        </div>
                    </div> 
                </td>
            </tr>
            <tr>
                <td>V</td>
                <td>
                    <div class="row">
                        <div class="col-4">
                            <p>Tiba Kembali di</p>
                            <p></p>
                            <p>Pada Tanggal</p>
                        </div>
                        <div class="col-8">
                            <p>: Padang</p>
                            <p>(tempat kedudukan)</p>
                            <p>:</p>
                            <br><br>
                            <p>Pejabat Pembuat Komitmen</p> <br><br>
                            <p><b><u>{{$pejabat->nama_ppk}}</u></b></p>
                            <p><b>NIP.{{$pejabat->nip_ppk}}</b></p>
                        </div>
                    </div> 
                </td>
                <td>
                    <div class="row">
                        <div class="col-8">
                            <p>Telah diperiksa dengan keterangan bahwa perjalanan tersebut di atas
                            benar dilakukan atas perintahnya dan semata - mata untuk kepentingan
                            jabatan dalam waktu yang sesingkat - singkatnya</p>
                        </div>
                        <div class="col-4">
                            <p style="margin-top:100px">Pejabat Pembuat Komitmen</p> <br><br>
                            <p><b><u>({{$pejabat->nama_ppk}})</u></b></p>
                            <p><b>NIP.{{$pejabat->nip_ppk}}</b></p>
                        </div>
                    </div> 
                </td>
            </tr>
            <tr>
                <td>VI</td>
                <td>
                    Catatan lain-lain 
                </td>
                <td></td>
            </tr>
            <tr>
                <td>VII</td>
                <td colspan="2"> Perhatian : <br>
                Pejabat yang berwenang menerbitkan SPPD Pegawai yang melakukan perjalanan dinas, para pejabat yang <br>
                mengesahkan tanggal berangkat/tiba serta bendaharawan bertanggung jawab berdasarkan peraturan - peraturan <br>
                Keuangan Negara apabila negara menderita rugi akibat kesalahan, kelalaian dan kealpaannya </td>
             
            </tr>
        
        
        </table>
    
    </div>
    @endforeach
</body>
    
</html>