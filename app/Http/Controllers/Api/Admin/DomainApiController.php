<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DomainApiController extends Controller
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
    
        $query = \App\Models\Domain::query();
    
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
    
        $total = $query->count();
    
        $data = $query->select([
                'id',
                'name',
                'price',
                'extend_price',
                'sale',
                'status',
                'created_at',
            ])
            ->skip($offset)
            ->take($limit)
            ->orderBy($sort_by, $sort_type)
            ->get();
        $data = $data->map(function ($item) {
            return [
                'id'        => $item->id,
                'name'      => $item->name,
                'price'     => formatCurrency($item->price),
                'extend_price'     => formatCurrency($item->extend_price),
                'sale'     => $item->sale. '%',
                'status'    => $item->status,
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
