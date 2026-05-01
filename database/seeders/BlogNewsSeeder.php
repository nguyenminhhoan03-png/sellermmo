<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BlogNewsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->first();

        if (!$user) {
            $user = User::create([
                'username' => 'newsadmin',
                'name' => 'News Admin',
                'email' => 'newsadmin@example.com',
                'password' => Hash::make('12345678'),
                'level' => 1,
                'balance' => 0,
                'balance_ctv' => 0,
                'total_deposit' => 0,
                'banned' => 0,
                'loai' => 'member',
            ]);
        }

        $categoryNames = [
            'Tin Tức',
            'Hướng Dẫn',
            'Bảo Mật',
            'SEO',
            'Marketing',
            'AI',
            'Hosting',
            'Domain',
            'Mã Nguồn',
            'Kinh Nghiệm Vận Hành',
        ];

        $categories = collect($categoryNames)->map(function (string $name) {
            $slug = Str::slug($name);

            return PostCategory::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'status' => 1,
                ]
            );
        });

        $imagePool = [
            'https://picsum.photos/seed/news-01/1200/675',
            'https://picsum.photos/seed/news-02/1200/675',
            'https://picsum.photos/seed/news-03/1200/675',
            'https://picsum.photos/seed/news-04/1200/675',
            'https://picsum.photos/seed/news-05/1200/675',
            'https://picsum.photos/seed/news-06/1200/675',
            'https://picsum.photos/seed/news-07/1200/675',
            'https://picsum.photos/seed/news-08/1200/675',
            'https://picsum.photos/seed/news-09/1200/675',
            'https://picsum.photos/seed/news-10/1200/675',
        ];

        $topics = [
            'Checklist tối ưu trang bán hàng để tăng chuyển đổi',
            'Cách viết mô tả sản phẩm chuẩn SEO và dễ chốt đơn',
            'Kinh nghiệm xây dựng landing page cho sản phẩm số',
            'Tối ưu tốc độ website để giữ chân người dùng mobile',
            'Mẹo chọn hosting ổn định cho website thương mại',
            'Những lỗi bảo mật phổ biến khi vận hành website',
            'Cách lên kế hoạch nội dung blog theo từng danh mục',
            'Mẫu quy trình xử lý ticket hỗ trợ khách hàng nhanh',
            'Ứng dụng AI để viết nội dung và tự động hóa CSKH',
            'Cách đo lường hiệu quả SEO bằng chỉ số quan trọng',
            'Hướng dẫn cấu hình SMTP gửi mail ổn định',
            'Kinh nghiệm quản lý domain và gia hạn an toàn',
            'Chiến lược internal link cho site nhiều bài viết',
            'Cách phân loại nội dung để mở rộng thành cổng tin',
            'Bộ tiêu chí đánh giá chất lượng bài viết chuẩn EEAT',
            'Tối ưu hình ảnh và media để cải thiện Core Web Vitals',
            'Những điểm cần có ở trang chi tiết bài viết chuẩn tin tức',
            'Cách tổ chức chuyên mục như các trang lớn',
            'Hướng dẫn tạo cụm chủ đề (topic cluster) hiệu quả',
            'Cách theo dõi hành vi người đọc để tăng thời gian onsite',
        ];

        $categoryCount = $categories->count();
        $imageCount = count($imagePool);

        for ($i = 0; $i < 40; $i++) {
            $category = $categories[$i % $categoryCount];
            $title = $topics[$i % count($topics)] . ' #' . ($i + 1);
            $slug = Str::slug($title);
            $description = 'Bài viết chia sẻ kinh nghiệm thực tế giúp tối ưu vận hành, tăng traffic tự nhiên và nâng tỷ lệ chuyển đổi cho website dịch vụ số.';

            $content = <<<HTML
<h2>Tổng quan</h2>
<p>{$description}</p>
<p>Nội dung tập trung vào cách triển khai thực tế, dễ áp dụng cho cả website mới và website đang vận hành lâu năm.</p>
<h2>Các bước triển khai</h2>
<h3>Bước 1: Phân tích hiện trạng</h3>
<p>Đánh giá tốc độ tải, cấu trúc nội dung, mức độ đáp ứng trên mobile và hành vi người dùng để xác định ưu tiên.</p>
<h3>Bước 2: Tối ưu nội dung và cấu trúc</h3>
<p>Chuẩn hóa tiêu đề, mô tả, heading, hình ảnh và liên kết nội bộ để tăng khả năng đọc hiểu của người dùng và công cụ tìm kiếm.</p>
<h3>Bước 3: Theo dõi và cải tiến</h3>
<p>Đo lường bằng dữ liệu thật, cập nhật theo chu kỳ để giữ vị trí bền vững và tăng hiệu suất kinh doanh.</p>
<h2>Kết luận</h2>
<p>Áp dụng nhất quán các bước trên sẽ giúp website ổn định hơn, tăng niềm tin và chuyển đổi tốt hơn theo thời gian.</p>
HTML;

            Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'title' => $title,
                    'mota' => base64_encode($description),
                    'image' => $imagePool[$i % $imageCount],
                    'content' => base64_encode($content),
                    'status' => 1,
                    'view' => random_int(20, 4000),
                ]
            );
        }
    }
}
