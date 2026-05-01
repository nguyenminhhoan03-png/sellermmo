@extends('admin.layouts.master')
@section('title', 'CRAWL BÀI VIẾT')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">
  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
<div class="row g-4">
  <div class="col-12">
    <div class="card custom-card border-0 shadow-sm">
      <div class="card-body p-4 p-xl-5">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4">
          <div>
            <div class="d-flex align-items-center gap-2 mb-2">
              <span class="avatar avatar-sm bg-success-transparent text-success rounded-circle">
                <i class="fa fa-bolt"></i>
              </span>
              <span class="text-uppercase text-muted small fw-semibold">Blog tools</span>
            </div>
            <h3 class="mb-1">Crawl nội dung từ website khác</h3>
            <p class="text-muted mb-0">Chọn một chế độ crawl, dán nguồn dữ liệu và import nhanh vào hệ thống.</p>
          </div>
          <div class="d-flex flex-wrap gap-2 align-items-start">
            <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
              <i class="fa fa-arrow-left me-1"></i> Quay lại danh sách
            </a>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crawlGuideModal">
              <i class="fa fa-circle-info me-1"></i> Hướng dẫn crawl
            </button>
          </div>
        </div>

        @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <ul class="nav nav-pills gap-2 mb-4 flex-wrap" id="crawlTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="crawl-single-tab" data-bs-toggle="pill" data-bs-target="#crawl-single" type="button" role="tab">
              <i class="fa fa-link me-1"></i> Crawl 1 bài viết
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="crawl-category-tab" data-bs-toggle="pill" data-bs-target="#crawl-category" type="button" role="tab">
              <i class="fa fa-folder-tree me-1"></i> Crawl theo danh mục
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="crawl-feed-tab" data-bs-toggle="pill" data-bs-target="#crawl-feed" type="button" role="tab">
              <i class="fa fa-rss me-1"></i> Crawl từ sitemap / RSS
            </button>
          </li>
        </ul>

        <div class="tab-content" id="crawlTabsContent">
          <div class="tab-pane fade show active" id="crawl-single" role="tabpanel" aria-labelledby="crawl-single-tab" tabindex="0">
            <div class="row g-4">
              <div class="col-12 col-xl-8">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-header bg-transparent border-0 pb-0">
                    <div class="card-title mb-0">Crawl bài viết đơn</div>
                    <p class="text-muted small mb-0">Dán URL bài viết, hệ thống sẽ lấy title, description, content và ảnh đại diện.</p>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.blog.crawl.single') }}" method="POST" class="default-form">
                      @csrf
                      <div class="row g-3">
                        <div class="col-12">
                          <label class="form-label fw-semibold">URL bài viết nguồn <span class="text-danger">*</span></label>
                          <input type="url" name="url" class="form-control form-control-lg" placeholder="https://example.com/bai-viet" required>
                          <small class="text-muted">Chỉ nên nhập trang bài viết cụ thể, không phải trang danh mục.</small>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label fw-semibold">Chuyên mục <span class="text-danger">*</span></label>
                          <select class="form-select" name="category_id" required>
                            <option value="">-- Chọn chuyên mục --</option>
                            @foreach ($category as $item)
                              <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="col-md-3">
                          <label class="form-label fw-semibold">Trạng thái <span class="text-danger">*</span></label>
                          <select class="form-select" name="status" required>
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn / Nháp</option>
                          </select>
                        </div>

                        <div class="col-md-3">
                          <label class="form-label fw-semibold">Chế độ</label>
                          <input type="text" class="form-control" value="Single crawl" disabled>
                        </div>

                        <div class="col-12">
                          <div class="p-3 rounded-3 bg-light border">
                            <div class="fw-semibold mb-2">Dữ liệu sẽ được lấy tự động</div>
                            <div class="row g-2 text-muted small">
                              <div class="col-md-6"><i class="fa fa-check text-success me-1"></i> Tiêu đề từ `og:title` hoặc `h1`</div>
                              <div class="col-md-6"><i class="fa fa-check text-success me-1"></i> Mô tả từ `description`</div>
                              <div class="col-md-6"><i class="fa fa-check text-success me-1"></i> Ảnh từ `og:image`</div>
                              <div class="col-md-6"><i class="fa fa-check text-success me-1"></i> Nội dung từ `article` hoặc `body`</div>
                            </div>
                          </div>
                        </div>

                        <div class="col-12 d-flex flex-wrap gap-2">
                          <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa fa-bolt me-1"></i> Crawl ngay
                          </button>
                          <button type="reset" class="btn btn-outline-secondary btn-lg">Xoá form</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <div class="col-12 col-xl-4">
                <div class="card border-0 shadow-sm mb-4">
                  <div class="card-header bg-transparent border-0 pb-0">
                    <div class="card-title mb-0">Quy trình đề xuất</div>
                  </div>
                  <div class="card-body">
                    <div class="d-flex gap-3 mb-3">
                      <div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle">1</div>
                      <div>
                        <div class="fw-semibold">Dán URL nguồn</div>
                        <div class="text-muted small">Nhập link bài viết hoặc nguồn cần lấy dữ liệu.</div>
                      </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                      <div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle">2</div>
                      <div>
                        <div class="fw-semibold">Xem dữ liệu tóm tắt</div>
                        <div class="text-muted small">Kiểm tra title, mô tả, ảnh, nội dung trước khi lưu.</div>
                      </div>
                    </div>
                    <div class="d-flex gap-3">
                      <div class="avatar avatar-sm bg-primary-transparent text-primary rounded-circle">3</div>
                      <div>
                        <div class="fw-semibold">Sửa và xuất bản</div>
                        <div class="text-muted small">Chỉnh lại nội dung, SEO, ảnh đại diện rồi mới public.</div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card border-0 shadow-sm">
                  <div class="card-header bg-transparent border-0 pb-0">
                    <div class="card-title mb-0">Lưu ý</div>
                  </div>
                  <div class="card-body">
                    <ul class="list-unstyled mb-0 text-muted small">
                      <li class="mb-2"><i class="fa fa-circle-check text-success me-1"></i> Nên crawl từ trang bài viết cụ thể.</li>
                      <li class="mb-2"><i class="fa fa-circle-check text-success me-1"></i> Nếu site dùng JavaScript, cần giải pháp render riêng.</li>
                      <li class="mb-0"><i class="fa fa-circle-check text-success me-1"></i> Nên lưu trạng thái nháp để duyệt lại trước khi đăng.</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="crawl-category" role="tabpanel" aria-labelledby="crawl-category-tab" tabindex="0">
            <div class="card border-0 shadow-sm">
              <div class="card-body p-4 p-xl-5">
                <form action="{{ route('admin.blog.crawl.category') }}" method="POST" class="default-form">
                  @csrf
                  <div class="alert alert-warning">
                    <div class="fw-semibold mb-1">Crawl danh mục sẽ quét các link bài viết bên trong trang nguồn</div>
                    <div class="small mb-0">Phù hợp khi website có trang listing bài viết, hệ thống sẽ lần lượt crawl từng bài con và lưu vào database.</div>
                  </div>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">URL danh mục <span class="text-danger">*</span></label>
                      <input type="url" name="url" class="form-control" placeholder="https://example.com/blog" required>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label fw-semibold">Số bài tối đa</label>
                      <input type="number" name="limit" class="form-control" value="20" min="1" max="200">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label fw-semibold">Chế độ lưu</label>
                      <select class="form-select" name="status" required>
                        <option value="0">Lưu nháp</option>
                        <option value="1">Xuất bản luôn</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <label class="form-label fw-semibold">Chuyên mục đích <span class="text-danger">*</span></label>
                      <select class="form-select" name="category_id" required>
                        <option value="">-- Chọn chuyên mục --</option>
                        @foreach ($category as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-12">
                      <button type="submit" class="btn btn-warning">
                        <i class="fa fa-layer-group me-1"></i> Crawl danh mục
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="crawl-feed" role="tabpanel" aria-labelledby="crawl-feed-tab" tabindex="0">
            <div class="card border-0 shadow-sm">
              <div class="card-body p-4 p-xl-5">
                <form action="{{ route('admin.blog.crawl.feed') }}" method="POST" class="default-form">
                  @csrf
                  <div class="alert alert-info">
                    <div class="fw-semibold mb-1">Dành cho sitemap.xml hoặc RSS feed</div>
                    <div class="small mb-0">Thường dùng cho website lớn: lấy danh sách URL trước, sau đó queue từng bài để crawl nền.</div>
                  </div>
                  <div class="row g-3">
                    <div class="col-md-8">
                      <label class="form-label fw-semibold">URL sitemap / RSS <span class="text-danger">*</span></label>
                      <input type="url" name="url" class="form-control" placeholder="https://example.com/sitemap.xml" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label fw-semibold">Kiểu nguồn</label>
                      <select class="form-select" disabled>
                        <option>Sitemap XML</option>
                        <option>RSS / Atom</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label fw-semibold">Số bài tối đa</label>
                      <input type="number" name="limit" class="form-control" value="20" min="1" max="200">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label fw-semibold">Chuyên mục đích <span class="text-danger">*</span></label>
                      <select class="form-select" name="category_id" required>
                        <option value="">-- Chọn chuyên mục --</option>
                        @foreach ($category as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label fw-semibold">Chế độ lưu</label>
                      <select class="form-select" name="status" required>
                        <option value="0">Lưu nháp</option>
                        <option value="1">Xuất bản luôn</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <button type="submit" class="btn btn-info">
                        <i class="fa fa-rss me-1"></i> Crawl feed
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="crawlGuideModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hướng dẫn crawl bài viết</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <div class="p-3 border rounded-3 h-100">
              <div class="fw-semibold mb-2">Nên dùng khi</div>
              <ul class="text-muted small mb-0 ps-3">
                <li>Cần nhập nhanh một bài viết từ nguồn khác.</li>
                <li>Cần lưu bài ở trạng thái nháp để sửa lại.</li>
                <li>Cần tạo nội dung thủ công từ một URL cụ thể.</li>
              </ul>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 border rounded-3 h-100">
              <div class="fw-semibold mb-2">Sẽ nâng cấp tiếp</div>
              <ul class="text-muted small mb-0 ps-3">
                <li>Preview trước khi import.</li>
                <li>Crawl danh mục và sitemap.</li>
                <li>Queue chạy nền + lịch sử crawl.</li>
                <li>Chống trùng URL và so sánh content.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
