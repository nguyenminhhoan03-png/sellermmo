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
        Schema::table('ai_accounts_order', function (Blueprint $table) {
            $table->unsignedBigInteger('variant_id')->nullable()->after('ai_account_id');
            $table->string('trans_id')->nullable()->after('variant_id');
            $table->timestamp('expiry_date')->nullable()->after('note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_accounts_order', function (Blueprint $table) {
            $table->dropColumn(['variant_id', 'trans_id', 'expiry_date']);
        });
    }
};
