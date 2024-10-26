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
    Schema::create('order_items', function (Blueprint $table) {
        $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
        $table->foreignId('products_id')->constrained('products')->onDelete('cascade');
        $table->unsignedInteger('quantity');
        $table->decimal('price', 10, 2);
        $table->decimal('discount', 10, 2)->default(0);
        $table->primary(['order_id', 'products_id']);
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
        Schema::dropIfExists('order_items');
    }
};
