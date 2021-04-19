<!DOCTYPE html>
<html lang="en" class="app" itemscope itemtype="http://schema.org/Article">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>
<body>
  <span style="font-family:'comic sans ms','sans-serif'">
    <div style="text-align:center">
      <h2>Verifikasi Email</h2>
    </div>
    Akun Anda Telah Terdaftar Sebagai User di <a href="{{url('/')}}">Aplikasi Kami</a>, Silakan Klick Verifikasi di Bawah untuk Aktivasi Akun Anda.
    <br><br>
    Username : {{$data->username}}
    <br>
    Email : {{$data->email}}
    <br>
    password : {{$data->password}}
    <br><br>
    <div style="text-align:center">
      >>> <a href="{{url('verifikasi/'.$data->kode.'/'.$data->username)}}">Verifikasi</a> <<<
    </div>
    <br><br>
    DINKES KOTA PADANG
  </span>
</body>
</html>
