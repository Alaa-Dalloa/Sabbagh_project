<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('quantity');
            $table->string('product_photo');
            $table->string('product_price');
            $table->string('order_date')->nullable();
            $table->string('user_name')->nullable();
            $table->string('governorat')->nullable();
            $table->string('countr')->nullable();
            $table->string('other_detail')->nullable();
            $table->string('phone')->nullable();
            $table->string('order_price_total')->nullable();
            $table->string('daily_order_date')->nullable();
            $table->string('status_order')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
