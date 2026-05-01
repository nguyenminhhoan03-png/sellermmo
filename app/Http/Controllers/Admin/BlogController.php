<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use App\Services\Blog\BlogCrawlerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
  public function __construct(
    protected BlogCrawlerService $blogCrawlerService,
  ) {
  }

  public function index()
  {
    $post = Post::all();

    return view('admin.blog.index', compact('post'));
  }

  public function blog()
  {
    $category = PostCategory::where('status', 1)->get();

    return view('admin.blog.blog', compact('category'));
  }

  public function crawlPage()
  {
    $category = PostCategory::where('status', 1)->get();

    return view('admin.blog.crawl', compact('category'));
  }

  public function crawlSinglePost(Request $request)
  {
    $payload = $request->validate([
      'url' => 'required|url',
      'category_id' => 'required|integer',
      'status' => 'required|boolean',
    ]);

    $result = $this->blogCrawlerService->crawlSingle(
      $payload['url'],
      (int) $payload['category_id'],
      (bool) $payload['status']
    );

    if (!($result['ok'] ?? false)) {
      return back()->with('error', $result['message'] ?? 'Crawl thất bại.');
    }

    Helper::addLogs('Crawl bài viết ' . ($result['data']->title ?? ''), ['url' => $payload['url']]);

    return back()->with('success', $result['message'] ?? 'Crawl bài viết thành công');
  }

  public function crawlCategory(Request $request)
  {
    $payload = $request->validate([
      'url' => 'required|url',
      'category_id' => 'required|integer',
      'status' => 'required|boolean',
      'limit' => 'nullable|integer|min:1|max:200',
    ]);

    $result = $this->blogCrawlerService->crawlCategory(
      $payload['url'],
      (int) $payload['category_id'],
      (bool) $payload['status'],
      (int) ($payload['limit'] ?? 20)
    );

    if (!($result['ok'] ?? false)) {
      return back()->with('error', $result['message'] ?? 'Crawl danh mục thất bại.');
    }

    Helper::addLogs('Crawl danh mục ' . $payload['url'], ['url' => $payload['url'], 'count' => $result['count'] ?? 0]);

    return back()->with('success', $result['message'] ?? 'Crawl danh mục thành công');
  }

  public function crawlFeed(Request $request)
  {
    $payload = $request->validate([
      'url' => 'required|url',
      'category_id' => 'required|integer',
      'status' => 'required|boolean',
      'limit' => 'nullable|integer|min:1|max:200',
    ]);

    $result = $this->blogCrawlerService->crawlFeed(
      $payload['url'],
      (int) $payload['category_id'],
      (bool) $payload['status'],
      (int) ($payload['limit'] ?? 20)
    );

    if (!($result['ok'] ?? false)) {
      return back()->with('error', $result['message'] ?? 'Crawl feed thất bại.');
    }

    Helper::addLogs('Crawl sitemap/RSS ' . $payload['url'], ['url' => $payload['url'], 'count' => $result['count'] ?? 0]);

    return back()->with('success', $result['message'] ?? 'Crawl feed thành công');
  }

  public function blogPost(Request $request)
  {
    $payload = $request->validate([
      'title' => 'nullable|string|max:255',
      'slug' => 'required|string',
      'status' => 'required|boolean',
      'content' => 'required|string',
      'mota' => 'nullable|string|max:350',
      'category_id' => 'required',
      'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:10000',
    ]);

    $user = User::find(Auth::id());
    if (!$request->hasFile('image')) {
      return redirect()->to(route('admin.blog.add'))->with('error', 'Hành động của bạn không hợp lệ !!!');
    }

    $photo = $request->file('image');
    $client_id = '4ec3406826c04ac';
    $url = uploadImageToImgur($photo, $client_id);
    if ($url == '0') {
      return redirect()->to(route('admin.blog.add'))->with('error', 'Hành động của bạn không hợp lệ !!!');
    } elseif ($url == '1') {
      return redirect()->to(route('admin.blog.add'))->with('error', 'Không thể upload ảnh của bạn, hãy thử lại!');
    }

    $payload['image'] = $url;

    if (empty($payload['title'])) {
      $payload['slug'] = 'post-' . rand(1000, 9999);
    }

    Post::create([
      'title' => $payload['title'],
      'user_id' => $user->id,
      'slug' => $payload['slug'],
      'status' => $payload['status'],
      'image' => $payload['image'],
      'mota' => $payload['mota'],
      'content' => $payload['content'],
      'category_id' => $payload['category_id'],
      'view' => 0,
    ]);

    Helper::addLogs('Thêm bài viết ' . $payload['title'], $payload);

    return redirect()->to(route('admin.blog.add'))->with('success', 'Thêm bài viết thành công');
  }

  public function edit($id)
  {
    $row = Post::find($id);
    if (!$row) {
      return redirect()->route('admin.blog.index')->with('error', 'Blog not found');
    }

    $category = PostCategory::where('status', 1)->get();

    return view('admin.blog.edit', [
      'pageTitle' => 'Chi tiết bài viết #' . $row->id,
    ], compact('row', 'category'));
  }

  public function editPost(Request $request)
  {
    $payload = $request->validate([
      'id' => 'required|integer',
      'title' => 'nullable|string|max:255',
      'slug' => 'required|string',
      'mota' => 'nullable|string|max:350',
      'status' => 'required|boolean',
      'content' => 'required|string',
      'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:10000',
      'category_id' => 'required',
    ]);

    $post = Post::find($payload['id']);
    if (!$post) {
      return redirect()->route('admin.blog.index')->with('error', 'Không tìm thấy bài viết #' . $payload['id']);
    }

    if ($request->hasFile('image')) {
      $photo = $request->file('image');
      $client_id = '4ec3406826c04ac';
      $url = uploadImageToImgur($photo, $client_id);
      if ($url == '0') {
        return redirect()->to(route('admin.blog.edit', $payload['id']))->with('error', 'Hành động của làm lại, hãy thử được thay đổi!');
      } elseif ($url == '1') {
        return redirect()->to(route('admin.blog.edit', $payload['id']))->with('error', 'Không thể upload ảnh của không hợp lệ !!!');
      }

      $payload['image'] = $url;
    } else {
      $payload['image'] = $post->image;
    }

    if (empty($payload['title'])) {
      $payload['slug'] = 'post-' . rand(1000, 9999);
    }

    $post->update($payload);

    Helper::addLogs('Sửa lại bài viết #' . $payload['id'], $payload);

    return redirect()->to(route('admin.blog.edit', $payload['id']))->with('success', 'Sửa lại bài viết #' . $payload['id']);
  }

  public function ckeditorUpload(Request $request)
  {
    $funcNum = (int) $request->input('CKEditorFuncNum', 0);
    $errorResponse = function (string $message, int $status = 422) use ($request, $funcNum) {
      if ($request->filled('CKEditorFuncNum') || $funcNum > 0) {
        $safeMessage = e($message);

        return response("<script>window.parent.CKEDITOR.tools.callFunction({$funcNum}, '', '{$safeMessage}');</script>")
          ->header('Content-Type', 'text/html; charset=UTF-8');
      }

      return response()->json([
        'uploaded' => 0,
        'error' => ['message' => $message],
      ], $status);
    };

    $uploadField = $request->hasFile('upload') ? 'upload' : ($request->hasFile('file') ? 'file' : null);
    if ($uploadField === null) {
      return $errorResponse('Không tìm thấy file upload.');
    }

    $file = $request->file($uploadField);
    if (!$file->isValid()) {
      return $errorResponse('File upload không hợp lệ.');
    }

    $client_id = '4ec3406826c04ac';
    $stored = uploadImageToImgur($file, $client_id, 'blog-content', 'blog-' . str()->random(8));

    if ($stored === '0' || $stored === '1' || $stored === 0 || $stored === null) {
      return $errorResponse('Upload ảnh thất bại, vui lòng thử lại.');
    }

    $imageUrl = img_url($stored);

    if ($request->filled('CKEditorFuncNum') || $funcNum > 0) {
      $safeUrl = e($imageUrl);
      $message = e('Upload thành công');

      return response("<script>window.parent.CKEDITOR.tools.callFunction({$funcNum}, '{$safeUrl}', '{$message}');</script>")
        ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    return response()->json([
      'uploaded' => 1,
      'fileName' => basename($stored),
      'url' => $imageUrl,
    ]);
  }

  public function PostDelete(Request $request)
  {
    if ($request->has('ids')) {
      $payload = $request->validate([
        'ids' => 'required|array',
      ]);

      $ids = array_map('intval', $payload['ids']);
      $pay = Post::whereIn('id', $ids)->get();

      foreach ($pay as $pays) {
        $pays->delete();
      }

      Helper::addLogs(__('Thực hiện thao tác xóa nhiều bài viết cùng lúc; số lượng: :count', ['count' => $pay->count()]));

      return response()->json([
        'status' => 200,
        'message' => 'Post deleted successfully.',
      ]);
    }

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $pay = Post::where('id', $payload['id'])->firstOrFail();
    $pay->delete();

    Helper::addLogs('Xóa bài viết #' . $pay->trans_id);

    return response()->json([
      'status' => 200,
      'message' => 'Post deleted successfully.',
    ]);
  }

  public function category(Request $request)
  {
    $category = PostCategory::get();

    return view('admin.blog.category', compact('category'));
  }

  public function categoryPost(Request $request)
  {
    $payload = $request->validate([
      'name' => 'nullable|string|max:255',
      'status' => 'required|boolean',
      'slug' => 'required|string',
    ]);

    PostCategory::create([
      'name' => $payload['name'],
      'slug' => $payload['slug'],
      'status' => $payload['status'],
    ]);

    Helper::addLogs('Thêm bài viết ' . $payload['name'], $payload);

    return redirect()->to(route('admin.blog.category'))->with('success', 'Thêm bài viết thành công');
  }

  public function categoryUpdate(Request $request)
  {
    $payload = $request->validate([
      'id' => 'required|integer',
      'name' => 'nullable|string|max:255',
      'status' => 'required|boolean',
      'slug' => 'required|string',
    ]);

    $category = PostCategory::find($payload['id']);
    $category->update($payload);
    Helper::addLogs('Cập nhật bài viết ' . $payload['name'], $payload);

    return redirect()->to(route('admin.blog.category'))->with('success', 'Thêm bài viết thành công');
  }

  public function categoryDelete(Request $request)
  {
    if ($request->has('ids')) {
      $payload = $request->validate([
        'ids' => 'required|array',
      ]);

      $ids = array_map('intval', $payload['ids']);
      $pay = PostCategory::whereIn('id', $ids)->get();

      foreach ($pay as $pays) {
        $pays->delete();
      }

      Helper::addLogs(__('Thực hiện thao tác xóa nhiều chuyên mục cùng lúc; số lượng: :count', ['count' => $pay->count()]));

      return response()->json([
        'status' => 200,
        'message' => 'PostCategory deleted successfully.',
      ]);
    }

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $pay = PostCategory::where('id', $payload['id'])->firstOrFail();
    $pay->delete();

    Helper::addLogs('Xóa chuyên mục #' . $pay->trans_id);

    return response()->json([
      'status' => 200,
      'message' => 'PostCategory deleted successfully.',
    ]);
  }
}
