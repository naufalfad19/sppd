<?php

Auth::routes(['register'=>false]);
Route::resource('regist','backend\registController');
Route::get('/','HomeController@index');

Route::group(['middleware' => ['web', 'auth', 'permission'] ], function () {

  Route::group(['namespace' => '\Arcanedev\LogViewer\Http\Controllers','prefix' => 'log-viewer'], function () {
    Route::get('/','LogViewerController@index')->name('log-viewer::logs.dashboard');
  });

  Route::get('/dashboard', 'HomeController@index')->name('home.dashboard');

  Route::resource('users','backend\UserController');
  Route::get('users','backend\UserController@index')->name('users.index');
  Route::get('users/create','backend\UserController@create')->name('users.create');
  Route::post('users', 'backend\UserController@store')->name('users.store');
  Route::get('users/{id}','backend\UserController@destroy')->name('users.destroy');
  Route::get('activ/{id}','backend\UserController@active')->name('users.activate');
  Route::get('deactiv/{id}','backend\UserController@deactivate')->name('users.deactivate');
  Route::get('user/{id}/permission','backend\UserController@permissions')->name('users.permissions');
  Route::post('user/{id}/permission', 'backend\UserController@simpan')->name('users.simpan');
  Route::post('user/ajax_all', ['uses' => 'backend\UserController@ajax_all']);

  

  Route::get('roles','backend\RoleController@index')->name('roles.index');
  Route::post('roles','backend\RoleController@store')->name('roles.add');
  Route::patch('roles/{id}','backend\RoleController@update')->name('roles.updt');
  Route::delete('roles/{id}','backend\RoleController@destroy')->name('roles.destroy');
  Route::get('roles/{id}/permission','backend\RoleController@permissions')->name('roles.permissions');
  Route::post('roles/{id}/permission', 'backend\RoleController@simpan')->name('roles.simpan');

  Route::get('surat-tugas','backend\suratTugasController@index')->name('tugas.index');
  Route::get('surat-tugas/create','backend\suratTugasController@create')->name('tugas.create');
  Route::get('surat-tugas/{id}','backend\suratTugasController@show')->name('tugas.show');
  Route::get('surat-tugas/{id}/status','backend\suratTugasController@status')->name('tugas.status');
  Route::get('surat-tugas/{id}/cetak','backend\suratTugasController@cetak')->name('tugas.cetak');
  Route::get('surat-tugas/{id}/absen','backend\suratTugasController@absen')->name('tugas.absen');
  Route::post('surat-tugas','backend\suratTugasController@store')->name('tugas.store');
  Route::get('surat-tugas/{id}/edit','backend\suratTugasController@edit')->name('tugas.edit');
  Route::patch('surat-tugas/{id}','backend\suratTugasController@update')->name('tugas.updt');
  Route::delete('surat-tugas/{id}','backend\suratTugasController@destroy')->name('tugas.destroy');

  Route::get('kwitansi','backend\kwitansiController@index')->name('kwitansi.index');
  Route::get('kwitansi/create','backend\kwitansiController@create')->name('kwitansi.create');
  Route::get('kwitansi/{id}','backend\kwitansiController@show')->name('kwitansi.show');
  Route::get('kwitansi/{id}/cetak','backend\kwitansiController@cetak')->name('kwitansi.cetak');
  Route::get('kwitansi/{id}/riil','backend\kwitansiController@riil')->name('kwitansi.riil');
  Route::post('kwitansi/{id}','backend\kwitansiController@store')->name('kwitansi.store');
  Route::get('kwitansi/{id}/edit','backend\kwitansiController@edit')->name('kwitansi.edit');
  Route::patch('kwitansi/{id}','backend\kwitansiController@update')->name('kwitansi.updt');
  Route::delete('kwitansi/{id}','backend\kwitansiController@destroy')->name('kwitansi.destroy');

  Route::post('detail-surat-tugas/{id}','backend\suratTugasDetailController@store')->name('tugasde.add');
  Route::patch('detail-surat-tugas/{id}','backend\suratTugasDetailController@update')->name('tugasde.updt');
  Route::delete('detail-surat-tugas/{id}','backend\suratTugasDetailController@destroy')->name('tugasde.destroy');

  Route::get('surat-perintah','backend\sppdController@index')->name('perintah.index');
  Route::get('surat-perintah/{id}/cetak','backend\sppdController@cetak')->name('perintah.cetak');
  Route::get('surat-perintah/{id}/lpd','backend\sppdController@lpd')->name('perintah.lpd');
  Route::get('surat-perintah/create/{id}','backend\sppdController@create')->name('perintah.create');
  Route::get('surat-perintah/pegawai/{data}/{pegawai}','backend\sppdController@pegawai')->name('perintah.pegawai');
  Route::get('surat-perintah/edit/{id}','backend\sppdController@edit')->name('perintah.edit');
  Route::post('surat-perintah/{id}','backend\sppdController@store')->name('perintah.store');
  Route::patch('surat-perintah/{id}','backend\sppdController@update')->name('perintah.updt');
  Route::delete('surat-perintah/{id}','backend\sppdController@destroy')->name('perintah.destroy');

  Route::get('barang','backend\barangController@index')->name('barang.index');
  Route::post('barang','backend\barangController@store')->name('barang.add');
  Route::patch('barang/{id}','backend\barangController@update')->name('barang.updt');
  Route::delete('barang/{id}','backend\barangController@destroy')->name('barang.destroy');

  Route::get('satuan-barang','backend\satuanBarangController@index')->name('satbar.index');
  Route::post('satuan-barang','backend\satuanBarangController@store')->name('satbar.add');
  Route::patch('satuan-barang/{id}','backend\satuanBarangController@update')->name('satbar.updt');
  Route::delete('satuan-barang/{id}','backend\satuanBarangController@destroy')->name('satbar.destroy');

  Route::get('sumber','backend\inventorisSumberController@index')->name('sumber.index');
  Route::post('sumber','backend\inventorisSumberController@store')->name('sumber.add');
  Route::patch('sumber/{id}','backend\inventorisSumberController@update')->name('sumber.updt');
  Route::delete('sumber/{id}','backend\inventorisSumberController@destroy')->name('sumber.destroy');

  Route::get('request-inventoris','backend\inventorisRequestController@index')->name('inreq.index');
  Route::get('request-inventoris/create','backend\inventorisRequestController@create')->name('inreq.create');
  Route::get('request-inventoris/{id}','backend\inventorisRequestController@show')->name('inreq.show');
  Route::get('request-inventoris/cetak/{id}','backend\inventorisRequestController@cetak');
  Route::post('request-inventoris','backend\inventorisRequestController@store')->name('inreq.store');
  Route::delete('request-inventoris/{id}','backend\inventorisRequestController@destroy')->name('inreq.destroy');
  Route::patch('request-inventoris/{id}','backend\inventorisRequestController@acc')->name('inreq.acc');
  Route::patch('request-inventoris/acc_one/{id}','backend\inventorisRequestController@acc_one')->name('inreq.acc_one');
  Route::put('request-inventoris/reject_one/{id}','backend\inventorisRequestController@reject_one')->name('inreq.reject_one');
  Route::put('request-inventoris/{id}','backend\inventorisRequestController@reject')->name('inreq.reject');

  Route::post('detail-request-inventoris/{id}','backend\inventorisRequestDetailController@store')->name('inreqde.add');
  Route::patch('detail-request-inventoris/{id}','backend\inventorisRequestDetailController@update')->name('inreqde.updt');
  Route::delete('detail-request-inventoris/{id}','backend\inventorisRequestDetailController@destroy')->name('inreqde.destroy');

  Route::get('pegawai','backend\pegawaiController@index')->name('pegawai.index');
  Route::get('pegawai/create','backend\pegawaiController@create')->name('pegawai.create');
  Route::get('pegawai/{id}','backend\pegawaiController@show')->name('pegawai.show');
  Route::post('pegawai','backend\pegawaiController@store')->name('pegawai.store');
  Route::get('pegawai/edit/{id}','backend\pegawaiController@edit')->name('pegawai.edit');
  Route::patch('pegawai/{id}','backend\pegawaiController@update')->name('pegawai.updt');
  Route::delete('pegawai/{id}','backend\pegawaiController@destroy')->name('pegawai.destroy');

  Route::get('pejabat/edit','backend\pejabatController@edit')->name('pejabat.edit');
  Route::patch('pejabat/{id}','backend\pejabatController@update')->name('pejabat.updt');

  Route::get('salurkan/create','backend\salurkanController@create')->name('salurkan.create');
  Route::post('salurkan','backend\salurkanController@create')->name('salurkan.store');

  Route::post('detail-inventoris/{id}','backend\inventorisDetailController@store')->name('inventorisDetail.add');
  Route::patch('detail-inventoris/{inventoris_id}/{id}','backend\inventorisDetailController@update')->name('inventorisDetail.updt');
  Route::delete('detail-inventoris/{inventoris_id}/{id}','backend\inventorisDetailController@destroy')->name('inventorisDetail.destroy');

  Route::post('keluar-inventoris/{id}','backend\inventorisKeluarController@store')->name('inventorisKeluar.add');
  Route::patch('keluar-inventoris/{inventoris_id}/{id}','backend\inventorisKeluarController@update')->name('inventorisKeluar.updt');
  Route::delete('keluar-inventoris/{inventoris_id}/{id}','backend\inventorisKeluarController@destroy')->name('inventorisKeluar.destroy');

  Route::get('laporan-mingguan/filter','backend\laporanController@lapmingguanfilter')->name('laporan.mingguan-filter');
  Route::get('laporan-mingguan','backend\laporanController@lapmingguanpgsql2')->name('laporan.mingguan');
  Route::get('laporan-keluar/filter','backend\laporanController@lapkeluarfilter')->name('laporan.keluar-filter');
  Route::get('laporan-keluar','backend\laporanController@lapkeluar')->name('laporan.keluar');


  //Profile
  Route::get('profile','profileController@index');
  Route::get('edit-profile','profileController@editProfile');
  Route::patch('edit-profile','profileController@updateProfile');
  Route::get('edit-password','profileController@editPassword');
  Route::patch('edit-password','profileController@updatePassword');

});

Route::group(['middleware' => ['api', 'auth'], 'prefix' => 'api' ], function () {
  Route::get('/user','backend\UserController@getData');
  Route::get('/role','backend\RoleController@getData');
  Route::get('/sumber','backend\inventorisSumberController@getData');
  Route::get('/permission','backend\RoleController@permissionGetData');

  Route::get('/pegawai','backend\pegawaiController@getData');
  Route::get('/surat-tugas','backend\suratTugasController@getData');
  Route::get('/satuan-kerja','backend\satuanKerjaController@getData');
  Route::get('/barang','backend\barangController@getData');
  Route::get('/satuan-barang','backend\satuanBarangController@getData');
  Route::get('/request-inventoris','backend\inventorisRequestController@getData');
  Route::get('/acc-inventoris/{barang_id}/{satuan_id}','backend\inventorisRequestController@accData');
  Route::get('/inventoris','backend\inventorisController@getData');

  Route::get('/select/sumber/{satker}/{barang}/{satuan}','api\selectController@sumber');
});

Route::get('img/{type}/{file_id}','fileController@image');
Route::get('verifikasi/{kode}/{username}','backend\UserController@aktivation_account');
Route::get('lang/{lang}', 'bahasaController@swap');
