<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Form Bukti Kehadiran</title>
    <style>
    h1 { font-family: "Bookman Old Style"; font-size: 24px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 26.4px; } 
    h3 { font-family: "Bookman Old Style"; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 15.4px; } 
    body { font-family: "Bookman Old Style"; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 20px; } blockquote { font-family: "Bookman Old Style"; font-size: 21px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 30px; } pre { font-family: "Bookman Old Style"; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 18.5714px; }
    </style>
</head>
<style>
    th{
        text-align:center;
    }
</style>
<body>
<?php function hariIndo ($hariInggris) {
  switch ($hariInggris) {
    case 'Sunday':
      return 'Minggu';
    case 'Monday':
      return 'Senin';
    case 'Tuesday':
      return 'Selasa';
    case 'Wednesday':
      return 'Rabu';
    case 'Thursday':
      return 'Kamis';
    case 'Friday':
      return 'Jumat';
    case 'Saturday':
      return 'Sabtu';
    default:
      return 'hari tidak valid';
  }
}
 ?>
    <div class="container">
    <br>
        
        <div class="row">
            <div class="col-12">
                <P><center><b>FORM BUKTI KEHADIRAN</b></center></P> 
                <P><center><b>PELAKSANAAN PERJALANAN DINAS JABATAN</b></center></P> 
                <P><center><b>DALAM KOTA SAMPAI DENGAN 8 (DELAPAN) JAM</b></center></P> 
                <br>
                <table border="1" width="1200px" cellpadding="7"> 
                    <thead>
                        <th style="width:10px;">NO.</th>
                        <th style="width:250px;">PELAKSANA SPD</th>
                        <th style="width:30px;">HARI</th>
                        <th style="width:300px;">TANGGAL</th>
                        <th colspan="3">PEJABAT / PETUGAS YANG MENGESAHKAN</th>
                    </thead>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="width:80px;">NAMA</td>
                        <td style="width:80px;">JABATAN</td>
                        <td style="width:80px;">TANDA TANGAN</td>
                    </tr>
                    <tr style="text-align:center;"> 
                        <td>(1)</td>
                        <td>(2)</td>
                        <td>(3)</td>
                        <td>(4)</td>
                        <td>(5)</td>
                        <td>(6)</td>
                        <td>(7)</td>
                    </tr>
                    <?php $no =1 ; ?>
                    @foreach($data->details as $detail)
                    <tr>
                        <td>{{$no}}</td>
                        <td>{{$detail->pegawai->name}} <br> NIP.{{$detail->pegawai->nip}}</td>
                        <td><?php echo hariIndo(date('l', strtotime($data->created_at)));; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($data->created_at)) ; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php $no++ ; ?>
                    @endforeach
                </table>

                <p>Keterangan</p>
                <p>1)	Diisi nomor urut</p>
                <p>2)	Diisi nama Pelaksana SPD yang melakukan Perjalanan Dinas</p>
                <p>3)	Diisi hari Pelaksanaan Perjalanan Dinas</p>
                <p>4)	Diisi tanggal Pelaksanaan Dinas sesuai yang tercantum dalam Surat Tugas</p>
                <p>Untuk angka (3) dan (4), apabila penugasan lebi dari 1 (satu) hari, maka diisi per hari tanggal Pelaksanaan Perjalanan Dinas</p>
                <p>5)	Diisi nama pimpinan/pejabat di Tempat Tujuan Perjalanana Dinas</p>
                <p>6)	Diisi jabatan pimpinan/pejabat di Tempat Tujuan Perjalanan Dinas</p>
                <p>7)	Diisi tanda tangan pejabat sebagaimana dimaksud pada angka (5) yang ditunjuk untuk menandatangani bukti kehadiran Pelaksanaan Perjalanan Dinas</p>
            </div>
        </div>

        
    </div>
</body>
<?php     			
            header("Content-Type: application/vnd.msword");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("content-disposition: attachment;filename=Laporan.doc"); 
    ?>
</html>