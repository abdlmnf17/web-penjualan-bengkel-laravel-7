<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    // protected $primaryKey = 'no_jual';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = "penjualan";
    protected $fillable=['no_jual','kd_pel','tgl','total_jual'
   ];

   public function pendapatan()
   {
    return $this->hasOne(Pendapatan::class, 'no_jual',); // Asumsikan 'no_jual' adalah foreign key di tabel pendapatan
   }
}
