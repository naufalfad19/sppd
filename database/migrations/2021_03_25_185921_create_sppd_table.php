<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSppdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sppd', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_sppd')->nullable()->unique();
            $table->date('tanggal_pergi')->nullable();
            $table->date('tanggal_pulang')->nullable();
            $table->text('tujuan')->nullable();
            $table->tinyInteger('angkutan')->nullable();
            $table->string('tempat_berangkat')->nullable();
            $table->string('tempat_tujuan')->nullable();
            $table->string('dibuat_di')->nullable();
            $table->string('sub_bagian')->nullable();
            $table->string('ttd_oleh')->nullable();
            $table->string('nip_pejabat')->nullable();
            $table->string('nip_kakanwil')->nullable();
            $table->string('nama_kakanwil')->nullable();
            $table->string('pengemban_anggaran')->nullable();
            $table->string('mata_anggaran')->nullable();
            $table->text('keterangan')->nullable();
            $table->tinyInteger('penandatanganan')->nullable();
            $table->tinyInteger('skpa')->nullable();
            $table->tinyInteger('sumber_dana')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sppd');
    }
}
