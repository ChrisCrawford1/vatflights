<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id()->index();
            $table->uuid('uuid');
            $table->unsignedBigInteger('callsign_id');
            $table->boolean('complete')->default(0)->index();
            $table->string('flight_rules');
            $table->string('aircraft_type')->index();
            $table->string('departure')->index();
            $table->string('arrival')->index();
            $table->string('alternate')->nullable();
            $table->text('route');
            $table->string('planned_altitude');
            $table->unsignedInteger('transponder');
            $table->timestamp('logged_in_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();

            $table->foreign('callsign_id')
                ->references('id')
                ->on('callsigns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flights');
    }
}
