<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_list_code', function (Blueprint $table) {
            $table->string('category', 50)->nullable()->default('website')->after('status')
                  ->comment('website|game|phanmem|thucpham|ecommerce|blog|other');
        });

        // Set existing records to default category
        DB::table('tbl_list_code')->whereNull('category')->update(['category' => 'website']);
    }

    public function down(): void
    {
        Schema::table('tbl_list_code', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
