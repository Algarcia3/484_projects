<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // pivot table for roles
        Schema::create('user_roles', function(Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            // referencing foreign key on users table
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users');

            // referencing foreign key on roles table
            $table->foreign('role_id')
                  ->references('role_id')
                  ->on('roles');

            // finally, timestamps, in case we ever wanna log actions i guess
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
        // wipe out pivot and start again
        Schema::dropIfExists('user_roles');
    }
}
