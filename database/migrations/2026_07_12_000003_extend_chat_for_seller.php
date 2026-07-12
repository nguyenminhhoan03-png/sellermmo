<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_conversations', function (Blueprint $table) {
            if (!Schema::hasColumn('chat_conversations', 'seller_id')) {
                // null = chat với admin, có giá trị = chat với seller cụ thể
                $table->unsignedBigInteger('seller_id')->nullable()->after('user_id')->index();
            }
            if (!Schema::hasColumn('chat_conversations', 'order_ref')) {
                // Mã đơn hàng tham chiếu (vd: trans_id) để seller biết ngữ cảnh
                $table->string('order_ref')->nullable()->after('seller_id');
            }
            if (!Schema::hasColumn('chat_conversations', 'unread_seller')) {
                $table->integer('unread_seller')->default(0)->after('unread_user');
            }
        });

        // Mở rộng enum sender_type để cho phép 'seller' gửi tin nhắn
        Schema::table('chat_messages', function (Blueprint $table) {
            // MySQL không thể ALTER ENUM trực tiếp, dùng string thay thế
            // Đổi cột sang VARCHAR để linh hoạt hơn
            $table->string('sender_type', 20)->default('user')->change();
        });
    }

    public function down(): void
    {
        Schema::table('chat_conversations', function (Blueprint $table) {
            $table->dropColumn(['seller_id', 'order_ref', 'unread_seller']);
        });
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->enum('sender_type', ['user', 'admin'])->change();
        });
    }
};
