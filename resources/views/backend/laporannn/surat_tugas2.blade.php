<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Surat Tugas</title>
</head>
<body>
    <div class="container">
    <br>
            <font size="4"><center><b><u>SURAT TUGAS</u></b></center></font>
            <font size="4"><center><?php echo $data->no_surat ; ?></center></font><br>
          
                <table border="0" width="1200px" cellpadding="7"> 
                    <tr>
                        <td style="width:100px">Menimbang</td>
                        <td style="width:5px">:</td>
                        <td style="width:900px">a. <?php echo nl2br($data->menimbang_a); ?></td>
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
           
        <br><br><br>
        <table>
            <tr>
                <td style="width:350px"></td>
                <td>
                    <font size="3" style="text-align:center">Padang, <?php date_format($data->created_at,"d-m-Y"); ?></font><br>
                    <font size="3" style="text-align:center">An. KEPALA KANTOR WILAYAH</font><br>
                    <font size="3" style="text-align:center">BADAN PERTANAHAN NASIONAL</font><br>
                    <font size="3" style="text-align:center">PROVINSI SUMATERA BARAT</font><br>
                    <font size="3" style="text-align:center">Kepala Bagian Tata Usaha</font><br><br><br><br>
                    <font size="3" style="text-align:center"><u>MIRA DESRITA, S.SiT</u></font><br>
                    <font size="3" style="text-align:center">NIP. 197212101993032004</font><br>
                    
                </td>
            </tr>
        </table>
        
    </div>
    <?php     			
            header("Content-Type: application/vnd.msword");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("content-disposition: attachment;filename=$data->no_surat.doc"); 
    ?>
</body>
</html>