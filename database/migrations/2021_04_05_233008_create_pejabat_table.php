<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePejabatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pejabat', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_kkw');
            $table->string('nip_kkw');
            $table->string('nama_kbtu');
            $table->string('nip_kbtu');
            $table->string('nama_ppk');
            $table->string('nip_ppk');
            $table->string('nama_bp');
            $table->string('nip_bp');
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
        Schema::dropIfExists('pejabat');
    }
}
