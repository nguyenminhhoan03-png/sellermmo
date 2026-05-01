<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class RecentPurchaseController extends Controller
{
    private static array $cities = [
        'Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng', 'Cần Thơ',
        'Biên Hòa', 'Nha Trang', 'Huế', 'Vũng Tàu', 'Quy Nhơn',
        'Đà Lạt', 'Buôn Ma Thuột', 'Thái Nguyên', 'Nam Định', 'Vinh',
        'Bắc Giang', 'Bình Dương', 'Long Xuyên', 'Mỹ Tho', 'Phan Thiết',
    ];

    public function index()
    {
        $purchases = Cache::remember('recent_purchases_widget', 90, function () {
            $items = [];

            // ── Mua mã nguồn (tbl_his_code) ────────────────────────────
            $codes = DB::table('tbl_his_code as h')
                ->join('users as u', 'u.id', '=', 'h.user_id')
                ->join('tbl_list_code as p', 'p.id', '=', 'h.product_id')
                ->select(
                    'h.id',
                    'u.name as user_name',
                    'p.name as product_name',
                    'p.images as product_image',
                    'h.price',
                    'h.created_at',
                    DB::raw("'code' as type")
                )
                ->orderBy('h.id', 'desc')
                ->limit(6)
                ->get();

            foreach ($codes as $r) {
                $items[] = $this->format($r);
            }

            // ── Mua tài khoản AI (ai_accounts_order) ───────────────────
            $ai = DB::table('ai_accounts_order as o')
                ->join('users as u', 'u.id', '=', 'o.user_id')
                ->join('ai_accounts as a', 'a.id', '=', 'o.ai_account_id')
                ->leftJoin('ai_accounts_variant as v', 'v.id', '=', 'o.variant_id')
                ->select(
                    'o.id',
                    'u.name as user_name',
                    DB::raw("CONCAT(a.name, IFNULL(CONCAT(' – ', v.variant_name), '')) as product_name"),
                    'a.image as product_image',
                    'o.price',
                    'o.created_at',
                    DB::raw("'ai' as type")
                )
                ->where('o.status', '!=', 'canceled')
                ->orderBy('o.id', 'desc')
                ->limit(6)
                ->get();

            foreach ($ai as $r) {
                $items[] = $this->format($r);
            }

            // ── Mua domain (domain_order) ───────────────────────────────
            try {
                $domains = DB::table('domain_order as o')
                    ->join('users as u', 'u.id', '=', 'o.user_id')
                    ->select(
                        'o.id',
                        'u.name as user_name',
                        DB::raw("CONCAT('Tên miền: ', o.domain_name) as product_name"),
                        DB::raw("NULL as product_image"),
                        'o.price',
                        'o.created_at',
                        DB::raw("'domain' as type")
                    )
                    ->orderBy('o.id', 'desc')
                    ->limit(4)
                    ->get();

                foreach ($domains as $r) {
                    $items[] = $this->format($r);
                }
            } catch (\Throwable) {}

            // ── Mua Hosting (tbl_purchased_hosting) ────────────────────
            try {
                $hostings = DB::table('tbl_purchased_hosting as h')
                    ->join('users as u', 'u.id', '=', 'h.user_id')
                    ->select(
                        'h.id',
                        'u.name as user_name',
                        DB::raw("CONCAT('Hosting: ', h.domain_name) as product_name"),
                        DB::raw("NULL as product_image"),
                        'h.total as price',
                        'h.created_at',
                        DB::raw("'hosting' as type")
                    )
                    ->orderBy('h.id', 'desc')
                    ->limit(4)
                    ->get();

                foreach ($hostings as $r) {
                    $items[] = $this->format($r);
                }
            } catch (\Throwable) {}

            // ── Thuê CronJob (list_url_cron) ────────────────────────────
            try {
                $crons = DB::table('list_url_cron as c')
                    ->join('users as u', 'u.id', '=', 'c.user_id')
                    ->select(
                        'c.id',
                        'u.name as user_name',
                        DB::raw("'Dịch vụ CronJob' as product_name"),
                        DB::raw("NULL as product_image"),
                        'c.price',
                        'c.created_at',
                        DB::raw("'cron' as type")
                    )
                    ->where('c.price', '>', 0)
                    ->orderBy('c.id', 'desc')
                    ->limit(3)
                    ->get();

                foreach ($crons as $r) {
                    $items[] = $this->format($r);
                }
            } catch (\Throwable) {}

            // Sắp xếp theo thời gian mới nhất, lấy 15 item
            usort($items, fn($a, $b) => strtotime($b['raw_time']) - strtotime($a['raw_time']));

            return array_slice($items, 0, 15);
        });

        return response()->json($purchases);
    }

    private function format(object $row): array
    {
        $name = $row->user_name ?? 'Ẩn danh';
        // Ẩn một phần tên để bảo mật (chỉ giữ ký tự đầu)
        $masked = mb_substr($name, 0, 1) . str_repeat('*', min(mb_strlen($name) - 1, 4));

        $image = $row->product_image ?? null;
        if ($image && !preg_match('#^https?://#i', $image)) {
            $image = '/' . ltrim($image, '/');
        }

        // Random city cho social proof
        $city = self::$cities[crc32($row->user_name . $row->product_name) % count(self::$cities)];

        return [
            'user_name'     => $masked,
            'product_name'  => $row->product_name,
            'product_image' => $image,
            'price'         => (int) $row->price,
            'type'          => $row->type, 
            'city'          => $city,
            'raw_time'      => $row->created_at,
            'time_ago'      => $this->timeAgo($row->created_at),
            'avatar_letter' => mb_strtoupper(mb_substr($name, 0, 1)),
            'avatar_color'  => $this->avatarColor($name),
        ];
    }

    private function timeAgo(?string $time): string
    {
        if (!$time) return 'vừa xong';
        $diff = time() - strtotime($time);
        if ($diff < 60)  return $diff . ' giây trước';
        if ($diff < 3600) return floor($diff / 60) . ' phút trước';
        if ($diff < 86400) return floor($diff / 3600) . ' giờ trước';
        return floor($diff / 86400) . ' ngày trước';
    }

    private function avatarColor(string $name): string
    {
        $colors = ['#6c63ff', '#e94560', '#17a589', '#f39c12', '#2980b9', '#8e44ad', '#27ae60'];
        return $colors[crc32($name) % count($colors)];
    }
}
