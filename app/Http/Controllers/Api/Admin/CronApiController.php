<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeverCron;
use App\Models\User;

class CronApiController extends Controller
{
    public function index(Request $request)
    {
        $payload = $request->validate([
            'page'        => 'nullable|integer|min:1',
            'limit'       => 'nullable|integer|min:1',
            'search'      => 'nullable|string|max:255',
            'sort_by'     => 'nullable|string|max:255',
            'sort_type'   => 'nullable|string|in:asc,desc',
        ]);
    
        $page      = $payload['page'] ?? 1;
        $limit     = $payload['limit'] ?? 10;
        $search    = $payload['search'] ?? null;
        $offset    = ($page - 1) * $limit;
        $sort_by   = $payload['sort_by'] ?? 'id';
        $sort_type = $payload['sort_type'] ?? 'asc';
    
        $query = \App\Models\CronOrder::query();
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('url', 'like', '%' . $search . '%')
                  ->orWhere('status', 'like', '%' . $search . '%')
                  ->orWhere('user_id', 'like', '%' . $search . '%');
            });
        }
        $total = $query->count();
    
        $data = $query->select([
                'id',
                'user_id',
                'id_server',
                'url',
                'second',
                'status',
                'response',
                'time_his',
                'expired_date',
                'expired_timestamp',
                'created_at',
            ])
            ->skip($offset)
            ->take($limit)
            ->orderBy($sort_by, $sort_type)
            ->get();
        $data = $data->map(function ($item) {
           $user = User::find($item->user_id);
           $server = SeverCron::find($item->id_server);
            return [
                'id'        => $item->id,
                'user_id'      => $item->user_id,
                'user_name'    => $user->username,
                'url' => $item->url,
                'second' => $item->second,
                'server_name' => $server->name,
                'status'    => $item->status,
                'response'  => $item->response,
                'time_his'  => $item->time_his,
                'time_his_ago' => Helper::getTimeAgo($item->time_his),
                'expired_date' => $item->expired_date,
                'expired_timestamp' => $item->expired_timestamp,
                'expired_timestamp_ago' => Helper::time_His($item->expired_timestamp),
                'created_at'=> $item->created_at->format('Y-m-d H:i:s'),
                'created_time_ago' => Helper::getTimeAgo($item->created_at->format('Y-m-d H:i:s')),
            ];
        });
    
        return response()->json([
            'data'    => [
                'meta' => [
                    'page'  => (int) $page,
                    'total' => (int) $total,
                    'limit' => (int) $limit,
                ],
                'data' => $data,
            ],
            'status'  => 200,
            'message' => 'Get data success',
        ]);
    }
    
}
