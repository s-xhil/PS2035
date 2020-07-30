<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class redshift_table extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'assigned_calc_ID', 'optical_u', 'optical_g', 'optical_r', 'optical_i', 'optical_z', 'infrared_three_six', 'infrared_four_five', 'infrared_five_eight', 'infrared_eight_zero', 'infrared_J', 'infrared_K', 'radio_one_four',

    ];
}
