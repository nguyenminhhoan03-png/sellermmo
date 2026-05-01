<?php

namespace App\Services\Blog;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BlogCrawlerService
{
  public function __construct(
    protected HtmlContentExtractorService $extractor,
  ) {
  }

  public function crawlSingle(string $url, int $categoryId, bool $status): array
  {
    $response = Http::timeout(30)
      ->withHeaders([
        'User-Agent' => 'Mozilla/5.0 (compatible; SellMMO-Bot/1.0)',
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
      ])
      ->get($url);

    if (!$response->successful()) {
      return ['ok' => false, 'message' => 'Không tải được bài viết từ URL này.'];
    }

    $data = $this->extractor->extractPostDataFromHtml($response->body(), $url);
    $slug = Post::generateSlug($data['title']);
    $user = User::find(Auth::id());

    Post::updateOrCreate(
      ['slug' => $slug],
      [
        'title' => $data['title'],
        'user_id' => $user?->id,
        'slug' => $slug,
        'status' => $status,
        'image' => $data['image'],
        'mota' => $data['mota'],
        'content' => $data['content'],
        'category_id' => $categoryId,
        'view' => 0,
      ]
    );

    return ['ok' => true, 'message' => 'Crawl bài viết thành công', 'data' => (object) $data];
  }

  public function crawlCategory(string $url, int $categoryId, bool $status, int $limit = 20): array
  {
    $response = Http::timeout(30)
      ->withHeaders([
        'User-Agent' => 'Mozilla/5.0 (compatible; SellMMO-Bot/1.0)',
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
      ])
      ->get($url);

    if (!$response->successful()) {
      return ['ok' => false, 'message' => 'Không tải được trang danh mục.'];
    }

    libxml_use_internal_errors(true);
    $dom = new \DOMDocument();
    $dom->loadHTML(mb_convert_encoding($response->body(), 'HTML-ENTITIES', 'UTF-8'));
    $xpath = new \DOMXPath($dom);

    $links = [];
    foreach ($xpath->query('//a[@href]') as $node) {
      if (!($node instanceof \DOMElement)) {
        continue;
      }

      $href = trim((string) $node->getAttribute('href'));
      if ($href === '' || str_starts_with($href, '#') || str_starts_with($href, 'javascript:')) {
        continue;
      }

      $href = $this->extractor->resolveUrl($url, $href);
      if ($href !== '') {
        $links[$href] = true;
      }
    }

    $count = 0;
    foreach (array_slice(array_keys($links), 0, $limit) as $link) {
      $result = $this->crawlSingle($link, $categoryId, $status);
      if ($result['ok']) {
        $count++;
      }
    }

    return ['ok' => true, 'message' => 'Đã crawl ' . $count . ' bài viết từ danh mục.', 'count' => $count];
  }

  public function crawlFeed(string $url, int $categoryId, bool $status, int $limit = 20): array
  {
    $response = Http::timeout(30)
      ->withHeaders([
        'User-Agent' => 'Mozilla/5.0 (compatible; SellMMO-Bot/1.0)',
        'Accept' => 'application/xml,text/xml,*/*;q=0.8',
      ])
      ->get($url);

    if (!$response->successful()) {
      return ['ok' => false, 'message' => 'Không tải được sitemap / RSS.'];
    }

    $xml = @simplexml_load_string($response->body());
    if (!$xml) {
      return ['ok' => false, 'message' => 'Nguồn feed không hợp lệ.'];
    }

    $urls = [];
    if (isset($xml->url)) {
      foreach ($xml->url as $node) {
        $loc = trim((string) $node->loc);
        if ($loc !== '') {
          $urls[] = $loc;
        }
      }
    } elseif (isset($xml->channel->item)) {
      foreach ($xml->channel->item as $node) {
        $link = trim((string) $node->link);
        if ($link !== '') {
          $urls[] = $link;
        }
      }
    }

    $count = 0;
    foreach (array_slice($urls, 0, $limit) as $link) {
      $result = $this->crawlSingle($link, $categoryId, $status);
      if ($result['ok']) {
        $count++;
      }
    }

    return ['ok' => true, 'message' => 'Đã crawl ' . $count . ' bài viết từ feed.', 'count' => $count];
  }

}
