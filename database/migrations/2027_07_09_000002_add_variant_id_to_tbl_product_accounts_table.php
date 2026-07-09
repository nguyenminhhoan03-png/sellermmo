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
        if (Schema::hasTable('tbl_product_accounts') && !Schema::hasColumn('tbl_product_accounts', 'variant_id')) {
            Schema::table('tbl_product_accounts', function (Blueprint $table) {
                $table->integer('variant_id')->nullable()->after('product_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('tbl_product_accounts') && Schema::hasColumn('tbl_product_accounts', 'variant_id')) {
            Schema::table('tbl_product_accounts', function (Blueprint $table) {
                $table->dropColumn('variant_id');
            });
        }
    }
};
