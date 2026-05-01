<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('ai_accounts_order');
        Schema::create('ai_accounts_order', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->unsignedBigInteger('ai_account_id');
            $table->decimal('price', 15, 2)->default(0);
            $table->string('status')->default('pending'); // pending, paid, delivered, canceled
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ai_account_id')->references('id')->on('ai_accounts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_accounts_order');
    }
};
