<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminPanel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role')->unique();
            $table->text('description');
        });

        Schema::create('current_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->unique(['user_id', 'role_id']);
            $table->integer('role_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
        });

        DB::table('available_roles')->insert(
            array(
                'role' => 'admin',
                'description' => 'Every permission',
            ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('current_roles');
        Schema::drop('available_roles');
    }
}
