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
        // 1. api_configs
        if (!Schema::hasTable('api_configs')) {
            Schema::create('api_configs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->longText('value')->nullable();
                $table->string('domain')->nullable();
                $table->string('username')->nullable();
                $table->timestamps();
            });
        }

        // 2. api_logo
        if (!Schema::hasTable('api_logo')) {
            Schema::create('api_logo', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->text('shortName');
                $table->text('logo');
                $table->text('name');
            });
        }

        // 3. author_forms
        if (!Schema::hasTable('author_forms')) {
            Schema::create('author_forms', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('user_id');
                $table->text('team');
                $table->text('team_members');
                $table->text('other_account');
                $table->text('market_account');
                $table->longText('work_category');
                $table->integer('status')->default(0);
                $table->timestamps();
            });
        }

        // 4. bank_accounts
        if (!Schema::hasTable('bank_accounts')) {
            Schema::create('bank_accounts', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('owner');
                $table->string('number');
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }

        // 5. card_lists
        if (!Schema::hasTable('card_lists')) {
            Schema::create('card_lists', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('type');
                $table->string('code');
                $table->string('serial');
                $table->integer('value');
                $table->integer('amount');
                $table->string('status');
                $table->string('user_id');
                $table->string('username');
                $table->integer('discount')->default(30);
                $table->string('sys_note')->nullable();
                $table->string('content')->nullable();
                $table->string('order_id')->nullable();
                $table->string('request_id')->nullable();
                $table->string('channel_charge')->nullable();
                $table->string('transaction_code')->nullable();
                $table->timestamps();
            });
        }

        // 6. comments
        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('post_id');
                $table->longText('content');
                $table->timestamps();
            });
        }

        // 7. configs
        if (!Schema::hasTable('configs')) {
            Schema::create('configs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->longText('value')->nullable();
                $table->string('domain')->nullable();
                $table->timestamps();
            });
        }

        // 8. createwebs
        if (!Schema::hasTable('createwebs')) {
            Schema::create('createwebs', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->string('trans_id', 500);
                $table->integer('user_id');
                $table->integer('web_id');
                $table->string('tk');
                $table->string('mk');
                $table->string('domain', 500);
                $table->integer('pointer')->default(0);
                $table->integer('time_exp');
                $table->integer('price');
                $table->integer('status')->default(0);
                $table->timestamps();
            });
        }

        // 9. currency_lists
        if (!Schema::hasTable('currency_lists')) {
            Schema::create('currency_lists', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('currency_code');
                $table->string('currency_symbol');
                $table->string('currency_thousand_separator')->default('dot');
                $table->string('currency_decimal_separator')->default('dot');
                $table->integer('currency_decimal')->default(2);
                $table->integer('default_price_percentage_increase')->default(0);
                $table->integer('auto_rounding_x_decimal_places')->default(2);
                $table->boolean('is_auto_currency_convert')->default(false);
                $table->integer('new_currecry_rate')->default(1);
                $table->timestamps();
            });
        }

        // 10. domain
        if (!Schema::hasTable('domain')) {
            Schema::create('domain', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->text('name');
                $table->integer('price');
                $table->text('extend_price');
                $table->integer('sale');
                $table->integer('status');
                $table->timestamps();
            });
        }

        // 11. domain_order
        if (!Schema::hasTable('domain_order')) {
            Schema::create('domain_order', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->text('trans_id');
                $table->integer('user_id');
                $table->text('domain_name');
                $table->text('ns');
                $table->text('price');
                $table->text('time_han');
                $table->timestamp('expired_date')->nullable();
                $table->integer('expired_timestamp')->nullable();
                $table->integer('giahan')->default(0);
                $table->integer('status');
                $table->timestamps();
            });
        }

        // 12. his_logo
        if (!Schema::hasTable('his_logo')) {
            Schema::create('his_logo', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('user_id');
                $table->integer('logo_id');
                $table->string('trans_id', 500);
                $table->integer('price')->default(0);
                $table->text('name');
                $table->string('link', 1000)->nullable();
                $table->integer('status')->default(0);
                $table->timestamps();
            });
        }

        // 13. licenses
        if (!Schema::hasTable('licenses')) {
            Schema::create('licenses', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('user_id');
                $table->string('license_key');
                $table->longText('domain');
                $table->string('status', 50);
                $table->text('cmt');
                $table->date('expiry_date')->nullable();
                $table->timestamps();
            });
        }

        // 14. list_url_cron
        if (!Schema::hasTable('list_url_cron')) {
            Schema::create('list_url_cron', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('user_id');
                $table->integer('id_server');
                $table->text('trans_id');
                $table->text('url');
                $table->integer('price');
                $table->integer('second');
                $table->text('status');
                $table->text('response')->nullable();
                $table->text('time_his');
                $table->timestamp('expired_date')->nullable();
                $table->text('expired_timestamp')->nullable();
                $table->timestamps();
            });
        }

        // 15. logos
        if (!Schema::hasTable('logos')) {
            Schema::create('logos', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->string('name', 500);
                $table->text('image');
                $table->integer('price')->default(0);
                $table->integer('ck')->default(0);
                $table->string('description', 500);
                $table->integer('status')->default(1);
                $table->timestamps();
            });
        }

        // 16. logs
        if (!Schema::hasTable('logs')) {
            Schema::create('logs', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('user_id');
                $table->text('action');
                $table->integer('data');
                $table->text('old_data');
                $table->text('new_data');
                $table->text('ip');
                $table->text('description');
                $table->text('data_json');
                $table->timestamps();
            });
        }

        // 17. notifications
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('type')->nullable();
                $table->longText('value')->nullable();
                $table->string('domain')->nullable();
                $table->timestamps();
            });
        }

        // 18. personal_access_tokens
        if (!Schema::hasTable('personal_access_tokens')) {
            Schema::create('personal_access_tokens', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('tokenable_type');
                $table->unsignedBigInteger('tokenable_id');
                $table->string('name');
                $table->string('token', 64)->unique();
                $table->text('abilities')->nullable();
                $table->timestamp('last_used_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
            });
        }

        // 19. posts
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('user_id')->default(0);
                $table->integer('category_id')->default(0);
                $table->text('title')->nullable();
                $table->text('mota')->nullable();
                $table->text('image')->nullable();
                $table->string('slug')->nullable();
                $table->longText('content')->nullable();
                $table->integer('status')->default(0);
                $table->integer('view')->default(0);
                $table->timestamps();
            });
        }

        // 20. post_category
        if (!Schema::hasTable('post_category')) {
            Schema::create('post_category', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->text('name')->nullable();
                $table->text('slug');
                $table->integer('status')->default(1);
                $table->timestamps();
            });
        }

        // 21. sever_crons
        if (!Schema::hasTable('sever_crons')) {
            Schema::create('sever_crons', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->text('name');
                $table->integer('price');
                $table->integer('ck');
                $table->integer('quantity');
                $table->integer('limit_second');
                $table->integer('status');
                $table->timestamps();
            });
        }

        // 22. tbl_category_hosting
        if (!Schema::hasTable('tbl_category_hosting')) {
            Schema::create('tbl_category_hosting', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->text('name')->nullable();
                $table->text('anh');
                $table->integer('status')->default(1);
                $table->timestamps();
            });
        }

        // 23. tbl_his_code
        if (!Schema::hasTable('tbl_his_code')) {
            Schema::create('tbl_his_code', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('user_id')->nullable();
                $table->integer('product_id')->nullable();
                $table->text('trans_id')->nullable();
                $table->integer('price')->nullable();
                $table->timestamps();
            });
        }

        // 24. tbl_hosting_packages
        if (!Schema::hasTable('tbl_hosting_packages')) {
            Schema::create('tbl_hosting_packages', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('category')->default(0);
                $table->string('package_name');
                $table->string('disk_quota');
                $table->string('bandwidth_limit');
                $table->string('max_subdomains');
                $table->string('max_parked_domains');
                $table->string('max_addon_domains');
                $table->string('language', 50)->nullable();
                $table->string('cpanel_module', 50)->nullable();
                $table->boolean('status')->default(false);
                $table->integer('price')->default(0);
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // 25. tbl_list_code
        if (!Schema::hasTable('tbl_list_code')) {
            Schema::create('tbl_list_code', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('user_id')->default(1);
                $table->text('name')->nullable();
                $table->integer('price')->default(0);
                $table->text('images')->nullable();
                $table->text('list_images')->nullable();
                $table->longText('intro')->nullable();
                $table->bigInteger('view')->default(0);
                $table->bigInteger('sold')->default(0);
                $table->text('link_down')->nullable();
                $table->text('link_demo')->nullable();
                $table->integer('status')->default(0);
                $table->integer('ck')->default(0);
                $table->timestamps();
            });
        }

        // 26. tbl_purchased_hosting
        if (!Schema::hasTable('tbl_purchased_hosting')) {
            Schema::create('tbl_purchased_hosting', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('user_id');
                $table->integer('package_id');
                $table->text('ip')->nullable();
                $table->text('block_ip')->nullable();
                $table->integer('start_date');
                $table->integer('end_date');
                $table->string('username')->nullable();
                $table->string('password')->nullable();
                $table->string('email');
                $table->string('domain_name');
                $table->text('server_whm')->nullable();
                $table->text('info_package')->nullable();
                $table->integer('price')->default(0);
                $table->integer('month')->default(1);
                $table->integer('total')->default(0);
                $table->integer('status');
                $table->integer('giahan')->default(0);
                $table->timestamps();
            });
        }

        // 27. tbl_whm_info
        if (!Schema::hasTable('tbl_whm_info')) {
            Schema::create('tbl_whm_info', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('category')->default(0);
                $table->string('whm_host');
                $table->text('ip')->nullable();
                $table->string('whm_user');
                $table->string('whm_pass');
                $table->text('accesshash');
                $table->integer('status')->default(0);
                $table->timestamps();
            });
        }

        // 28. transactions
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code');
                $table->decimal('amount', 12, 2);
                $table->decimal('real_amount', 12, 2)->default(0.00);
                $table->decimal('balance_after', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->string('type');
                $table->longText('extras')->nullable();
                $table->string('order_id')->nullable();
                $table->string('sys_note')->nullable();
                $table->string('status');
                $table->string('content')->nullable();
                $table->integer('user_id');
                $table->string('username');
                $table->text('lickey')->nullable();
                $table->timestamps();
            });
        }

        // 29. transfer_order
        if (!Schema::hasTable('transfer_order')) {
            Schema::create('transfer_order', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('user_id');
                $table->text('trans_id');
                $table->text('bank');
                $table->text('noidung')->nullable();
                $table->integer('price');
                $table->longText('content');
                $table->integer('status');
                $table->text('transactionID')->nullable();
                $table->timestamps();
            });
        }

        // 30. vouchers
        if (!Schema::hasTable('vouchers')) {
            Schema::create('vouchers', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code')->unique();
                $table->string('type');
                $table->integer('value');
                $table->integer('qty')->default(0);
                $table->string('username')->nullable();
                $table->date('start_date');
                $table->date('expire_date');
                $table->timestamps();
            });
        }

        // 31. voucher_logs
        if (!Schema::hasTable('voucher_logs')) {
            Schema::create('voucher_logs', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('user_id');
                $table->text('code');
                $table->text('value');
                $table->timestamps();
            });
        }

        // 32. wallet_logs
        if (!Schema::hasTable('wallet_logs')) {
            Schema::create('wallet_logs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('type')->default('default');
                $table->integer('amount');
                $table->string('status')->default('Pending');
                $table->string('user_id');
                $table->string('username');
                $table->string('sys_note')->nullable();
                $table->string('user_note')->nullable();
                $table->string('order_id')->nullable();
                $table->string('request_id')->nullable();
                $table->string('user_action');
                $table->longText('withdraw_detail')->nullable();
                $table->string('channel_charge')->nullable();
                $table->integer('balance_before')->default(0);
                $table->integer('balance_after')->default(0);
                $table->string('ip_address');
                $table->string('domain')->nullable();
                $table->timestamps();
            });
        }

        // 33. web
        if (!Schema::hasTable('web')) {
            Schema::create('web', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->integer('user_id');
                $table->string('name', 500);
                $table->integer('price');
                $table->integer('extend');
                $table->integer('ck');
                $table->string('images', 500);
                $table->string('list_images', 500);
                $table->string('description', 500);
                $table->integer('status')->default(1);
                $table->timestamps();
            });
        }

        // 34. withdraw_ctvs
        if (!Schema::hasTable('withdraw_ctvs')) {
            Schema::create('withdraw_ctvs', function (Blueprint $table) {
                $table->integer('id')->autoIncrement();
                $table->text('trans_id')->nullable();
                $table->integer('user_id');
                $table->text('price');
                $table->text('bank');
                $table->text('stk');
                $table->text('ctk');
                $table->integer('status');
                $table->text('url');
                $table->text('message')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_configs');
        Schema::dropIfExists('api_logo');
        Schema::dropIfExists('author_forms');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('card_lists');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('configs');
        Schema::dropIfExists('createwebs');
        Schema::dropIfExists('currency_lists');
        Schema::dropIfExists('domain');
        Schema::dropIfExists('domain_order');
        Schema::dropIfExists('his_logo');
        Schema::dropIfExists('licenses');
        Schema::dropIfExists('list_url_cron');
        Schema::dropIfExists('logos');
        Schema::dropIfExists('logs');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_category');
        Schema::dropIfExists('sever_crons');
        Schema::dropIfExists('tbl_category_hosting');
        Schema::dropIfExists('tbl_his_code');
        Schema::dropIfExists('tbl_hosting_packages');
        Schema::dropIfExists('tbl_list_code');
        Schema::dropIfExists('tbl_purchased_hosting');
        Schema::dropIfExists('tbl_whm_info');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('transfer_order');
        Schema::dropIfExists('vouchers');
        Schema::dropIfExists('voucher_logs');
        Schema::dropIfExists('wallet_logs');
        Schema::dropIfExists('web');
        Schema::dropIfExists('withdraw_ctvs');
    }
};
