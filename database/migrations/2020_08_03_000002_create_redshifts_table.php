<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedshiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redshifts', function (Blueprint $table) {
            $table->increments('calculation_id');
            $table->string('assigned_calc_id');
            $table->double('optical_u',16,8);
            $table->double('optical_g', 16, 8);
            $table->double('optical_r', 16, 8);
            $table->double('optical_i', 16, 8);
            $table->double('optical_z', 16, 8);
            $table->double('infrared_three_six', 16, 8);
            $table->double('infrared_four_five', 16, 8);
            $table->double('infrared_five_eight', 16, 8);
            $table->double('infrared_eight_zero', 16, 8);
            $table->double('infrared_J', 16, 8);
            $table->double('infrared_K', 16, 8);
            $table->double('radio_one_four', 16, 8);
            /*$table->float('redshift_result');*/
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id', 'redshifts_ibfk_1')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redshifts');
    }
}
