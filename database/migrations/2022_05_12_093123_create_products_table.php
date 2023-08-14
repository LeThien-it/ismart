<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->text('content');
            $table->text('warranty');
            $table->text('promotion');
            $table->text('parameter');
            $table->text('parameter_detail');
            $table->foreignId('category_product_id');
            $table->foreignId('user_id');
            $table->string('slug');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('featured')->default(0);
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
        Schema::dropIfExists('products');
    }
}
