<?php

use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{

public function run()
{
    $admins = [
        ['Muhammad Iqbal Mubarak', 'admin01@gmail.com','admin','root']
    ];

    DB::table('roles')->insert([
        [
            'id'=>'1',
            'slug' 		    => 'Admin',
            'name' 			  => 'Admin',
            'permissions'  => '{"log-viewer::logs.dashboard":true,"password.request":true,"password.email":true,"password.reset":true,"home.dashboard":true,"home.part-data":true,"users.index":true,"users.create":true,"users.store":true,"users.show":true,"users.edit":true,"users.update":true,"users.destroy":true,"users.activate":true,"users.deactivate":true,"users.part-data":true,"satker.index":true,"satker.add":true,"satker.updt":true,"satker.destroy":true,"satker.all-data":true,"barang.index":true,"barang.add":true,"barang.updt":true,"barang.destroy":true,"barang.all-data":true,"satbar.index":true,"satbar.add":true,"satbar.updt":true,"satbar.destroy":true,"satbar.all-data":true,"sumber.index":true,"sumber.add":true,"sumber.updt":true,"sumber.destroy":true,"sumber.all-data":true,"inreq.index":true,"inreq.show":true,"inreq.acc_one":true,"inreq.reject_one":true,"inreq.all-data":true,"inreqde.updt":true,"inventoris.index":true,"inventoris.create":true,"inventoris.store":true,"inventoris.show":true,"inventoris.updt":true,"inventoris.destroy":true,"inventoris.all-data":true,"inventorisDetail.add":true,"inventorisDetail.updt":true,"inventorisDetail.destroy":true,"laporan.mingguan-filter":true,"laporan.mingguan":true,"laporan.keluar-filter":true,"laporan.keluar":true}'
        ],
        [
            'id'=>'2',
            'slug' 		    => 'User',
            'name' 			  => 'User',
            'permissions' => '{"password.request":true,"password.email":true,"password.reset":true,"home.dashboard":true,"home.self-data":true,"orders.confirm":true,"orders.index":true,"satker.all-data":true,}',
        ],
    ]);

    DB::table('pangkat_gol')->insert([
       
        [
            'id'=>'2',
            'pangkat' 		    => 'Pembina Utama Madya',
            'golongan' 			  => 'IVd',
        ],
        [
            'id'=>'3',
            'pangkat' 		    => 'Pembina Utama Muda',
            'golongan' 			  => 'IVc',
        ],
        [
            'id'=>'4',
            'pangkat' 		    => 'Pembina Tingkat I',
            'golongan' 			  => 'IVb',
        ],
        [
            'id'=>'5',
            'pangkat' 		    => 'Pembina',
            'golongan' 			  => 'IVa',
        ],
        [
            'id'=>'6',
            'pangkat' 		    => 'Penata Tingkat I',
            'golongan' 			  => 'IIId',
        ],
        [
            'id'=>'7',
            'pangkat' 		    => 'Penata',
            'golongan' 			  => 'IIIc',
        ],
        [
            'id'=>'8',
            'pangkat' 		    => 'Penata Muda Tingkat I',
            'golongan' 			  => 'IIIb',
        ],
        [
            'id'=>'9',
            'pangkat' 		    => 'Penata Muda',
            'golongan' 			  => 'IIIa',
        ],
        [
            'id'=>'10',
            'pangkat' 		    => 'Pengatur Tingkat I',
            'golongan' 			  => 'IId',
        ],
        [
            'id'=>'11',
            'pangkat' 		    => 'Pengatur',
            'golongan' 			  => 'IIc',
        ],
        [
            'id'=>'12',
            'pangkat' 		    => 'Pengatur Muda Tingkat I',
            'golongan' 			  => 'IIb',
        ],
        [
            'id'=>'13',
            'pangkat' 		    => 'Pengatur Muda',
            'golongan' 			  => 'IIa',
        ],
        [
            'id'=>'14',
            'pangkat' 		    => 'Juru Tingkat I',
            'golongan' 			  => 'Id',
        ],
        [
            'id'=>'15',
            'pangkat' 		    => 'Juru',
            'golongan' 			  => 'Ic',
        ],
        [
            'id'=>'16',
            'pangkat' 		    => 'Juru Muda Tingkat I',
            'golongan' 			  => 'Ib',
        ],
        [
            'id'=>'17',
            'pangkat' 		    => 'Juru Muda',
            'golongan' 			  => 'Ia',
        ],
    ]);

    DB::table('sppd')->insert([
        [
            'id'=>'1'
        ],
    ]);

    DB::table('pejabat')->insert([
        [
            'id'=>'1'
        ],
    ]);

    DB::table('kwitansi')->insert([
        [
            'id'=>'0'
        ],
    ]);
    
    foreach ($admins as $admin) {
        DB::table('users')->insert([
            [
                'name'		 => $admin[0],
                'email' 		     => $admin[1],
                'username'      => $admin[2],
                'password' 		 => bcrypt($admin[3]),
                'permissions'   => '{"password.request":true,"password.email":true,"password.reset":true,"home.dashboard":true,"users.index":true,"users.create":true,"users.store":true,"users.show":true,"users.edit":true,"users.update":true,"users.destroy":true,"users.activate":true,"users.deactivate":true,"users.permissions":true,"users.simpan":true,"roles.index":true,"roles.create":true,"roles.store":true,"roles.show":true,"roles.edit":true,"roles.update":true,"roles.destroy":true,"roles.permissions":true,"roles.simpan":true,"roles.all-data":true}',
            ]
        ]);

        $id = DB::getPdo()->lastInsertId();

        DB::table('activations')->insert([
            [
                'user_id' 		=> $id,
                'code' 			  => str_random(40),
                'completed' 	=> '1',
            ]
        ]);

        DB::table('role_users')->insert([
            [
                'user_id' 		=> $id,
                'role_id' 			  => '1'
            ]
        ]);
    }

}
}
