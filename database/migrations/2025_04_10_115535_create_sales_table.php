<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('sale_date');
            $table->string('sales_products');
            $table->decimal('total_price', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('total_pay', 10, 2);
            $table->decimal('total_return', 10, 2);
            $table->integer('member_id')->nullable();
            $table->integer('user_id');
            $table->integer('point');
            $table->integer('used_point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
