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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            // $table->string('name', 25);
            $table->string('surname', 25);
            $table->string('role', 20);
            $table->string('team', 25);
            $table->integer('initial_value');
            $table->integer('current_value');
            $table->foreignId('league_type_id')->constrained();
            $table->boolean('active')->default(true);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('players');
    }
};
