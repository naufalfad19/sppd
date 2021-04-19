<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailSuratTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_surat_tugas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_surat_tugas')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->integer('id_kwitansi')->unsigned();
            $table->timestamps();

            $table->foreign('id_surat_tugas')->references('id')->on('surat_tugas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('pegawai')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_kwitansi')->references('id')->on('kwitansi')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_surat_tugas');
    }
}
