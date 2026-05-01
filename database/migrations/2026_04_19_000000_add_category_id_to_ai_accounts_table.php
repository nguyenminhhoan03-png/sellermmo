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
        Schema::table('ai_accounts', function (Blueprint $table) {
            if (!Schema::hasColumn('ai_accounts', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('status');
                
                // Add foreign key constraint if categories table exists
                if (Schema::hasTable('ai_account_categories')) {
                    $table->foreign('category_id')
                          ->references('id')
                          ->on('ai_account_categories')
                          ->onDelete('set null');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_accounts', function (Blueprint $table) {
            if (Schema::hasColumn('ai_accounts', 'category_id')) {
                // Drop foreign key first
                try {
                    $table->dropForeign(['category_id']);
                } catch (\Exception $e) {
                    // Ignore if foreign key doesn't exist
                }
                $table->dropColumn('category_id');
            }
        });
    }
};
