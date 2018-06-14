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
            $table->string('email',100);
            $table->string('group_id');
            $table->string('password', 60);
            $table->string('address')->nullable(true)->default(null);
            $table->string('phone')->nullable(true)->default(null);
            $table->date('birthday')->nullable(true)->default(null);
            $table->string('username');
            $table->string('confirmation_code')->nullable(true)->default(null);
            $table->boolean('confirmed')->nullable(true)->default(false);
            $table->boolean('admin')->nullable(true)->default(false);
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
