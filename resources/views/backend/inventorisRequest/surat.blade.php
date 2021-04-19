<html>
  <head>
  <title>KOP SURAT</title>
  </head>
  <body>
    <div class="col-md-12">
      <div class="form-group">
        <center>
          <h2> KOP SURAT </h2>
        </center>
        <br><br>
        <hr color="black";size="100px";width="100%">
        <div class="col-md-12" style="text-align:center;float:right;margin-right:20px">
            <p>Padang, {{date('d F Y')}}</p>
        </div>
        <br><br>
        <div class="col-md-12" style="float:left;margin-left:20px">
          <table class="col-md-6" style="margin:5px 50px 30px 0px">
            <tbody>
                <tr>
                    <td>No Surat</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td>:</td>
                    <td>Permintaan Barang</td>
                </tr>
            </tbody>
          </table>
          <p>Kepada Yth : <br> <b>Dinas Kesehatan Kota Padang</b><br>Kantor : Jl. Bgd. Aziz Chan By Pass Km 15, <br>Aie Pacah, <br>Kota Padang</p>
          <p >Dengan Hormat,</p>
          <p>Sehubungan dengan adanya kebutuhan barang di {{$data->satker->name}}, melalui surat ini kami memohon bantuan <b>Dinas Kesehatan Kota Padang</b>
          untuk memenuhi permintaan barang dengan rincian sebagai berikut :</p>
          <table border="2px solid black" cellpadding="5" class="col-md-12" style="margin:5px 50px 30px 50px;; border-collapse: collapse;">
              <tr>
                  <td>Nomor</td>
                  <td>Nama Barang</td>
                  <td>Satuan Barang</td>
                  <td>Total Barang</td>
              </tr>
              <?php $no = 0; ?>
              @foreach($data->details as $detail)
                <tr>
                    <td style="text-align:center">{{++$no}}</td>
                    <td>{{$detail->barang->name}}</td>
                    <td>{{$detail->satuan->name}}</td>
                    <td style="text-align:center">{{$detail->total}}</td>
                </tr>
              @endforeach
          </table>
          <p>Demikian surat permohonan ini kami sampaikan, semoga <b>Dinas Kesehatan Kota Padang</b> dapat memenuhi permintaan barang di atas. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>

        </div>
        <div class="col-md-12" style="text-align:center;float:right;margin-right:20px">
            <p>Padang, {{date('d F Y')}}</p>
            <p>Kepala {{$data->satker->name}}</p>
            <br><br><br>
            <p>...........................</p>
            </div>
            </div>
    </div>
        </div>
        <div class="card-body">
        </div>
    </div>
    <script type="text/javascript">
      window.print();
    </script>
  </body>
</html>
