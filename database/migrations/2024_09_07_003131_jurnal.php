<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Jurnal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Jurnal', function (Blueprint $table){
            $table->string('no_jurnal',20)->primary();
            $table->string('keterangan',30);
            $table->date('tgl_jurnal',8);
            $table->string('no_akun',5);
            $table->integer('debet');
            $table->integer('kredit');
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
        //
    }
}
