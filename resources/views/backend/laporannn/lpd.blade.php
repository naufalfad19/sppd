<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Laporan Perjalanan Dinas</title>
</head>
<body>
    <div class="container">
    <br>
        
        <div class="row">
            <div class="col-12">
                <font size="4"><center><b>Laporan Perjalanan Dinas</b></center></font> <br>
                <table border="0" width="1200px" cellpadding="7"> 
                    <tr>
                        <td width="10px">I</td>
                        <td width="300px">Dasar</td>
                        <td width="600px">: {{$data->dasar}}</td>
                    </tr>
                    <tr>
                        <td>II.</td>
                        <td>Tujuan</td>
                        <td>: {{$data->tujuan}}</td>
                    </tr>
                    <tr>
                        <td>III.</td>
                        <td>Hasil</td>
                        <td>:</td>
                       
                    </tr>
                    <tr>
                        <td>IV.</td>
                        <td>Eviden</td>
                        <td>:</td>
                        
                    </tr>
                </table>
            </div>
        </div>
        <br><br><br>
            <div style="text-align:right">
                    <font size="3">Padang,{{$data->sppd->tanggal_pulang}}</font><br>
                    <font size="3">Pegawai yang melaksanakan perjalanan dinas :</font><br>
                    <?php $no = 1 ; ?>
                    @foreach($data->details as $detail)
                    <font size="3">{{$no}}. {{$detail->pegawai->name}}  {{$detail->pegawai->nip}}</font><br>
                    <?php $no++ ; ?>
                    @endforeach
            </div>
        
        
    </div>

    <?php     			
            header("Content-Type: application/vnd.msword");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("content-disposition: attachment;filename=LAPORAN PERJALANAN DINAS.doc"); 
    ?>
</body>
</html>