<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Laporan Perjalanan Dinas</title>
    <style>
    h1 { font-family: "Bookman Old Style"; font-size: 24px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 26.4px; } 
    h3 { font-family: "Bookman Old Style"; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 15.4px; } 
    body { font-family: "Bookman Old Style"; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 20px; } blockquote { font-family: "Bookman Old Style"; font-size: 21px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 30px; } pre { font-family: "Bookman Old Style"; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 18.5714px; }
    </style>
</head>
<body>
    <div class="container">
    <br>
        
        <div class="row">
            <div class="col-12">
                <font size="4"><center><b>Laporan <?php if($data->jenis_perintah == 1){
                    echo "Perjalanan Dinas";
                }elseif($data->jenis_perintah==2){
                    echo "Non Perjalanan Dinas";
                }else{
                    echo "Dalam Kota";
                }
                 ?> </b></center></font> <br>
                <table border="0" width="1200px" cellpadding="7"> 
                    <tr>
                        <td width="10px">I</td>
                        <td width="300px">Dasar</td>
                        <td width="600px">: {{$data->no_surat}}</td>
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
                        <td>: <i>upload foto disini</i> </td>
                        
                    </tr>
                </table>
            </div>
        </div>
        <br><br><br>
            <div style="text-align:left">
                    <p style="margin-left:320px;font-size:12px;line-height:10px;"><font>Padang, {{$data->sppd->tanggal_pulang}}</font></p>
                    <p style="margin-left:320px;font-size:12px;line-height:10px;"><font>Pegawai yang melaksanakan perjalanan dinas :</font></p>
                    <?php $no = 1 ; ?>
                    @foreach($data->details as $detail)
                    <p style="margin-left:330px;font-size:12px;line-height:10px;"><font>  {{$no}}. {{$detail->pegawai->name}}  {{$detail->pegawai->nip}}</font><br><br></p>
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