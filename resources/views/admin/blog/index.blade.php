@php
use App\Helpers\Helper;
use App\Models\PostCategory;
@endphp
@extends('admin.layouts.master')
@section('title', 'DANH SÁCH BÀI VIẾT')
@section('css')
  <link rel="stylesheet" href="/_assets/libs/jsvectormap/css/jsvectormap.min.css">

  <link rel="stylesheet" href="/_assets/libs/swiper/swiper-bundle.min.css">
@endsection

@section('content')
<div class="mb-3 d-flex justify-content-end gap-2 flex-wrap">
    <a href="{{ route('admin.blog.add') }}" class="btn btn-outline-primary"><i class="fas fa-plus"></i> {{ __('Thêm Bài Viết') }}</a>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crawlBlogModal">
        <i class="fa fa-bolt me-1"></i> Crawl bài viết
    </button>
  </div>

  <div class="card custom-card">
    <div class="card-header justify-content-between">
      <div class="card-title">DANH SÁCH BÀI VIẾT</div>
    </div>
    <div class="card-body">
      <div class="table-responsive theme-scrollbar" style="padding: 10px">
        <table class="display table table-bordered table-stripped text-nowrap datatable-custom122" id="datatable">
          <thead>
            <tr>
                <th>Tiêu đề bài viết</th>
                <th>Ảnh</th>
                <th>Chuyên mục</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Lượt xem</th>
                <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($post as $posts)
            <tr>
                <td>{{ $posts->title }}</td>
                <td><img src="{{ $posts->image }}" width="100px" style="border-radius: 10px;"></td>
                <td><a class="text-primary" href="{{ route('admin.blog.category') }}"><i class="fa fa-pencil-alt"></i>
                        {{ PostCategory::getCategory($posts->category_id, 'name') }}</a>
                </td>
                <td class="text-center">{!! Helper::status_blogs_admin($posts->status) !!}</td>
                <td class="text-center">{{ $posts->view }} lượt xem</td>
                <td>
                    <a type="button" target="_blank" href="{{ route('home') }}/blog/{{ $posts->slug }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" aria-label="Xem" data-bs-original-title="Xem">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a type="button" href="{{ route('admin.blog.edit', $posts->id) }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" aria-label="Chỉnh sửa" data-bs-original-title="Chỉnh sửa">
                        <i class="fa fa-pencil-alt"></i>
                    </a>
                    <a type="button" onclick="deleteRow('{{ $posts->id }}')" class="btn btn-sm btn-light" data-bs-toggle="tooltip" aria-label="Xóa" data-bs-original-title="Xóa">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="crawlBlogModal" tabindex="-1" aria-labelledby="crawlBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="crawlBlogModalLabel">Crawl bài viết từ URL</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.blog.crawl') }}" method="POST" class="default-form">
            @csrf
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label fw-semibold">URL bài viết nguồn</label>
                <input type="url" name="url" class="form-control" placeholder="https://example.com/bai-viet" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Chuyên mục</label>
                <select class="form-select" name="category_id" required>
                  <option value="">-- Chọn chuyên mục --</option>
                  @foreach (PostCategory::where('status', 1)->get() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold">Trạng thái</label>
                <select class="form-control" name="status" required>
                  <option value="0">Nháp</option>
                  <option value="1">Public</option>
                </select>
              </div>
              <div class="col-md-2 d-grid">
                <label class="form-label fw-semibold opacity-0">.</label>
                <button type="submit" class="btn btn-success h-100">
                  <i class="fa fa-bolt me-1"></i> Crawl
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script type="text/javascript">
    const deleteRow = async (id) => {
      const confirmDelete = await Swal.fire({
        title: '{{ __('Bạn chắc chứ?') }}',
        text: "{{ __('Bạn sẽ không thể khôi phục lại dữ liệu này!') }}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '{{ __('Xóa') }}',
        cancelButtonText: '{{ __('Hủy') }}'
      });

      if (!confirmDelete.isConfirmed) return;

      $showLoading();

      try {
        const {
          data: result
        } = await axios.post('{{ route('admin.blog.delete') }}', {
          id
        })

        Swal.fire('Thành công', result.message, 'success').then(() => {
          window.location.reload();
        })
      } catch (error) {
        Swal.fire('Thất bại', $catchMessage(error), 'error')
      }
    }
    $(document).ready(function () {

        $('#name').focusout(function () {
            var pname = $(this).val();
            $.ajax({
                url: '{{ route('slug') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                method: "post",
                data: {
                    title: pname,
                },
                success: function (data) {
                    if (data) {
                        $("#slug").attr('value', data);
                        $("#name").attr('value', pname);
                    }
                }

            });

        });
    });
</script>
<script>
  $(document).ready(function() {
    window.pageOverlay = $("#page-overlay");

    // basic datatable
    $('#datatable').DataTable({
      language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
      },
      response: false,
      order: [
        [0, 'desc']
      ],
      pageLength: 10,
      lengthMenu: [
        [10, 25, 50, 100, 500, 1000, 5000, -1],
        [10, 25, 50, 100, 500, 1000, 5000, 'All']
      ]
    });

  })
</script>
@endsection