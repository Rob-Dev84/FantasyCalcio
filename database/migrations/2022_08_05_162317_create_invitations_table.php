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

     //Workflow: 
     //send an email that populates league_id, email, confirmed (flase) and timestamps. user_id only if invited user is already registered
     //The email contains the url based of the id invitation. This id will be hide (xxx) anyway
     //When an invited user confirmed registration, update with user_id (this makes the user in the league)
     //Now League "Admin" will see the new user in the league

     //In the future,we can display the new user in the league and let league admin confirm to let the new user in the league  
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->onDelete('cascade')->nullable()->constrained()->default(null);
            $table->foreignId('league_id')->constrained()->onDelete('cascade');
            $table->string('email');
            $table->boolean('confirmed')->nullable()->default(null);
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
        Schema::dropIfExists('invitations');
    }
};
