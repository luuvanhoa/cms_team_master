<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->integer('group_acp');
            $table->integer('privilege_id')->references('id')->on('privilege');
            $table->integer('ordering');
            $table->dateTime('created_by')->references('id')->on('users');
            $table->dateTime('created_time');
            $table->dateTime('modified_by')->references('id')->on('users');
            $table->dateTime('modified_time');
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
        Schema::dropIfExists('group');
    }
}
