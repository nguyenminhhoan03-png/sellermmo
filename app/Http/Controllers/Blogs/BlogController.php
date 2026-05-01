<?php

namespace App\Http\Controllers\Blogs;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function showBlogs(Request $request)
    {
        $categorySlug = trim((string) $request->query('category', ''));
        $keyword = trim((string) $request->query('q', ''));

        $selectedCategory = null;
        $baseQuery = Post::query()
            ->where('status', 1)
            ->with([
                'user:id,name',
                'category:id,name,slug',
            ]);

        if ($categorySlug !== '') {
            $selectedCategory = PostCategory::where('status', 1)
                ->where('slug', $categorySlug)
                ->first();

            if ($selectedCategory) {
                $baseQuery->where('category_id', $selectedCategory->id);
            }
        }

        if ($keyword !== '') {
            $baseQuery->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('mota', 'like', '%' . $keyword . '%')
                    ->orWhere('content', 'like', '%' . $keyword . '%');
            });
        }

        $featuredPosts = (clone $baseQuery)
            ->orderByDesc('view')
            ->orderByDesc('id')
            ->take(3)
            ->get();

        $posts = (clone $baseQuery)
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        $popularPosts = Post::where('status', 1)
            ->with(['user:id,name', 'category:id,name,slug'])
            ->orderByDesc('view')
            ->orderByDesc('id')
            ->take(6)
            ->get();

        $latestPosts = Post::where('status', 1)
            ->with(['user:id,name', 'category:id,name,slug'])
            ->orderByDesc('id')
            ->take(6)
            ->get();

        $categories = PostCategory::where('status', 1)
            ->withCount([
                'posts as posts_count' => function ($q) {
                    $q->where('status', 1);
                },
            ])
            ->orderBy('name')
            ->get();

        $categorySections = collect();
        if ($categorySlug === '' && $keyword === '') {
            $sectionCategories = PostCategory::where('status', 1)
                ->withCount([
                    'posts as posts_count' => function ($q) {
                        $q->where('status', 1);
                    },
                ])
                ->having('posts_count', '>', 0)
                ->orderByDesc('posts_count')
                ->orderBy('name')
                ->take(8)
                ->get();

            if ($sectionCategories->isNotEmpty()) {
                $postsByCategory = Post::where('status', 1)
                    ->whereIn('category_id', $sectionCategories->pluck('id'))
                    ->with(['user:id,name', 'category:id,name,slug'])
                    ->orderByDesc('id')
                    ->get()
                    ->groupBy('category_id');

                $categorySections = $sectionCategories->map(function (PostCategory $category) use ($postsByCategory) {
                    $category->section_posts = ($postsByCategory[$category->id] ?? collect())->take(4)->values();
                    return $category;
                });
            }
        }

        return view('blogs.index', [
            'pageTitle' => 'Tin tức & Hướng dẫn',
            'posts' => $posts,
            'featuredPosts' => $featuredPosts,
            'popularPosts' => $popularPosts,
            'latestPosts' => $latestPosts,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'keyword' => $keyword,
            'categorySlug' => $categorySlug,
            'categorySections' => $categorySections,
        ]);
    }

    public function viewBlogs(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 1)
            ->with([
                'user:id,name,level',
                'category:id,name,slug',
            ])
            ->first();

        if (!$post) {
            return redirect()->route('home')->with('error', 'Bài viết này không tồn tại hoặc đã bị ẩn.');
        }

        $post->increment('view');
        $post->refresh();

        $categoryList = PostCategory::where('status', 1)
            ->withCount([
                'posts as posts_count' => function ($q) {
                    $q->where('status', 1);
                },
            ])
            ->orderBy('name')
            ->get();

        $relatedPosts = Post::where('status', 1)
            ->where('id', '!=', $post->id)
            ->when($post->category_id, function ($q) use ($post) {
                $q->where('category_id', $post->category_id);
            })
            ->with(['user:id,name'])
            ->orderByDesc('id')
            ->take(5)
            ->get();

        $latestPosts = Post::where('status', 1)
            ->where('id', '!=', $post->id)
            ->with(['user:id,name'])
            ->orderByDesc('id')
            ->take(5)
            ->get();

        $highlightPosts = Post::where('status', 1)
            ->where('id', '!=', $post->id)
            ->with(['user:id,name', 'category:id,name,slug'])
            ->orderByDesc('view')
            ->orderByDesc('id')
            ->take(9)
            ->get();

        return view('blogs.view', [
            'pageTitle' => $post->title,
            'post' => $post,
            'categories' => $categoryList,
            'relatedPosts' => $relatedPosts,
            'latestPosts' => $latestPosts,
            'highlightPosts' => $highlightPosts,
        ]);
    }
}