@extends('layouts.app')
@section('title', $pageTitle)
@section('description', \Illuminate\Support\Str::limit(strip_tags(base64_decode($post->mota, true) ?: $post->mota), 160))
@section('content')
@php
  $decodeText = function (?string $value): string {
    if (!$value) return '';
    $decoded = base64_decode($value, true);
    return $decoded !== false ? $decoded : $value;
  };
  $postContent = $decodeText($post->content);
  $postSummary = strip_tags($decodeText($post->mota));
  $author = $post->user;
@endphp
<style>
.post-page{
  --post-surface: rgba(255,255,255,.86);
  --post-border: rgba(255,255,255,.56);
  --post-shadow: 0 10px 30px rgba(15,23,42,.10);
  --post-text: #1f2937;
  --post-muted: #6b7280;
  --post-soft: rgba(249,250,252,.78);
  --post-toc-bg: rgba(238,246,255,.82);
  --post-toc-border: rgba(145,195,255,.6);
}
[data-bs-theme="dark"] .post-page{
  --post-surface: rgba(18,24,38,.70);
  --post-border: rgba(148,163,184,.20);
  --post-shadow: 0 12px 34px rgba(2,6,23,.45);
  --post-text: #e5e7eb;
  --post-muted: #9ca3af;
  --post-soft: rgba(30,41,59,.52);
  --post-toc-bg: rgba(19,42,74,.58);
  --post-toc-border: rgba(69,132,215,.58);
}
.post-wrap,.post-side{
  background:var(--post-surface);
  border:1px solid var(--post-border);
  box-shadow:var(--post-shadow);
  backdrop-filter: blur(10px);
}
.post-wrap{border-radius:16px;overflow:hidden}
.post-sticky{position:sticky;top:96px}
.post-cover{width:100%;height:360px;object-fit:cover}
.post-body{padding:20px}
.post-title{font-size:1.9rem;font-weight:800;line-height:1.35;color:var(--post-text);margin:0 0 10px}
.post-meta{display:flex;gap:14px;flex-wrap:wrap;color:var(--post-muted);font-size:.83rem;margin-bottom:16px}
.post-summary{font-size:.95rem;color:var(--post-muted);background:var(--post-soft);border-left:4px solid #e94560;padding:12px 14px;border-radius:8px;margin-bottom:18px}
.post-content{font-size:1rem;line-height:1.8;color:var(--post-text)}
.post-content img{max-width:100%;height:auto;border-radius:12px}
.post-side{border-radius:14px;padding:14px}
.post-side-title{font-size:.95rem;font-weight:800;margin-bottom:10px;color:var(--post-text)}
.side-item{display:flex;gap:10px;padding:8px 0;border-bottom:1px dashed var(--post-border)}
.side-item:last-child{border-bottom:none}
.side-item img{width:72px;height:52px;object-fit:cover;border-radius:8px}
.side-item a{font-size:.83rem;font-weight:700;color:var(--post-text);text-decoration:none;line-height:1.35}
.side-item small{color:var(--post-muted)}
.cat-link{display:flex;justify-content:space-between;align-items:center;text-decoration:none;background:var(--post-soft);border:1px solid var(--post-border);border-radius:10px;padding:8px 10px;margin-bottom:8px;color:var(--post-muted);font-size:.83rem;font-weight:600}
.cat-link:hover{border-color:#e94560;color:#e94560;background:#fff0f3}
.author-box{background:var(--post-soft);border:1px dashed var(--post-border);border-radius:12px;padding:14px;margin-top:18px;color:var(--post-text)}
.toc-box{background:var(--post-toc-bg);border:1px solid var(--post-toc-border);border-radius:12px;padding:12px 14px;margin:14px 0}
.toc-box h6{margin:0 0 8px;font-size:.88rem;font-weight:800;color:var(--post-text)}
.toc-box ol{margin:0;padding-left:18px}
.toc-box li{margin:4px 0}
.toc-box a{font-size:.84rem;color:#0d5abf;text-decoration:none}
.toc-box a:hover{text-decoration:underline}
.highlight-wrap{margin-top:22px;background:var(--post-surface);border:1px solid var(--post-border);box-shadow:var(--post-shadow);border-radius:14px;padding:14px}
.highlight-title{font-size:1.05rem;font-weight:800;color:var(--post-text);margin-bottom:12px}
.highlight-item{display:flex;flex-direction:column;height:100%;text-decoration:none;color:inherit}
.highlight-item img{width:100%;height:170px;border-radius:10px;object-fit:cover}
.highlight-item .t{font-size:1.03rem;font-weight:800;line-height:1.4;color:var(--post-text);margin-top:9px;display:-webkit-box;-webkit-line-clamp:2;line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.highlight-item .d{font-size:.92rem;color:var(--post-muted);margin-top:8px;display:-webkit-box;-webkit-line-clamp:3;line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
.highlight-item .m{font-size:.8rem;color:var(--post-muted);margin-top:auto;padding-top:8px}
@media(max-width:1199px){.post-sticky{position:static;top:auto}}
</style>

<div id="kt_content_container" class="container-xxl py-5 post-page">
  <div class="mb-3 text-muted fs-7">
    <a href="/" class="text-muted text-hover-primary text-decoration-none">Home</a>
    <span class="mx-2">/</span>
    <a href="{{ route('blogs') }}" class="text-muted text-hover-primary text-decoration-none">Blog</a>
    <span class="mx-2">/</span>
    <span>{{ $post->slug }}</span>
  </div>

  <div class="row g-4">
    <div class="col-12 col-lg-8 col-xl-9">
      <article class="post-wrap">
        <img class="post-cover" src="{{ img_url($post->image, '/assets/images/null.svg') }}" alt="{{ $post->title }}" loading="eager" decoding="async">
        <div class="post-body">
          <h1 class="post-title">{{ $post->title }}</h1>
          <div class="post-meta">
            <span>{{ $post->created_at->format('d/m/Y H:i') }}</span>
            <span>{{ $post->category->name ?? 'Tin tức' }}</span>
            <span>{{ number_format($post->view) }} lượt xem</span>
            <span>{{ $author->name ?? 'Admin' }}</span>
          </div>

          @if($postSummary)
            <div class="post-summary">{{ \Illuminate\Support\Str::limit($postSummary, 240) }}</div>
          @endif

          <div class="toc-box d-none" id="postToc">
            <h6>Mục lục bài viết</h6>
            <ol id="postTocList"></ol>
          </div>

          <div class="post-content">{!! $postContent !!}</div>

          <div class="author-box">
            <strong>Tác giả:</strong> {{ $author->name ?? 'Admin' }}
            <div class="text-muted mt-1">Chia sẻ kiến thức thực tế giúp bạn mua bán dịch vụ số hiệu quả hơn.</div>
          </div>

          <div class="mt-4 d-flex gap-2 flex-wrap">
            <a class="btn btn-light-primary btn-sm" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ route('blogs.view', ['slug' => $post->slug]) }}">Chia sẻ Facebook</a>
            <a class="btn btn-light-info btn-sm" target="_blank" href="https://t.me/share/url?url={{ route('blogs.view', ['slug' => $post->slug]) }}&text={{ urlencode($post->title) }}">Chia sẻ Telegram</a>
            <a class="btn btn-light-success btn-sm" target="_blank" href="https://zalo.me/share?url={{ route('blogs.view', ['slug' => $post->slug]) }}">Chia sẻ Zalo</a>
          </div>
        </div>
      </article>
    </div>

    <div class="col-12 col-lg-4 col-xl-3">
      <div class="post-sticky">
      <aside class="post-side mb-4">
        <div class="post-side-title">Danh mục</div>
        @foreach($categories as $category)
          <a class="cat-link" href="{{ route('blogs', ['category' => $category->slug]) }}">
            <span>{{ $category->name }}</span>
            <span>{{ $category->posts_count }}</span>
          </a>
        @endforeach
      </aside>

      <aside class="post-side mb-4">
        <div class="post-side-title">Bài liên quan</div>
        @forelse($relatedPosts as $item)
          <div class="side-item">
            <img src="{{ img_url($item->image, '/assets/images/null.svg') }}" alt="{{ $item->title }}" loading="lazy" decoding="async">
            <div>
              <a href="{{ route('blogs.view', ['slug' => $item->slug]) }}">{{ $item->title }}</a>
              <small>{{ $item->created_at->diffForHumans() }}</small>
            </div>
          </div>
        @empty
          <div class="text-muted fs-7">Chưa có bài liên quan.</div>
        @endforelse
      </aside>

      <aside class="post-side">
        <div class="post-side-title">Mới cập nhật</div>
        @foreach($latestPosts as $item)
          <div class="side-item">
            <img src="{{ img_url($item->image, '/assets/images/null.svg') }}" alt="{{ $item->title }}">
            <div>
              <a href="{{ route('blogs.view', ['slug' => $item->slug]) }}">{{ $item->title }}</a>
              <small>{{ $item->created_at->format('d/m/Y') }}</small>
            </div>
          </div>
        @endforeach
      </aside>
      </div>
    </div>
  </div>
</div>

@if(isset($highlightPosts) && $highlightPosts->isNotEmpty())
<div id="kt_content_container" class="container-xxl pb-5 post-page">
  <section class="highlight-wrap">
    <div class="highlight-title">Những tin tức nổi bật</div>
    <div class="tns tns-default" style="direction:ltr">
      <div
        data-tns="true"
        data-tns-loop="true"
        data-tns-swipe-angle="false"
        data-tns-speed="800"
        data-tns-autoplay="true"
        data-tns-autoplay-timeout="6000"
        data-tns-controls="true"
        data-tns-nav="false"
        data-tns-items="3"
        data-tns-center="false"
        data-tns-dots="false"
        data-tns-prev-button="#blog_highlight_prev"
        data-tns-next-button="#blog_highlight_next"
        data-tns-responsive='{"0":{"items":1},"768":{"items":2},"1200":{"items":3}}'
      >
        @foreach($highlightPosts as $item)
        <div class="pe-3">
          <a class="highlight-item" href="{{ route('blogs.view', ['slug' => $item->slug]) }}">
            <img src="{{ img_url($item->image, '/assets/images/null.svg') }}" alt="{{ $item->title }}">
            <div class="t">{{ $item->title }}</div>
            <div class="d">{{ \Illuminate\Support\Str::limit(strip_tags(base64_decode($item->mota, true) ?: $item->mota), 130) }}</div>
            <div class="m">{{ $item->user->name ?? 'Admin' }} on {{ $item->created_at->format('M d Y') }}</div>
          </a>
        </div>
        @endforeach
      </div>
      <button class="btn btn-icon btn-active-color-primary" id="blog_highlight_prev">
        <span class="svg-icon"><i class="ki-duotone ki-black-left fs-2tx text-primary"></i></span>
      </button>
      <button class="btn btn-icon btn-active-color-primary" id="blog_highlight_next">
        <span class="svg-icon"><i class="ki-duotone ki-black-right fs-2tx text-primary"></i></span>
      </button>
    </div>
  </section>
</div>
@endif
<script>
document.addEventListener('DOMContentLoaded', function () {
  const content = document.querySelector('.post-content');
  const tocBox = document.getElementById('postToc');
  const tocList = document.getElementById('postTocList');
  if (!content || !tocBox || !tocList) return;

  const headings = content.querySelectorAll('h2, h3');
  if (!headings.length) return;

  headings.forEach((heading, idx) => {
    if (!heading.id) {
      heading.id = 'post-heading-' + (idx + 1);
    }

    const li = document.createElement('li');
    const a = document.createElement('a');
    a.href = '#' + heading.id;
    a.textContent = heading.textContent.trim();
    if (heading.tagName === 'H3') {
      li.style.marginLeft = '12px';
    }
    li.appendChild(a);
    tocList.appendChild(li);
  });

  tocBox.classList.remove('d-none');
});
</script>
@endsection
