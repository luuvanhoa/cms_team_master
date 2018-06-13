<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('email',100)->unique();
            $table->string('group_id')->references('id')->on('group');
            $table->string('password', 60);
            $table->string('address');
            $table->string('phone');
            $table->date('birthday');
            $table->string('username')->unique();
            $table->string('confirmation_code');
            $table->boolean('confirmed')->default(false);
            $table->boolean('admin')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
