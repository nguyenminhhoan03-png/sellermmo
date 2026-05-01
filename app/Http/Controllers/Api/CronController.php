<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CronController
{
    public function getCronData(Request $request)
{
    $id = $request->query('code');
    if (!$id) {
        return response()->json(['msg' => 'Lỗi, thiếu tham số code'], 400);
    }

    $rows = DB::table('list_url_cron')
        ->whereIn('status', ['hoatdong', 'loi'])
        ->where('id_server', $id)
        ->get();

    $row2 = DB::table('sever_crons')
        ->where('status', '1')
        ->where('id', $id)
        ->first();

    if ($rows->isNotEmpty() || $row2) {
        $code = $rows->map(function ($item) {
            return [
                'id' => $item->id ?? null,
                'method' => 'GET',
                'cron_expression' => '*/' . ($item->second ?? 60) . ' * * * * *',
                'url' => $item->url ?? null,
                'headers' => null,
                'body' => null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $code
        ], 200, [], JSON_PRETTY_PRINT);
    }

    return response()->json([
        'status' => 'error',
        'msg' => 'Không Tồn Tại Máy Chủ Này'
    ], 404);
    }
    public function updateCron(Request $request)
    {
        $data = $request->json()->all();

        if (empty($data) || !isset($data['status_code']) || !isset($data['id'])) {
            return response()->json(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ hoặc thiếu thông tin'], 400);
        }

        $response = $data['status_code'];
        $id = $data['id'];

        $row = DB::table('list_url_cron')
            ->whereIn('status', ['hoatdong', 'loi'])
            ->where('id', $id)
            ->first();

        if (!$row) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy dữ liệu'], 404);
        }

        if ($response == 200) {
            $noti = 'Đang chạy 200';
        } elseif ($response == 'timeout') {
            $noti = "Request timed out";
        } else {
            $noti = 'Mã lỗi: ' . $response;
        }
        $time_his = Carbon::now()->format('Y-m-d H:i:s');

        if ($row->expired_timestamp < time()) {
            DB::table('list_url_cron')
                ->where('id', $id)
                ->update([
                    'status' => 'hethan',
                    'time_his' => $time_his,
                ]);
        }

        DB::table('list_url_cron')
            ->where('id', $id)
            ->update([
                'response' => $noti,
                'time_his' => $time_his,
            ]);

        return response()->json(['status' => 'success', 'message' => 'Cập nhật thành công']);
    }
    public function updateCron403(Request $request) {
        return abort(403);
    }
}
