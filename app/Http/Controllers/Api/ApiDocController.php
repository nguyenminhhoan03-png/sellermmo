<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiDocController extends Controller
{
    public function ApiDocs()
    {
        return view('fe.apidoc', [
           'pageTitle' => 'Tài Liệu API',
       ]);

    }
}
