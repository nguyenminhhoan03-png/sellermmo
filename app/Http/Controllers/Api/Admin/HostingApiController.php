<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class HostingApiController extends Controller
{
    public function getAccountCount(Request $request)
{
    $whmId = $request->id;

    $count = cpanel_GetUserCount(get_params_cpanel($whmId));

    return response()->json([
        'totalAccounts' => $count['totalAccounts'] ?? 0,
    ]);
}

}