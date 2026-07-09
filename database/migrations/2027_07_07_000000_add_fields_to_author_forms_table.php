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
        Schema::table('author_forms', function (Blueprint $table) {
            if (!Schema::hasColumn('author_forms', 'shop_name')) {
                $table->string('shop_name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('author_forms', 'contact_phone')) {
                $table->string('contact_phone')->nullable()->after('shop_name');
            }
            if (!Schema::hasColumn('author_forms', 'contact_facebook')) {
                $table->string('contact_facebook')->nullable()->after('contact_phone');
            }
            if (!Schema::hasColumn('author_forms', 'contact_telegram')) {
                $table->string('contact_telegram')->nullable()->after('contact_facebook');
            }
            if (!Schema::hasColumn('author_forms', 'description')) {
                $table->text('description')->nullable()->after('contact_telegram');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('author_forms', function (Blueprint $table) {
            $table->dropColumn([
                'shop_name',
                'contact_phone',
                'contact_facebook',
                'contact_telegram',
                'description'
            ]);
        });
    }
};
