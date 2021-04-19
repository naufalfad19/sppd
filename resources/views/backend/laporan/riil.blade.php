<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    h1 { font-family: "Bookman Old Style"; font-size: 24px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 26.4px; } 
    h3 { font-family: "Bookman Old Style"; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 15.4px; } 
    body { font-family: "Bookman Old Style"; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 20px; } blockquote { font-family: "Bookman Old Style"; font-size: 21px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 30px; } pre { font-family: "Bookman Old Style"; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 18.5714px; }
    </style>
    <title>Daftar Pengeluaran Riil</title>
</head>
<body>
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
    <br><br>
    <font size="4"><center><b>DAFTAR PENGELUARAN RIIL</b></center></font><br><br>
    <table>
        <tr>
            <td style="width:250px">Yang bertanda tangan di bawah ini</td>
            <td style="width:10px">:</td>
            <td style="width:300px"></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{$pejabat->nama_ppk}}</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>:</td>
            <td>{{$pejabat->nip_ppk}}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>Pejabat Pembuat Komitmen</td>
        </tr>
    </table>
    <br><br>
    <p>Berdasarkan Surat Perintah tanggal <?php echo date_format($data->created_at,"d-m-Y"); ?>, Nomor: {{$data->suratTugas->no_surat}}, dengan ini kami menyatakan dengan sesungguhnya bahwa :</p>
    <p>&emsp; 1. Biaya transport pegawai dan/atau biaya penginapan di bawah ini yang tidak dapat diperoleh bukti-bukti pengeluarannya, meliputi :</p>
        <table border="1" border-collapse="collapse" style="margin-left:50px;">
            <tr>
                <td style="width:30px;height:30px;"><center>No.</center></td>
                <td style="width:500px"><center>Uraian</center></td>
                <td style="width:500px"><center>Jumlah</center></td>
            </tr>
            <tr>
                <td style="text-align:center;">1</td>
                <td><?php 
                    if($surat->sppd->angkutan == 1){
                        echo "Pesawat";
                    }elseif($surat->sppd->angkutan == 2){
                        echo "Kendaraan Pribadi";
                    }elseif($surat->sppd->angkutan == 3){
                        echo "Kendaraan Dinas";
                    }elseif($surat->sppd->angkutan == 4){
                        echo "Angkutan Umum";
                    }
                    function rupiah($angka){
                        
                        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
                        return $hasil_rupiah;
                    
                    }

                    
                ?></td>
                <td style="text-align:right;"><?php echo rupiah($data->kwitansi->tiket); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><center>Jumlah</center></td>
                <td style="text-align:right;"><?php echo rupiah($data->kwitansi->tiket); ?></td>
            </tr>
        </table>
    <p>&emsp; 2. Jumlah uang tersebut pada angka 1 di atas benar-benar dikeluarkan untuk pelaksanaan perjalanan dinas dimaksud dan apabila dikemudian hari terdapat kelebihan atas pembayaran, kami bersedia untuk menyetorkan kelebihan tersebut ke Kas Negara</p>
    <br>
    <p>Demikian, pernyataan ini kami buat dengan sebenarnya, untuk dipergunakan sebagaimana mestinya.</p>

        <table style="text-align:center">
            <tr>
                <td style="width:600px">Mengetahui / Menyetujui</td>
                <td style="width:600px">Padang, <?php echo tgl_indo(date_format($data->kwitansi->created_at,'Y-m-d')) ; ?></td>
            </tr>
            <tr>
                <td>Pejabat Pembuat Komitmen</td>
                <td>Pejabat / Pegawai Negeri yang Melakukan</td>
            </tr>
            <tr>
                <td><br><br><br><br>{{$pejabat->nama_ppk}}</td>
                <td><br><br><br><br>{{$data->pegawai->name}}</td>
            </tr>
            <tr>
                <td>NIP. {{$pejabat->nip_ppk}}</td>
                <td>NIP. {{$data->pegawai->nip}}</td>
            </tr>
        </table>
        
</body>
<?php     			
            header("Content-Type: application/vnd.msword");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("content-disposition: attachment;filename=Rill $surat->no_surat.doc"); 
    ?>
</html>