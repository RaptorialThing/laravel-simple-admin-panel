<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminRolesToUserTable extends Migration
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
            $table->integer('user_id')->references('id')->on('users');
            $table->integer('user_role')->references('id')->on('available_roles');
        });

        DB::table('available_roles')->insert(
        array(
            'role' => 'admin',
            'description' => 'Every permission',
        ));
        DB::table('available_roles')->insert(
        array(
            'role' => 'none',
            'description' => 'Default role',
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
