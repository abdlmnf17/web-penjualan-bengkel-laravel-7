<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Laporan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('laporan', function (Blueprint $table){
            $table->string('no_jurnal',20);
            $table->date('tgl_jurnal',8);
            $table->string('no_akun',5);
            $table->integer('debet');
            $table->integer('kredit');
      
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
