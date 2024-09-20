<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('offer_name')->nullable();
            $table->string('discount')->nullable();
            $table->string('package_photo')->nullable();
            $table->string('product_id');
            $table->string('product_name');
            $table->string('second_unit');
            $table->string('third_unit')->nullable();
            $table->string('photo');
            $table->string('package_packing');
            $table->string('price_first_unit');
            $table->string('price_package');
            $table->string('first_unit');
            $table->string('category_name');
            $table->string('discount_start_date');
            $table->string('discount_end_date')->nullable();
            $table->string('final_price_package')->nullable();
            $table->string('expire')->default(0);
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
        Schema::dropIfExists('packages');
    }
}
