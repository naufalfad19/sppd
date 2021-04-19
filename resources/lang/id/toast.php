<?php

return [
    't_user' => [
      'u_create' => [
        'c_berhasil' => [
          'b_pesan' => 'Berhasil Menambahkan User Baru',
          'b_label' => 'Berhasil',
        ],
        'c_gagal' => [
          'g_pesan' => 'Gagal Menambahkan User Baru',
          'g_label' => 'Gagal',
        ],
      ],
      'u_update' => [
        'up_berhasil' => [
          'b_pesan' => 'Berhasil Merubah Data User',
          'b_label' => 'Berhasil',
        ],
        'up_gagal' => [
          'g_pesan' => 'Gagal Merubah Data User',
          'g_label' => 'Gagal',
        ],
      ],
      'u_delete' => [
        'd_berhasil' => [
          'b_pesan' => 'Berhasil Menghapus Data User',
          'b_label' => 'Berhasil',
        ],
        'd_gagal' => [
          'g_pesan' => 'Gagal Menghapus Data User',
          'g_label' => 'Gagal',
        ],
      ],
      'u_deactiv' => [
        'de_berhasil' => [
          'b_pesan' => 'Berhasil Deactivate User ',
          'b_label' => 'Berhasil',
        ],
        'de_gagal' => [
          'g_pesan' => 'Gagal Deactivate User ',
          'g_label' => 'Gagal',
        ],
      ],
      'u_activ' => [
        'ac_berhasil' => [
          'b_pesan' => 'Berhasil Activate User ',
          'b_label' => 'Berhasil',
        ],
        'ac_gagal' => [
          'g_pesan' => 'Gagal Activate User ',
          'g_label' => 'Gagal',
        ],
      ],
    ],
    't_role' => [
      'r_create' => [
        'c_berhasil' => [
          'b_pesan' => 'Berhasil Menambahkan Role Baru',
          'b_label' => 'Berhasil',
        ],
        'c_gagal' => [
          'g_pesan' => 'Gagal Menambahkan Role Baru',
          'g_label' => 'Gagal',
        ],
      ],
      'r_update' => [
        'up_berhasil' => [
          'b_pesan' => 'Berhasil Merubah Data Role',
          'b_label' => 'Berhasil',
        ],
        'up_gagal' => [
          'g_pesan' => 'Gagal Merubah Data Role',
          'g_label' => 'Gagal',
        ],
      ],
      'r_delete' => [
        'd_berhasil' => [
          'b_pesan' => 'Berhasil Menghapus Data Role',
          'b_label' => 'Berhasil',
        ],
        'd_gagal' => [
          'g_pesan' => 'Gagal Menghapus Data Role',
          'g_label' => 'Gagal',
        ],
      ],
    ],
    'f_download' => [
      'd_gagal' => [
        'g_pesan' => 'Gagal Mendownload File Aplikasi',
        'g_label' => 'Gagal',
      ],
    ],
    't_login' => [
      'l_gagal' => [
        'g_akun_tidak_ada' => [
          'ata_pesan' => 'Akun Anda Tidak Ditemukan, Silakan Cek Kembali.',
          'ata_label' => 'Warning',
        ],
        'g_akun_blm_aktif' => [
          'aba_pesan' => 'Akun Anda Belum Aktiv, Silakan Lihat Email Atau Hubungi Admin Untuk Aktivasi Akun',
          'aba_label' => 'Gagal',
        ],
        'g_ip_block' => [
          'ib_pesan' => 'IP Anda Untuk Sementara diblockir, dikarenakan Mencoba Masuk Ke Aplikasi Beberapa Kali',
          'ib_label' => 'Gagal',
          'ib_tunggu' => [
            'a' => 'Ip Anda Terblockir Selama',
            'b' => 'Gagal',
          ],
        ],
      ]
    ],
    't_aktivasi' => [
      'a_berhasil' => [
        'b_pesan' => 'Akun Kamu Telah Aktif',
        'b_label' => 'Activ'
      ],
      'a_gagal' => [
        'g_pesan' => 'Gagal Aktifasi Akun',
        'g_label' => 'Gagal'
      ]
    ],
    'g_create' => [
      'c_berhasil' => [
        'b_pesan' => 'Berhasil Menambahkan Data Baru',
        'b_label' => 'Berhasil',
      ],
      'c_gagal' => [
        'g_pesan' => 'Gagal Menambahkan Data Baru',
        'g_label' => 'Gagal',
      ],
    ],
    'g_update' => [
      'up_berhasil' => [
        'b_pesan' => 'Berhasil Merubah Data',
        'b_setujui' => 'Berhasil Menyetujui Permintaan',
        'b_tolak' => 'Berhasil Menolak Permintaan',
        'b_label' => 'Berhasil',
      ],
      'up_gagal' => [
        'g_pesan' => 'Gagal Merubah Data',
        'g_total' => 'Persediaan Barang Tidak Mencukupi',
        'g_label' => 'Gagal',
      ],
    ],
    'g_delete' => [
      'd_berhasil' => [
        'b_pesan' => 'Berhasil Menghapus Data',
        'b_label' => 'Berhasil',
      ],
      'd_gagal' => [
        'g_pesan' => 'Gagal Menghapus Data',
        'g_label' => 'Gagal',
      ],
    ],
];
