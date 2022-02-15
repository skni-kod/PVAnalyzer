<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounterReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counter_readings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('p_v_installation_id');
            $table->date('date');
            $table->float('active_energy_consumed');
            $table->float('reactive_energy_consumed');
            $table->float('energy_to_recover');
            $table->float('balance');
            $table->timestamps();
            $table->foreign('p_v_installation_id')
                ->references('id')
                ->on('p_v_installations')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counter_readings');
    }
}
