<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');

            $table->string('room_id');
            $table->boolean('ready')->default(0);

            $table->integer('order')->default(0);
            $table->boolean('vote')->nullable();

            $table->boolean('fasc')->default(0);
            $table->boolean('hitler')->default(0);

            $table->boolean('chancellor_elected')->default(0);
            $table->boolean('chancellor')->default(0);
            $table->boolean('chancellor_last')->default(0);
            $table->boolean('president')->default(0);
            $table->boolean('president_last')->default(0);

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
        Schema::dropIfExists('players');
    }
}
