@extends('layouts.app')
@section('title', $pageTitle)
@section('description', 'Blog chia sẻ kiến thức thực chiến về mã nguồn, hosting, domain, bảo mật và tối ưu chuyển đổi.')
@section('content')
@php
  $safeB64 = function (?string $value): string {
    if (!$value) return '';
    $decoded = base64_decode($value, true);
    return $decoded !== false ? trim(strip_tags($decoded)) : trim(strip_tags($value));
  };
@endphp
<style>
.blog-page{
  --blog-surface: rgba(255,255,255,.84);
  --blog-border: rgba(255,255,255,.52);
  --blog-shadow: 0 10px 30px rgba(15,23,42,.10);
  --blog-text: #1f2937;
  --blog-muted: #6b7280;
  --blog-soft: rgba(249,250,252,.80);
  --blog-chip-active: #fff0f3;
  --blog-chip-active-border: #e94560;
}
[data-bs-theme="dark"] .blog-page{
  --blog-surface: rgba(18,24,38,.70);
  --blog-border: rgba(148,163,184,.18);
  --blog-shadow: 0 12px 34px rgba(2,6,23,.42);
  --blog-text: #e5e7eb;
  --blog-muted: #9ca3af;
  --blog-soft: rgba(30,41,59,.55);
  --blog-chip-active: rgba(233,69,96,.18);
  --blog-chip-active-border: rgba(233,69,96,.75);
}
.blog-hero{
  background:linear-gradient(120deg,rgba(14,27,61,.92),rgba(20,67,122,.92) 55%,rgba(233,69,96,.9));
  border:1px solid rgba(255,255,255,.22);
  border-radius:20px;
  padding:28px;
  color:#fff;
  box-shadow:0 16px 36px rgba(15,23,42,.25);
}
.blog-hero h1{font-size:1.72rem;font-weight:800;margin:0 0 6px}
.blog-hero p{opacity:.88;margin:0}
.blog-card,.blog-side-card,.topic-block{
  background:var(--blog-surface);
  border:1px solid var(--blog-border);
  box-shadow:var(--blog-shadow);
  backdrop-filter: blur(10px);
}
.blog-card{border-radius:16px;overflow:hidden;height:100%}
.blog-card:hover{transform:translateY(-3px);transition:all .2s ease}
.blog-card img{width:100%;height:200px;object-fit:cover}
.blog-card .body{padding:14px}
.blog-card .title{font-weight:700;color:var(--blog-text);font-size:1rem;line-height:1.45;text-decoration:none;display:-webkit-box;-webkit-line-clamp:2;line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.blog-card .meta{font-size:.78rem;color:var(--blog-muted);margin-top:8px}
.blog-card .desc{font-size:.86rem;color:var(--blog-muted);margin-top:8px;display:-webkit-box;-webkit-line-clamp:3;line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
.blog-side-card{border-radius:16px;padding:14px}
.blog-side-title{font-size:.95rem;font-weight:800;color:var(--blog-text);margin-bottom:10px}
.post-min{display:flex;gap:10px;padding:9px 0;border-bottom:1px dashed var(--blog-border)}
.post-min:last-child{border-bottom:none;padding-bottom:0}
.post-min img{width:70px;height:52px;border-radius:8px;object-fit:cover}
.post-min a{font-size:.83rem;font-weight:700;color:var(--blog-text);line-height:1.35;text-decoration:none}
.post-min .m{font-size:.73rem;color:var(--blog-muted)}
.cat-chip{display:inline-flex;align-items:center;justify-content:space-between;width:100%;padding:8px 10px;border-radius:10px;background:var(--blog-soft);color:var(--blog-muted);text-decoration:none;border:1px solid var(--blog-border);margin-bottom:8px;font-size:.83rem;font-weight:600}
.cat-chip.active,.cat-chip:hover{background:var(--blog-chip-active);border-color:var(--blog-chip-active-border);color:#e94560}
.featured-wrap{display:grid;grid-template-columns:2fr 1fr;gap:14px}
.featured-main{position:relative;overflow:hidden;border-radius:14px;min-height:320px}
.featured-main img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.featured-main .overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.75),transparent 55%);padding:18px;display:flex;flex-direction:column;justify-content:flex-end}
.featured-main .overlay a{color:#fff;font-weight:800;font-size:1.2rem;line-height:1.35;text-decoration:none}
.featured-main .overlay p{color:rgba(255,255,255,.84);font-size:.86rem;margin:7px 0 0;display:-webkit-box;-webkit-line-clamp:2;line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.featured-col{display:grid;gap:14px}
.featured-mini{border-radius:14px;overflow:hidden;position:relative;min-height:152px}
.featured-mini img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.featured-mini .overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.78),transparent 60%);padding:12px;display:flex;align-items:flex-end}
.featured-mini a{color:#fff;font-size:.86rem;font-weight:700;line-height:1.35;text-decoration:none;display:-webkit-box;-webkit-line-clamp:2;line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.topic-block{border-radius:14px;padding:14px}
.topic-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
.topic-head h4{font-size:1rem;font-weight:800;margin:0;color:var(--blog-text)}
.topic-head a{font-size:.8rem;font-weight:700;text-decoration:none;color:#e94560}
.topic-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px}
.topic-card{display:block;text-decoration:none;color:inherit}
.topic-card img{width:100%;height:120px;object-fit:cover;border-radius:10px}
.topic-card .t{font-size:.83rem;line-height:1.35;font-weight:700;color:var(--blog-text);margin-top:7px;display:-webkit-box;-webkit-line-clamp:2;line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.topic-card .m{font-size:.72rem;color:var(--blog-muted);margin-top:4px}
@media(max-width:1200px){.topic-grid{grid-template-columns:repeat(3,minmax(0,1fr))}}
@media(max-width:768px){.topic-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:992px){.featured-wrap{grid-template-columns:1fr}.featured-main{min-height:260px}}
</style>

<div id="kt_content_container" class="container-xxl py-5 blog-page">
  <div class="blog-hero mb-5">
    <h1>Blog Kiến Thức & Cập Nhật</h1>
    <p>Tập trung nội dung thực chiến để kéo SEO, tăng uy tín và hỗ trợ bán hàng tốt hơn.</p>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-lg-8">
      @if($featuredPosts->count())
      <div class="featured-wrap">
        @php $main = $featuredPosts->first(); @endphp
        <article class="featured-main">
          <img src="{{ img_url($main->image, '/assets/images/null.svg') }}" alt="{{ $main->title }}" loading="lazy" decoding="async">
          <div class="overlay">
            <a href="{{ route('blogs.view', ['slug' => $main->slug]) }}">{{ $main->title }}</a>
            <p>{{ \Illuminate\Support\Str::limit($safeB64($main->mota), 150) }}</p>
          </div>
        </article>
        <div class="featured-col">
          @foreach($featuredPosts->slice(1,2) as $item)
          <article class="featured-mini">
            <img src="{{ img_url($item->image, '/assets/images/null.svg') }}" alt="{{ $item->title }}" loading="lazy" decoding="async">
            <div class="overlay">
              <a href="{{ route('blogs.view', ['slug' => $item->slug]) }}">{{ $item->title }}</a>
            </div>
          </article>
          @endforeach
        </div>
      </div>
      @endif
    </div>
    <div class="col-lg-4">
      <div class="blog-side-card h-100">
        <div class="blog-side-title">Tìm bài viết</div>
        <form method="GET" action="{{ route('blogs') }}" class="mb-3">
          <div class="input-group">
            <input type="text" class="form-control" name="q" placeholder="Nhập từ khóa..." value="{{ $keyword }}">
            @if($categorySlug)
            <input type="hidden" name="category" value="{{ $categorySlug }}">
            @endif
            <button class="btn btn-primary" type="submit">Tìm</button>
          </div>
        </form>
        <div class="blog-side-title">Danh mục</div>
        <a class="cat-chip {{ !$selectedCategory ? 'active' : '' }}" href="{{ route('blogs') }}">
          <span>Tất cả bài viết</span><span>{{ $categories->sum('posts_count') }}</span>
        </a>
        @foreach($categories as $cat)
          <a class="cat-chip {{ ($selectedCategory && $selectedCategory->id === $cat->id) ? 'active' : '' }}" href="{{ route('blogs', ['category' => $cat->slug]) }}">
            <span>{{ $cat->name }}</span><span>{{ $cat->posts_count }}</span>
          </a>
        @endforeach
      </div>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-lg-8">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="m-0 fw-bold text-gray-900">Bài viết mới nhất</h3>
      </div>
      <div class="row g-4">
        @forelse($posts as $post)
          <div class="col-md-6">
            <article class="blog-card">
              <a href="{{ route('blogs.view', ['slug' => $post->slug]) }}">
                <img src="{{ img_url($post->image, '/assets/images/null.svg') }}" alt="{{ $post->title }}" loading="lazy">
              </a>
              <div class="body">
                <a class="title" href="{{ route('blogs.view', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                <div class="meta">
                  {{ $post->user->name ?? 'Admin' }} • {{ $post->created_at->format('d/m/Y') }}
                  @if($post->category)
                    • {{ $post->category->name }}
                  @endif
                </div>
                <div class="desc">{{ \Illuminate\Support\Str::limit($safeB64($post->mota), 140) }}</div>
              </div>
            </article>
          </div>
        @empty
          <div class="col-12">
            <div class="alert alert-light border rounded-3 mb-0">Chưa có bài viết phù hợp với bộ lọc hiện tại.</div>
          </div>
        @endforelse
      </div>

      @if($posts->hasPages())
      <div class="mt-4 d-flex justify-content-center">
        {{ $posts->links('vendor.pagination.custom') }}
      </div>
      @endif
    </div>

    <div class="col-lg-4">
      <div class="blog-side-card mb-4">
        <div class="blog-side-title">Xem nhiều</div>
        @foreach($popularPosts as $item)
          <div class="post-min">
            <img src="{{ img_url($item->image, '/assets/images/null.svg') }}" alt="{{ $item->title }}">
            <div>
              <a href="{{ route('blogs.view', ['slug' => $item->slug]) }}">{{ $item->title }}</a>
              <div class="m">{{ number_format($item->view) }} lượt xem</div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="blog-side-card">
        <div class="blog-side-title">Mới cập nhật</div>
        @foreach($latestPosts as $item)
          <div class="post-min">
            <img src="{{ img_url($item->image, '/assets/images/null.svg') }}" alt="{{ $item->title }}">
            <div>
              <a href="{{ route('blogs.view', ['slug' => $item->slug]) }}">{{ $item->title }}</a>
              <div class="m">{{ $item->created_at->diffForHumans() }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  @if(isset($categorySections) && $categorySections->isNotEmpty())
  <div class="mt-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h3 class="m-0 fw-bold text-gray-900">Tin theo từng chuyên mục</h3>
      <span class="text-muted fs-8">Mô hình giống cổng tin tức đa danh mục</span>
    </div>

    <div class="row g-4">
      @foreach($categorySections as $catSection)
        @if(($catSection->section_posts ?? collect())->isNotEmpty())
        <div class="col-12">
          <section class="topic-block">
            <div class="topic-head">
              <h4>{{ $catSection->name }}</h4>
              <a href="{{ route('blogs', ['category' => $catSection->slug]) }}">Xem tất cả</a>
            </div>
            <div class="topic-grid">
              @foreach($catSection->section_posts as $topicPost)
              <a class="topic-card" href="{{ route('blogs.view', ['slug' => $topicPost->slug]) }}">
                <img src="{{ img_url($topicPost->image, '/assets/images/null.svg') }}" alt="{{ $topicPost->title }}" loading="lazy">
                <div class="t">{{ $topicPost->title }}</div>
                <div class="m">
                  {{ $topicPost->user->name ?? 'Admin' }} • {{ $topicPost->created_at->format('d/m/Y') }}
                </div>
              </a>
              @endforeach
            </div>
          </section>
        </div>
        @endif
      @endforeach
    </div>
  </div>
  @endif
</div>
@endsection
