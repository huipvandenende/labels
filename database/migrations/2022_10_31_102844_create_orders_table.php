<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();

            $table->string('order_number');
            $table->integer('weight');
            $table->integer('qls_shipping_product_id')->nullable();
            $table->integer('qls_shipping_product_combination_id')->nullable();
            $table->float('cod_amount')->nullable();
            $table->integer('piece_total');

            // Should probably be normalized to a separate table.
            $table->string('receiver_company')->nullable();
            $table->string('receiver_name');
            $table->string('receiver_street');
            $table->string('receiver_housenumber');
            $table->string('receiver_zip');
            $table->string('receiver_city');
            $table->string('receiver_country');
            $table->string('receiver_email');

            $table->timestamps();
        });

        Schema::create('order_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();

            $table->integer('quantity');
            $table->string('name');
            $table->string('sku');
            $table->string('barcode');


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
        Schema::dropIfExists('order_lines');
        Schema::dropIfExists('orders');
    }
};
