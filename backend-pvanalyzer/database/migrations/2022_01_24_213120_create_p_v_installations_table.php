<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePVInstallationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_v_installations', function (Blueprint $table) {
            $table->id();                           //identyfikator
            $table->unsignedBigInteger('user_id');  //identyfikator relacji
            $table->date('start')->nullable();      //data podłączenia instalacji do sieci
            $table->float('power');                 //moc instalacji
            $table->timestamps();
            $table->foreign('user_id')              //klucz obcy relacji pomiedzy userem a instalacją
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('p_v_installations');
    }
}
