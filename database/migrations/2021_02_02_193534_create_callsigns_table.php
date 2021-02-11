<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallsignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('callsigns', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('airline_id');
            $table->string('callsign')->unique()->index();
            $table->timestamps();
        });

        Schema::table('callsigns', function (Blueprint $table) {
            $table->foreign('airline_id')
                ->references('id')
                ->on('airlines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('callsigns');
    }
}
