<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCategory;

class SlugController extends Controller
{
    public function Slug(Request $request)
    {
        $payload = $request->validate([
            'title'       => 'nullable|string|max:255',
          ]);
        $slug = PostCategory::generateSlug($payload['title']);
        return response()->json([$slug], 200);
    }
}
