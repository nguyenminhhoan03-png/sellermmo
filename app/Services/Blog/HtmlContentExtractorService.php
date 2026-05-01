<?php

namespace App\Services\Blog;

use DOMDocument;
use DOMNode;
use DOMXPath;
use Illuminate\Support\Str;

class HtmlContentExtractorService
{
  protected array $contentSelectors = [
    '//article',
    '//*[@id="content"]',
    '//*[@id="main-content"]',
    '//*[@id="article-content"]',
    '//*[contains(@class, "entry-content")]',
    '//*[contains(@class, "post-content")]',
    '//*[contains(@class, "article-content")]',
    '//*[contains(@class, "content-detail")]',
    '//*[contains(@class, "content")]',
    '//*[contains(@class, "post")]',
    '//*[contains(@class, "detail")]',
    '//main',
  ];

  protected array $removeSelectors = [
    './/script',
    './/style',
    './/noscript',
    './/svg',
    './/iframe',
    './/header',
    './/footer',
    './/nav',
    './/aside',
    './/form',
    './/button',
    './/*[contains(@class, "ads")]',
    './/*[contains(@class, "advert")]',
  ];

  public function extract(DOMDocument $dom, DOMXPath $xpath): string
  {
    $bestHtml = '';
    $bestLength = 0;

    foreach ($this->contentSelectors as $selector) {
      $nodes = $xpath->query($selector);
      if (!$nodes || $nodes->length === 0) {
        continue;
      }

      foreach ($nodes as $node) {
        if (!$node instanceof DOMNode) {
          continue;
        }

        $htmlCandidate = $this->cleanNodeHtml($dom, $xpath, $node);
        $textCandidate = trim(preg_replace('/\s+/', ' ', strip_tags($htmlCandidate)));
        $length = mb_strlen($textCandidate);

        if ($length > $bestLength) {
          $bestLength = $length;
          $bestHtml = $htmlCandidate;
        }
      }
    }

    if ($bestHtml === '') {
      $body = $xpath->query('//body')->item(0);
      if ($body instanceof DOMNode) {
        $bestHtml = $this->cleanNodeHtml($dom, $xpath, $body);
      }
    }

    return trim($bestHtml);
  }

  public function normalizeExcerpt(string $content): string
  {
    return Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($content))), 300, '');
  }

  public function extractPostDataFromHtml(string $html, string $fallbackUrl = ''): array
  {
    libxml_use_internal_errors(true);

    $dom = new DOMDocument();
    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    $xpath = new DOMXPath($dom);

    $metaTitle = $xpath->query('//meta[@property="og:title"]/@content')->item(0);
    $metaDesc = $xpath->query('//meta[@name="description"]/@content')->item(0);
    $metaImage = $xpath->query('//meta[@property="og:image"]/@content')->item(0);
    $canonical = $xpath->query('//link[@rel="canonical"]/@href')->item(0);
    $h1 = $xpath->query('//h1')->item(0);

    $content = $this->extract($dom, $xpath);

    $title = trim((string) ($metaTitle?->nodeValue ?: ($h1?->textContent ?: '')));
    $mota = trim((string) ($metaDesc?->nodeValue ?: ''));
    $image = trim((string) ($metaImage?->nodeValue ?: ''));
    $canonicalUrl = trim((string) ($canonical?->nodeValue ?: $fallbackUrl));

    if ($title === '') {
      $title = 'Bài crawl ' . now()->format('YmdHis');
    }

    if ($mota === '') {
      $mota = $this->normalizeExcerpt($content);
    }

    if ($image !== '' && $fallbackUrl !== '') {
      $image = $this->resolveUrl($fallbackUrl, $image);
    }

    return [
      'title' => $title,
      'mota' => $mota,
      'content' => $content,
      'image' => $image,
      'canonical_url' => $canonicalUrl,
    ];
  }

  public function resolveUrl(string $baseUrl, string $href): string
  {
    $href = trim($href);
    if ($href === '') {
      return '';
    }

    if (preg_match('#^https?://#i', $href)) {
      return $href;
    }

    if (str_starts_with($href, '//')) {
      $scheme = parse_url($baseUrl, PHP_URL_SCHEME) ?: 'https';
      return $scheme . ':' . $href;
    }

    $baseParts = parse_url($baseUrl);
    if (!$baseParts || empty($baseParts['host'])) {
      return $href;
    }

    $scheme = $baseParts['scheme'] ?? 'https';
    $host = $baseParts['host'];
    $port = isset($baseParts['port']) ? ':' . $baseParts['port'] : '';
    $path = $baseParts['path'] ?? '/';
    $dir = rtrim(str_replace('\\', '/', dirname($path)), '/');
    $prefix = $dir === '/' ? '' : $dir;

    if (str_starts_with($href, '/')) {
      return $scheme . '://' . $host . $port . $href;
    }

    return $scheme . '://' . $host . $port . $prefix . '/' . ltrim($href, '/');
  }

  protected function cleanNodeHtml(DOMDocument $dom, DOMXPath $xpath, DOMNode $node): string
  {
    $clone = $node->cloneNode(true);

    foreach ($this->removeSelectors as $selector) {
      $nodes = $xpath->query($selector, $clone);
      if (!$nodes) {
        continue;
      }

      foreach (iterator_to_array($nodes) as $removeNode) {
        if ($removeNode instanceof DOMNode && $removeNode->parentNode) {
          $removeNode->parentNode->removeChild($removeNode);
        }
      }
    }

    $html = '';
    foreach ($clone->childNodes as $child) {
      $html .= $dom->saveHTML($child);
    }

    return trim($html);
  }
}
