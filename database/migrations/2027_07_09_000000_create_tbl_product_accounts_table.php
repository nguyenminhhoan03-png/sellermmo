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
        if (!Schema::hasTable('tbl_product_accounts')) {
            Schema::create('tbl_product_accounts', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('product_id');
                $table->text('account_info');
                $table->integer('buyer_id')->nullable();
                $table->string('trans_id')->nullable();
                $table->integer('status')->default(0); // 0: Available, 1: Sold
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_product_accounts');
    }
};
