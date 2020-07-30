<?php

namespace App\Http\Controllers;

use App\redshift_table;
use Illuminate\Http\Request;

class CalculationController extends Controller
{

  
    //
    public function index(){
        return view('calculation');
    }

    public function store(){

        //$calculate = new redshift_table();

        redshift_table::create(request(['assigned_calc_ID', 'optical_u', 'optical_g', 'optical_r', 'optical_i', 'optical_z', 'infrared_three_six', 'infrared_four_five', 'infrared_five_eight', 'infrared_eight_zero', 'infrared_J', 'infrared_K', 'radio_one_four', 'redshift_result']));

        //$calculate->save();

        return redirect('/calculation');
    }
}
