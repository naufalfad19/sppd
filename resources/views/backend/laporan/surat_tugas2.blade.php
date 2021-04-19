<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Surat Tugas</title>
    <style>
    h1 { font-family: "Bookman Old Style"; font-size: 24px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 26.4px; } 
    h3 { font-family: "Bookman Old Style"; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 15.4px; } 
    body { font-family: "Bookman Old Style"; font-size: 15px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 20px; } blockquote { font-family: "Bookman Old Style"; font-size: 21px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 30px; } pre { font-family: "Bookman Old Style"; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 18.5714px; }
    </style>
</head>
<body>
    <div class="container">
    <br>
        
        <div class="row">
            <div class="col-12">
                <font size="4"><center><b><u>SURAT TUGAS</u></b></center></font>
                <font size="4"><center><?php echo $data->no_surat ; ?></center></font><br>
          
                <table border="0" width="1200px" cellpadding="7"> 
                    <tr>
                        <td width="300px">Menimbang</td>
                        <td width="5px">:</td>
                        <td width="900px">a. <?php echo nl2br($data->menimbang_a); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>:</td>
                        <td>b. <?php echo nl2br($data->menimbang_b); ?></td>
                    </tr>
                    <tr>
                        <td>Dasar</td>
                        <td>:</td>
                        <td><?php echo nl2br($data->dasar); ?></td>

                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><center>MEMBERI TUGAS</center></td>
                        
                    </tr>
                    <?php $no = 1 ; ?>
                    <?php $no = 1 ; ?>
                    @foreach($data->details as $detail)
                    <tr>
                        <td>@if($no==1)Kepada @endif</td>
                        <td>:</td>
                        <td >{{$no}}. {{$detail->pegawai->name}} NIP. {{$detail->pegawai->nip}} Jabatan {{$detail->pegawai->jabatan}}</td>
                        <?php $no++ ; ?>
                    </tr>
                    @endforeach

                    <tr>
                        <td>Untuk</td>
                        <td>:</td>
                        <td><?php echo nl2br($data->tujuan); ?></td>
                       
                    </tr>
                </table>
            </div>
        </div>
        <br><br><br>

        
        <p style="margin-left:350px;text-align:center;font-size:15px;line-height:10px;">Padang, <?php echo date_format($data->created_at,"d-m-Y"); ?></p>
                    <p style="margin-left:350px;text-align:center;font-size:15px;line-height:10px;">KEPALA KANTOR WILAYAH</p>
                    <p style="margin-left:350px;text-align:center;font-size:15px;line-height:10px;">BADAN PERTANAHAN NASIONAL</p>
                    <p style="margin-left:350px;text-align:center;font-size:15px;line-height:10px;">PROVINSI SUMATERA BARAT</p>
                     <br><br><br><br>
                    <p style="margin-left:350px;text-align:center;font-size:15px;line-height:10px;"><?php if($data->ttd == 1){
                        echo $pejabat->nama_kkw;
                    }else{echo $pejabat->nama_kbtu;} ?></p>
                    <p style="margin-left:350px;text-align:center;font-size:15px;line-height:10px;">NIP. <?php if($data->ttd == 1){
                        echo $pejabat->nip_kkw;
                    }else{echo $pejabat->nip_kbtu;} ?></p>
       
        
    </div>
    <?php     	
    $no_surat = $data->no_surat;		
            header("Content-Type: application/vnd.msword");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("content-disposition: attachment;filename=$data->no_surat.doc");  
    ?>
</body>
</html>