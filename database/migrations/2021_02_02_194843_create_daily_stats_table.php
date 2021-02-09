<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_stats', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->timestamp('date')->nullable()->index();
            $table->unsignedBigInteger('max_connected_users');
            $table->string('most_popular_aircraft')->nullable()->index();
            $table->unsignedInteger('aircraft_uses')->nullable();
            $table->string('most_popular_airline')->nullable()->index();
            $table->unsignedInteger('callsign_uses')->nullable();
            $table->unsignedInteger('most_common_altitude')->nullable()->index();
            $table->string('most_popular_departure')->nullable()->index();
            $table->unsignedInteger('departure_count')->nullable();
            $table->string('most_popular_arrival')->nullable()->index();
            $table->unsignedInteger('arrival_count')->nullable();
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
        Schema::dropIfExists('daily_stats');
    }
}
