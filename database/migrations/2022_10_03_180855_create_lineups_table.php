<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fixture_id')->contrained();
            $table->foreignId('team_id')->contrained()->onDelete('cascade');
            $table->foreignId('player_id')->contrained()->onDelete('cascade');

            //0 (false) bench, 1 (true) on pitch, NULL out of the match
            $table->boolean('player_status')->nullable();
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
        Schema::dropIfExists('lineups');
    }
};
