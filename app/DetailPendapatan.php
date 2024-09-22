<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPendapatan extends Model
{
   
   protected $primaryKey = 'no_pen';
   public $incrementing = false;
   protected $keyType = 'string';
   public $timestamps = false;
   protected $table = "DetailPendapatan";
    protected $fillable = [
        'no_pen', 'kd_brg', 'kd_pel', 'qty_pen', 'hrg_jasa', 'sub_pen'
    ];
}
