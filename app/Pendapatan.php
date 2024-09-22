<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    protected $primaryKey = 'no_pen';
   public $incrementing = false;
   protected $keyType = 'string';
   public $timestamps = false;
   protected $table = "Pendapatan";
    protected $fillable = [
        'no_pen', 'kd_pel', 'tgl_pen', 'no_faktur', 'total_pen', 'no_jual'
    ];
    
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'no_jual');
    }
}
