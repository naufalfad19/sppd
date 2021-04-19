<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_tugas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sppd')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->string('no_surat')->nullable();
            $table->text('menimbang_a');
            $table->text('menimbang_b');
            $table->text('dasar');
            $table->text('tujuan');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('jenis_perintah');
            $table->tinyInteger('kop_surat');
            $table->tinyInteger('ttd');
            $table->timestamps();

            $table->foreign('id_sppd')->references('id')->on('sppd')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat_tugas');
    }
}
