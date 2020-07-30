<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedshiftTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redshift_tables', function (Blueprint $table) {
            $table->bigIncrements('calculation_ID');
            $table->foreignId('user_ID');
            $table->string('assigned_calc_ID');
            $table->float('optical_u');
            $table->float('optical_g');
            $table->float('optical_r');
            $table->float('optical_i');
            $table->float('optical_z');
            $table->float('infrared_three_six');
            $table->float('infrared_four_five');
            $table->float('infrared_five_eight');
            $table->float('infrared_eight_zero');
            $table->float('infrared_J');
            $table->float('infrared_K');
            $table->float('radio_one_four');
            $table->float('redshift_result');
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
        Schema::dropIfExists('redshift_tables');
    }
}
