<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('user_id');
            
            $table->string('draw_pile')->nullable();
            $table->string('discard_pile')->nullable();
            $table->string('cards_pile')->nullable();
            $table->integer('lib_board')->default(0);
            $table->integer('fasc_board')->default(0);
            $table->integer('nein_counter')->default(0);
            $table->integer('vote')->default(0);

            $table->boolean('win')->nullable();


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
        Schema::dropIfExists('rooms');
    }
}
