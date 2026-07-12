<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_accounts_order', function (Blueprint $table) {
            if (!Schema::hasColumn('ai_accounts_order', 'seller_id')) {
                // Snapshot seller_id tại thời điểm mua
                $table->unsignedBigInteger('seller_id')->nullable()->after('ai_account_id')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('ai_accounts_order', function (Blueprint $table) {
            if (Schema::hasColumn('ai_accounts_order', 'seller_id')) {
                $table->dropIndex(['seller_id']);
                $table->dropColumn('seller_id');
            }
        });
    }
};
