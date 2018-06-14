<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_admin', function (Blueprint $table) {
            //Info
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('catecode');
            $table->boolean('status')->nullable(true)->default(1); // 1 show, 0 hidden
            $table->string('description')->nullable(true)->default(null);
            $table->dateTime('created_time');
            $table->dateTime('modified_time')->nullable(true)->default(null);

            // nested
            $table->string('fullcate_parent')->nullable(true)->default(null);
            $table->integer('parent')->nullable(true)->default(0);
            $table->integer('left');
            $table->integer('right');
            $table->integer('level')->nullable(true)->default(0);

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
        Schema::dropIfExists('menu_admin');
    }
}
