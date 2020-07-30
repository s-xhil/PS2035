<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class calculation_table extends Model
{
    //
   	 protected $primaryKey = 'calculation_ID';
     protected $fillable = [

      'galaxy_ID', 'method_ID' ,'real_Calculation_ID', 'redshift_result',

    ];
}
