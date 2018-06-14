<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('sku')->nullable(true)->default(null);
            $table->integer('cate_original')->nullable(true)->default(null);
            $table->string('cate_list')->nullable(true)->default(null);
            $table->string('name');
            $table->string('name_show')->nullable(true)->default(null);
            $table->string('price')->nullable(true)->default(null);
            $table->string('discount_price')->nullable(true)->default(null);
            $table->string('total_discount')->nullable(true)->default(null);
            $table->string('lead')->nullable(true)->default(null);
            $table->longText('description')->nullable(true)->default(null);
            $table->string('thumbnail_url')->nullable(true)->default(null);
            $table->integer('status')->nullable(true)->default(0);
            $table->string('score')->nullable(true)->default(0); // 2013082107151215 => 2013-08-21 07:15:12 15 YYYY-MM-DD-priority (define trước. 1-2-3-5 hight, normal, low... )
            $table->string('image_list')->nullable(true)->default(null);
            $table->integer('is_buy')->nullable(true)->default(1); //  được bán
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
        Schema::dropIfExists('products');
    }
}
