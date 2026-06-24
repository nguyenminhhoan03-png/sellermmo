<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MockProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to safely truncate tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Seed AI Account Categories & Accounts
        DB::table('ai_accounts_variant')->truncate();
        DB::table('ai_accounts')->truncate();
        DB::table('ai_account_categories')->truncate();

        $aiCategories = [
            [
                'id' => 1,
                'name' => 'ChatGPT OpenAI',
                'slug' => 'chatgpt-openai',
                'description' => 'Trợ lý AI thông minh nhất từ OpenAI hỗ trợ phân tích dữ liệu, viết lách, code và lập kế hoạch.',
                'icon_url' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?q=80&w=200&auto=format&fit=crop',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Claude AI Anthropic',
                'slug' => 'claude-ai-anthropic',
                'description' => 'Mô hình ngôn ngữ tự nhiên tối ưu cho lập trình viên và phân tích tài liệu văn bản dài.',
                'icon_url' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=200&auto=format&fit=crop',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'Canva Pro',
                'slug' => 'canva-pro',
                'description' => 'Thiết kế đồ họa, slides, CV và video không giới hạn tài nguyên cao cấp.',
                'icon_url' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=200&auto=format&fit=crop',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'name' => 'Midjourney',
                'slug' => 'midjourney',
                'description' => 'AI vẽ tranh nghệ thuật chất lượng cao từ mô tả văn bản hàng đầu thế giới.',
                'icon_url' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?q=80&w=200&auto=format&fit=crop',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'name' => 'Google Gemini Pro',
                'slug' => 'google-gemini-pro',
                'description' => 'Nâng cấp tài khoản Google One tích hợp Gemini Advanced chính chủ tiện lợi.',
                'icon_url' => 'https://static0.howtogeekimages.com/wordpress/wp-content/uploads/2025/12/google-antigravity-logo-on-a-gradiant-background.jpg?w=200&fit=crop',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('ai_account_categories')->insert($aiCategories);

        $aiAccounts = [
            [
                'id' => 1,
                'name' => 'Tài Khoản ChatGPT Plus Chính Chủ (1 Đổi 1)',
                'image' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?q=80&w=800&auto=format&fit=crop',
                'price' => 0.00,
                'description' => "🌟 Tài Khoản ChatGPT Plus (GPT-4) Cao Cấp Chính Chủ\n\nMở khóa sức mạnh tuyệt đối của trí tuệ nhân tạo thế hệ mới với tài khoản ChatGPT Plus chính hãng:\n\n✔️ Truy cập không giới hạn vào GPT-4, GPT-4o thế hệ mới nhất.\n✔️ Tốc độ phản hồi cực nhanh, không bị nghẽn mạng giờ cao điểm.\n✔️ Hỗ trợ tạo ảnh bằng DALL-E 3 sắc nét trực quan.\n✔️ Khả năng duyệt web thời gian thực, đọc file PDF/Excel phân tích biểu đồ.\n✔️ Sử dụng kho Custom GPTs tùy biến công việc.\n\n🛡️ CHÍNH SÁCH BẢO HÀNH:\n- Bảo hành full thời gian sử dụng (1 đổi 1 nếu lỗi hệ thống).\n- Đội ngũ CSKH support 24/7 nhiệt tình.",
                'account_info' => 'Email | Password đăng nhập chính chủ, bảo hành 1 đổi 1.',
                'status' => 1,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Claude 3.5 Sonnet Pro Workspace',
                'image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=800&auto=format&fit=crop',
                'price' => 0.00,
                'description' => "🚀 Tài Khoản Claude Pro (Sonnet 3.5 & Opus)\n\nMô hình AI ngôn ngữ tự nhiên tối ưu nhất cho lập trình và phân tích logic:\n\n✔️ Đọc tài liệu siêu lớn (lên tới 200k tokens), phân tích file PDF học thuật chuẩn xác.\n✔️ Code nhanh và tối ưu hơn tất cả các model hiện tại, hỗ trợ xuất Artifacts trực quan.\n✔️ Giới hạn nhắn tin cao gấp 5 lần so với bản miễn phí.\n\n🛡️ CHÍNH SÁCH BẢO HÀNH:\n- Kích hoạt qua email của khách hàng hoặc cấp tài khoản sẵn.\n- Bảo hành 100% trọn gói đăng ký.",
                'account_info' => 'Kích hoạt chính chủ qua email hoặc bàn giao tài khoản có sẵn.',
                'status' => 1,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'Canva Pro Giáo Dục Vĩnh Viễn / 1 Năm',
                'image' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800&auto=format&fit=crop',
                'price' => 0.00,
                'description' => "🎨 Nâng Cấp Canva Pro Chính Chủ - Không Giới Hạn Thiết Kế\n\nNâng cấp trực tiếp email cá nhân lên Canva Pro, an toàn, bảo mật dữ liệu riêng tư 100%:\n\n✔️ Hơn 100 triệu hình ảnh, video, đồ họa cao cấp miễn phí.\n✔️ Hơn 610.000 mẫu template thiết kế sẵn cực đẹp.\n✔️ Công cụ xóa nền ảnh bằng 1 click siêu sạch.\n✔️ Đổi kích cỡ thiết kế nhanh chóng (Magic Resize).\n✔️ Tải xuống video/ảnh chất lượng cao, định dạng trong suốt SVG.\n\n🛡️ CHÍNH SÁCH BẢO HÀNH:\n- Kích hoạt qua link mời add-on chính chủ an toàn.\n- Bảo hành trọn đời / theo năm tùy chọn.",
                'account_info' => 'Nhận link mời tham gia nhóm VIP Canva Pro qua Email.',
                'status' => 1,
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'name' => 'Tài Khoản Midjourney Standard Tạo Ảnh AI',
                'image' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?q=80&w=800&auto=format&fit=crop',
                'price' => 0.00,
                'description' => "🌌 Tài Khoản Midjourney Premium Tạo Ảnh Nghệ Thuật Đỉnh Cao\n\nTạo ảnh nghệ thuật vô hạn từ mô tả văn bản với phiên bản mới nhất v6:\n\n✔️ Chế độ vẽ nhanh (Fast Hours) không chờ đợi.\n✔️ Tạo ảnh riêng tư (Stealth mode) không công khai trên thư viện.\n✔️ Sử dụng trực tiếp trên Discord cá nhân hoặc qua tài khoản cấp sẵn.\n\n🛡️ CHÍNH SÁCH BẢO HÀNH:\n- Bảo hành trọn thời hạn đăng ký.\n- 1 đổi 1 nếu tài khoản phát sinh lỗi.",
                'account_info' => 'Bàn giao tài khoản Discord liên kết Midjourney hoặc add member.',
                'status' => 1,
                'category_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'name' => 'Gói Google One AI Premium (Gemini Advanced)',
                'image' => 'https://static0.howtogeekimages.com/wordpress/wp-content/uploads/2025/12/google-antigravity-logo-on-a-gradiant-background.jpg?w=800&fit=crop',
                'price' => 0.00,
                'description' => "📦 Gói Nâng Cấp Google One AI Premium 1 Năm - Google AI Pro (Gemini Pro + 2TB / 5TB)\n\nGiải pháp \"All-in-one\" chính chủ giúp bạn tối ưu hiệu suất công việc và giải phóng hoàn toàn không gian lưu trữ:\n\n✔️ Gemini Advanced: Trợ lý AI cao cấp nhất hỗ trợ viết code, lên ý tưởng, đọc file văn bản siêu tốc.\n✔️ 2TB/5TB Lưu Trữ Google One: Không gian khổng lồ cho Drive, Photos và Gmail.\n✔️ Tích hợp Workspace: Soạn thảo văn bản, viết mail tự động trực tiếp trên Google Docs/Gmail.\n\n🛡️ CHÍNH SÁCH BẢO HÀNH:\n- Hỗ trợ nâng cấp chính chủ hoặc tài khoản add Family.\n- Bảo hành full 12 tháng sử dụng.",
                'account_info' => 'Nâng cấp email chính chủ của khách hàng qua group gia đình Google.',
                'status' => 1,
                'category_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('ai_accounts')->insert($aiAccounts);

        $aiVariants = [
            // ChatGPT
            ['account_id' => 1, 'variant_name' => '1 Tháng (Dùng chung)', 'price' => 79000.00, 'old_price' => 99000.00, 'stock_quantity' => 99, 'duration_days' => 30, 'sku' => 'GPT-30-SHARE', 'created_at' => now(), 'updated_at' => now()],
            ['account_id' => 1, 'variant_name' => '1 Tháng (Riêng tư chính chủ)', 'price' => 299000.00, 'old_price' => 350000.00, 'stock_quantity' => 99, 'duration_days' => 30, 'sku' => 'GPT-30-PV', 'created_at' => now(), 'updated_at' => now()],
            ['account_id' => 1, 'variant_name' => '6 Tháng (Riêng tư chính chủ)', 'price' => 1590000.00, 'old_price' => 1800000.00, 'stock_quantity' => 99, 'duration_days' => 180, 'sku' => 'GPT-180-PV', 'created_at' => now(), 'updated_at' => now()],
            // Claude
            ['account_id' => 2, 'variant_name' => '1 Tháng (Riêng tư)', 'price' => 320000.00, 'old_price' => 390000.00, 'stock_quantity' => 99, 'duration_days' => 30, 'sku' => 'CLD-30-PV', 'created_at' => now(), 'updated_at' => now()],
            ['account_id' => 2, 'variant_name' => '3 Tháng (Riêng tư)', 'price' => 890000.00, 'old_price' => 1100000.00, 'stock_quantity' => 99, 'duration_days' => 90, 'sku' => 'CLD-90-PV', 'created_at' => now(), 'updated_at' => now()],
            // Canva
            ['account_id' => 3, 'variant_name' => '1 Năm (Gia hạn VIP)', 'price' => 99000.00, 'old_price' => 180000.00, 'stock_quantity' => 999, 'duration_days' => 365, 'sku' => 'CNV-365', 'created_at' => now(), 'updated_at' => now()],
            ['account_id' => 3, 'variant_name' => 'Vĩnh Viễn (Bảo hành 2 năm)', 'price' => 249000.00, 'old_price' => 450000.00, 'stock_quantity' => 999, 'duration_days' => 9999, 'sku' => 'CNV-LIFETIME', 'created_at' => now(), 'updated_at' => now()],
            // Midjourney
            ['account_id' => 4, 'variant_name' => '1 Tháng (Dùng chung)', 'price' => 149000.00, 'old_price' => 199000.00, 'stock_quantity' => 50, 'duration_days' => 30, 'sku' => 'MJ-30-SHARE', 'created_at' => now(), 'updated_at' => now()],
            ['account_id' => 4, 'variant_name' => '1 Tháng (Riêng tư Basic)', 'price' => 299000.00, 'old_price' => 350000.00, 'stock_quantity' => 99, 'duration_days' => 30, 'sku' => 'MJ-30-PV', 'created_at' => now(), 'updated_at' => now()],
            // Gemini
            ['account_id' => 5, 'variant_name' => '1 Tháng (Add Fam 2TB)', 'price' => 39000.00, 'old_price' => 69000.00, 'stock_quantity' => 999, 'duration_days' => 30, 'sku' => 'GEM-30-FAM', 'created_at' => now(), 'updated_at' => now()],
            ['account_id' => 5, 'variant_name' => '6 Tháng (Add Fam 2TB)', 'price' => 180000.00, 'old_price' => 250000.00, 'stock_quantity' => 999, 'duration_days' => 180, 'sku' => 'GEM-180-FAM', 'created_at' => now(), 'updated_at' => now()],
            ['account_id' => 5, 'variant_name' => '1 Năm (Add Fam 2TB)', 'price' => 320000.00, 'old_price' => 450000.00, 'stock_quantity' => 999, 'duration_days' => 365, 'sku' => 'GEM-365-FAM', 'created_at' => now(), 'updated_at' => now()]
        ];
        DB::table('ai_accounts_variant')->insert($aiVariants);


        // 2. Seed Code / Source Codes (tbl_list_code)
        DB::table('tbl_list_code')->truncate();
        $codes = [
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Mã nguồn Website bán hàng tự động & Dịch vụ MMO tích hợp API Sepay',
                'price' => 350000,
                'images' => 'https://images.unsplash.com/photo-1542831371-29b0f74f9713?q=80&w=800&auto=format&fit=crop',
                'list_images' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800&auto=format&fit=crop',
                'intro' => '<p><strong>Mã nguồn SellerMMO Premium:</strong></p><p>Hệ thống bán mã nguồn, dịch vụ hosting cPanel tự động, bán tài khoản AI và logo chuyên nghiệp.</p><ul><li>Tích hợp tự động cộng tiền qua SePay / MBBank / Vietcombank.</li><li>Tự động tạo Hosting trên cPanel qua WHM API.</li><li>Module quản lý bán tài khoản AI phân loại nhiều biến thể (1 tháng, 6 tháng, 1 năm).</li><li>Giao diện Bootstrap hiện đại, tối ưu SEO, responsive đầy đủ trên điện thoại và máy tính.</li></ul>',
                'view' => 1245,
                'sold' => 42,
                'link_down' => base64_encode('https://example.com/download/sellermmo-premium.zip'),
                'link_demo' => 'https://demo.sellermmo.site',
                'status' => 1,
                'ck' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'Tool Auto Render Video TikTok Affiliate hàng loạt từ văn bản (Python)',
                'price' => 1500000,
                'images' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=800&auto=format&fit=crop',
                'list_images' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=800&auto=format&fit=crop',
                'intro' => '<p><strong>Công cụ Tự Động Hóa TikTok Affiliate Marketing:</strong></p><p>Phần mềm viết bằng Python giúp tự động hóa 100% quy trình làm video TikTok Affiliate để ăn hoa hồng từ sản phẩm.</p><ul><li>Tự động quét sản phẩm hot trend trên TikTok Shop.</li><li>Sử dụng Gemini 2.5 Flash API để tạo kịch bản video thu hút người xem.</li><li>Tự động tạo giọng đọc AI (Text-to-Speech) truyền cảm.</li><li>Ghép video nền tự động, chèn phụ đề hiệu ứng động (CapCut-like).</li><li>Hỗ trợ cơ chế xoay tua tài khoản Google/Gemini để tránh giới hạn API rate limit.</li></ul>',
                'view' => 3120,
                'sold' => 18,
                'link_down' => base64_encode('https://example.com/download/tiktok-affiliate-bot.zip'),
                'link_demo' => 'https://youtube.com/watch?v=tiktok-bot-demo',
                'status' => 1,
                'ck' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'name' => 'Mã nguồn Cổng nạp thẻ cào tự động và đổi thẻ cào sang tiền mặt',
                'price' => 250000,
                'images' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?q=80&w=800&auto=format&fit=crop',
                'list_images' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?q=80&w=800&auto=format&fit=crop',
                'intro' => '<p><strong>Hệ Thống Đổi Thẻ Cào 24/7:</strong></p><p>Tích hợp API kết nối với các cổng gạch thẻ lớn tại Việt Nam (Viettel, Vinaphone, Mobifone, Zing...) giúp quy đổi thẻ cào thành số dư nhanh chóng trong 3 giây.</p><ul><li>Bảng phí chiết khấu thông minh tự động thay đổi theo thị trường.</li><li>Quản lý lịch sử nạp thẻ chi tiết, phân loại trạng thái Thẻ đúng / Thẻ sai mệnh giá.</li><li>An toàn, bảo mật chống spam, DDoS.</li></ul>',
                'view' => 840,
                'sold' => 61,
                'link_down' => base64_encode('https://example.com/download/card-exchange.zip'),
                'link_demo' => 'https://doithecao.sellermmo.site',
                'status' => 1,
                'ck' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'name' => 'Theme WordPress Tin Tức chuẩn SEO tối ưu Core Web Vitals (99+ điểm Mobile)',
                'price' => 199000,
                'images' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800&auto=format&fit=crop',
                'list_images' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800&auto=format&fit=crop',
                'intro' => '<p><strong>Theme Tin Tức Báo Chí Hiện Đại:</strong></p><p>Thích hợp làm trang chia sẻ thủ thuật, tin tức công nghệ, kiếm tiền online, affiliate marketing.</p><ul><li>Tối ưu hóa Core Web Vitals tối đa (LCP < 1.2s, CLS = 0).</li><li>Tích hợp sẵn các vị trí đặt quảng cáo Google AdSense tăng tối đa CTR.</li><li>Hỗ trợ Lazy Load hình ảnh, CSS và JS gộp dung lượng nhẹ.</li></ul>',
                'view' => 1500,
                'sold' => 95,
                'link_down' => base64_encode('https://example.com/download/news-theme.zip'),
                'link_demo' => 'https://news.sellermmo.site',
                'status' => 1,
                'ck' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('tbl_list_code')->insert($codes);


        // 3. Seed Domain Prices (domain)
        DB::table('domain')->truncate();
        $domains = [
            ['id' => 1, 'name' => 'com', 'price' => 275000, 'extend_price' => '320000', 'sale' => 0, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'net', 'price' => 299000, 'extend_price' => '350000', 'sale' => 0, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'org', 'price' => 320000, 'extend_price' => '370000', 'sale' => 0, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'vn', 'price' => 550000, 'extend_price' => '490000', 'sale' => 0, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'com.vn', 'price' => 450000, 'extend_price' => '390000', 'sale' => 0, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'xyz', 'price' => 39000, 'extend_price' => '290000', 'sale' => 0, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'tech', 'price' => 49000, 'extend_price' => '450000', 'sale' => 0, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'info', 'price' => 120000, 'extend_price' => '350000', 'sale' => 0, 'status' => 1, 'created_at' => now(), 'updated_at' => now()]
        ];
        DB::table('domain')->insert($domains);


        // 4. Seed Hosting Categories & Packages
        DB::table('tbl_hosting_packages')->truncate();
        DB::table('tbl_category_hosting')->truncate();

        $hostingCategories = [
            ['id' => 1, 'name' => 'Cloud SSD Hosting Việt Nam', 'anh' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?q=80&w=200&auto=format&fit=crop', 'status' => 1, 'created_at' => now()->toDateTimeString(), 'updated_at' => now()->toDateTimeString()],
            ['id' => 2, 'name' => 'Premium cPanel Hosting US/Singapore', 'anh' => 'https://images.unsplash.com/photo-1600132806370-bf17e65e942f?q=80&w=200&auto=format&fit=crop', 'status' => 1, 'created_at' => now()->toDateTimeString(), 'updated_at' => now()->toDateTimeString()],
            ['id' => 3, 'name' => 'Reseller Hosting Đại Lý', 'anh' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?q=80&w=200&auto=format&fit=crop', 'status' => 1, 'created_at' => now()->toDateTimeString(), 'updated_at' => now()->toDateTimeString()]
        ];
        DB::table('tbl_category_hosting')->insert($hostingCategories);

        $hostingPackages = [
            [
                'id' => 1,
                'category' => 1,
                'package_name' => 'Cloud-Starter',
                'disk_quota' => '1024', // 1GB
                'bandwidth_limit' => '102400', // 100GB
                'max_subdomains' => '5',
                'max_parked_domains' => '2',
                'max_addon_domains' => '1',
                'language' => 'vi',
                'cpanel_module' => 'jupiter',
                'status' => 1,
                'price' => 19000, // 19k/tháng
                'description' => 'Thích hợp cho các blog cá nhân, website giới thiệu sản phẩm đơn giản hoặc đồ án sinh viên.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'category' => 1,
                'package_name' => 'Cloud-Standard',
                'disk_quota' => '5120', // 5GB
                'bandwidth_limit' => 'unlimited',
                'max_subdomains' => 'unlimited',
                'max_parked_domains' => 'unlimited',
                'max_addon_domains' => '5',
                'language' => 'vi',
                'cpanel_module' => 'jupiter',
                'status' => 1,
                'price' => 49000, // 49k/tháng
                'description' => 'Tối ưu cho các shop bán hàng WordPress tầm trung, chịu tải tốt, băng thông không giới hạn.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'category' => 2,
                'package_name' => 'US-Premium',
                'disk_quota' => '10240', // 10GB NVMe
                'bandwidth_limit' => 'unlimited',
                'max_subdomains' => 'unlimited',
                'max_parked_domains' => 'unlimited',
                'max_addon_domains' => '10',
                'language' => 'en',
                'cpanel_module' => 'jupiter',
                'status' => 1,
                'price' => 99000, // 99k/tháng
                'description' => 'Hosting cao cấp sử dụng ổ cứng NVMe SSD siêu tốc đặt tại Datacenter US, phù hợp với các site chạy quảng cáo toàn cầu.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'category' => 3,
                'package_name' => 'Reseller-Silver',
                'disk_quota' => '51200', // 50GB
                'bandwidth_limit' => 'unlimited',
                'max_subdomains' => 'unlimited',
                'max_parked_domains' => 'unlimited',
                'max_addon_domains' => 'unlimited',
                'language' => 'vi',
                'cpanel_module' => 'jupiter',
                'status' => 1,
                'price' => 299000, // 299k/tháng
                'description' => 'Gói đại lý giúp bạn tự tạo và quản lý lên tới 30 tài khoản hosting con để kinh doanh hoặc chia sẻ cho khách hàng.',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('tbl_hosting_packages')->insert($hostingPackages);


        // 5. Seed Logo Designs (logos)
        DB::table('logos')->truncate();
        $logos = [
            [
                'id' => 1,
                'name' => 'Thiết Kế Logo Gaming Esports Team (Mascot / 3D)',
                'image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=800&auto=format&fit=crop',
                'price' => 499000,
                'ck' => 10,
                'description' => 'Logo mang phong cách Mascot độc đáo, thích hợp cho các streamer, đội tuyển Esports hoặc shop kinh doanh dịch vụ game trực tuyến.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Thiết Kế Logo Thương Hiệu Startup / Công Nghệ (Minimalist)',
                'image' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800&auto=format&fit=crop',
                'price' => 790000,
                'ck' => 15,
                'description' => 'Thiết kế logo tối giản, hiện đại và sang trọng giúp định vị thương hiệu startup, dịch vụ SEO, Marketing chuyên nghiệp.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'Thiết Kế Logo Nhận Diện Shop Bán Hàng Online / Mỹ Phẩm',
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800&auto=format&fit=crop',
                'price' => 350000,
                'ck' => 5,
                'description' => 'Phong cách thiết kế nhẹ nhàng, tinh tế, thích hợp cho các shop mỹ phẩm, quần áo, phụ kiện thời trang.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('logos')->insert($logos);


        // 6. Seed Instant Website Setup (web)
        DB::table('web')->truncate();
        $webs = [
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Tự Động Tạo Web Shop Bán Nick Game & Vòng Quay May Mắn',
                'price' => 199000,
                'extend' => 20000,
                'ck' => 5,
                'images' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=800&auto=format&fit=crop',
                'list_images' => "https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=800&auto=format&fit=crop\nhttps://images.unsplash.com/photo-1542831371-29b0f74f9713?q=80&w=800&auto=format&fit=crop",
                'description' => "- Tạo website bán acc game chỉ trong 30 giây.\n- Tích hợp vòng quay may mắn, rút vật phẩm, dịch vụ cày thuê.\n- Giao diện quản trị Admin trực quan, chỉnh sửa tỷ lệ trúng thưởng vòng quay dễ dàng.\n- Có chức năng phân quyền Cộng tác viên để tuyển đại lý cùng bán nick.",
                'status' => 1,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'Tự Động Tạo Web Bán Dịch Vụ MMO & Nâng Cấp Tài Khoản Premium',
                'price' => 299000,
                'extend' => 30000,
                'ck' => 10,
                'images' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800&auto=format&fit=crop',
                'list_images' => "https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=800&auto=format&fit=crop\nhttps://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=800&auto=format&fit=crop",
                'description' => "- Hệ thống y hệt SellerMMO giúp bạn bắt đầu kinh doanh ngay lập tức.\n- Tích hợp Sepay tự động xác nhận số dư tài khoản ngân hàng.\n- Tự động bán tài khoản AI, Logo, mã nguồn chuẩn hóa.\n- Bảng điều khiển quản lý doanh thu, lợi nhuận trực quan.",
                'status' => 1,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'name' => 'Tự Động Tạo Web Landing Page Portfolio Giới Thiệu Bản Thân',
                'price' => 99000,
                'extend' => 10000,
                'ck' => 0,
                'images' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800&auto=format&fit=crop',
                'list_images' => "https://images.unsplash.com/photo-1626785774573-4b799315345d?q=80&w=800&auto=format&fit=crop",
                'description' => "- Phù hợp cho các Freelancer, Developer, Marketer làm trang portfolio cá nhân.\n- Giao diện cực đẹp, tối giản, hiệu ứng animation mượt mà.\n- Form liên hệ gửi thông báo trực tiếp về Telegram cá nhân của bạn.",
                'status' => 1,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ]
        ];
        DB::table('web')->insert($webs);


        // 7. Seed Cronjob Servers (sever_crons)
        DB::table('sever_crons')->truncate();
        $cronServers = [
            [
                'id' => 1,
                'name' => 'Server Cronjob Việt Nam (Hà Nội VIP - Ổn Định 99.9%)',
                'price' => 5000,
                'ck' => 0,
                'quantity' => 150,
                'limit_second' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Server Cronjob Singapore (Tốc Độ Cao - Delay < 0.2s)',
                'price' => 8000,
                'ck' => 5,
                'quantity' => 100,
                'limit_second' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'Server Cronjob US (Standard - Tiết Kiệm Chi Phí)',
                'price' => 2000,
                'ck' => 0,
                'quantity' => 500,
                'limit_second' => 5,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('sever_crons')->insert($cronServers);

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
