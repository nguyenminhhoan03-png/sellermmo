<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_accounts', function (Blueprint $table) {
            if (!Schema::hasColumn('ai_accounts', 'seller_id')) {
                // null = admin quản lý (không phải người bán cụ thể)
                $table->unsignedBigInteger('seller_id')->nullable()->after('category_id')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('ai_accounts', function (Blueprint $table) {
            if (Schema::hasColumn('ai_accounts', 'seller_id')) {
                $table->dropIndex(['seller_id']);
                $table->dropColumn('seller_id');
            }
        });
    }
};
