<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function index(Request $request)
  {
    $payload = $request->validate([
      'page'      => 'nullable|integer|min:1',
      'limit'     => 'nullable|integer|min:1',
      'search'    => 'nullable|string|max:255',
      'sort_by'   => 'nullable|string|max:255',
      'sort_type' => 'nullable|string|in:asc,desc',
    ]);

    $page      = $payload['page'] ?? 1;
    $limit     = $payload['limit'] ?? 10;
    $search    = $payload['search'] ?? null;
    $offset    = ($page - 1) * $limit;
    $sort_by   = $payload['sort_by'] ?? 'id';
    $sort_type = $payload['sort_type'] ?? 'asc';

    $query = \App\Models\User::query();

    if ($search) {
      $query->where('username', 'like', '%' . $search . '%')
        ->orWhere('email', 'like', '%' . $search . '%')
        ->orWhere('ip', 'like', '%' . $search . '%');
    }

    $total = $query->count();

    $data = $query->skip($offset)
      ->take($limit)
      ->orderBy($sort_by, $sort_type)
      ->get();
      $data = $data->map(function ($item) {
         return [
             'id'        => $item->id,
             'username'      => $item->username,
             'chat_id'    => $item->chat_id,
             'name' => $item->name,
             'email' => $item->email,
             'level' => $item->level,
             'ip'    => $item->ip,
             'balance'  => $item->balance,
             'balance_ctv'  => $item->balance_ctv,
             'total_deposit' => $item->total_deposit,
             'banned' => $item->banned,
             'loai' => $item->loai,
             'time_request' => $item->time_request,
             'created_at'=> $item->created_at->format('Y-m-d H:i:s'),
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