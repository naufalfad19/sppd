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
        <div class="row">
            <div class="col-3">
                <img src="{{asset('image/BPN.png')}}" style="width:80px;height:80px;align:left">
            </div>
            <div class="col-7">
                <font size="6"><b><center>BADAN PERTANAHAN NASIONAL RI</center> </b></font>
                <font size="5"><center>KANTOR WILAYAH PROVINSI SUMATERA BARAT</center></font>
                <font size="4"><center>Jalan Kartini No. 22 Padang 25112 Telpon (0751)28279-28180</center></font>
                <font size="4"><center>Fax. (0751)28180</center></font><br>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr color="grey" nonshade>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <font size="4"><center><b><u>SURAT TUGAS</u></b></center></font>
                <font size="4"><center>Nomor 212/ST-100.1/III/2021</center></font><br>
          
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

        <div class="row">
           
            <div class="col-8">
            </div>
            <div class="col-4" style="align:right">
                    <font size="3"><center>Padang, <?php date_format($data->created_at,"d-m-Y"); ?></center></font>
                    <font size="3"><center>An. KEPALA KANTOR WILAYAH</center></font>
                    <font size="3"><center>BADAN PERTANAHAN NASIONAL</center></font>
                    <font size="3"><center>PROVINSI SUMATERA BARAT</center></font>
                    <font size="3"><center><b>Kepala Bagian Tata Usaha</b></center></font>
                    
                    <br><br><br><br>
                    <font size="3"><center><b><u>MIRA DESRITA, S.SiT</u></b></center></font>
                    <font size="3"><center><b>NIP. 197212101993032004</b></center></font>
            </div>
        </div>
        
    </div>

    <?php     			
            header("Content-Type: application/vnd.msword");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("content-disposition: attachment;filename=$data->no_surat.doc"); 
    ?>
</body>
</html>