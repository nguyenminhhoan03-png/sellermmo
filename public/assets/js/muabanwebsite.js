
function number_format(number, decimals, dec_point, thousands_sep) {
  decimals = decimals || 0;
  dec_point = dec_point || '.';
  thousands_sep = thousands_sep || ',';
  number = Number(number).toFixed(decimals);
  var parts = number.split('.');
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);
  return parts.join(dec_point);
}

$(document).ready(function () {
  // ── AI FILTER (client-side, data rendered server) ──
  $(document).on('click', '.filters-btns-ai .filter-tab', function () {
    var cat = String($(this).data('ai-cat'));
    $('.filters-btns-ai .filter-tab').removeClass('active');
    $(this).addClass('active');

    var $cols = $('#ai-cards-row .ai-card-col');
    var visible = 0;

    $cols.each(function () {
      var cardCat = String($(this).data('ai-cat'));
      if (cat === 'all' || cardCat === cat) {
        $(this).show();
        visible++;
      } else {
        $(this).hide();
      }
    });

    // empty state
    if (visible === 0) {
      $('#ai-empty-state').removeClass('d-none');
    } else {
      $('#ai-empty-state').addClass('d-none');
    }
  });

  // ── PRODUCT FILTER (API) ──
  var currentCategory = 'all';
  var currentPage = 1;
  var isLoading = false;

  loadProducts(currentCategory, currentPage);

  // ── FILTER CLICK ──
  $(document).on('click', '.filters-btns-product .filter-tab', function () {
    if (isLoading) return;
    var cat = $(this).data('category');
    if (cat === currentCategory) return;

    $('.filters-btns-product .filter-tab').removeClass('active');
    $(this).addClass('active');
    currentCategory = cat;
    currentPage = 1;
    loadProducts(currentCategory, currentPage);
  });

  function buildSkeletons() {
    var html = '';
    for (var i = 0; i < 10; i++) {
      html += '<div class="col-6 col-sm-4 col-md-3 col-xl-2-4 mb-3">' +
        '<div class="skeleton" style="height:150px;border-radius:14px;"></div>' +
        '<div class="skeleton mt-2" style="height:14px;width:75%;border-radius:6px;"></div>' +
        '<div class="skeleton mt-1" style="height:12px;width:50%;border-radius:6px;"></div>' +
        '<div class="skeleton mt-2" style="height:30px;border-radius:8px;"></div>' +
        '</div>';
    }
    return html;
  }

  function loadProducts(category, page) {
    if (isLoading) return;
    isLoading = true;

    var $list = $('.js-product-list');
    $list.html('<div class="row g-3">' + buildSkeletons() + '</div>');

    var postData = { page: page };
    if (category && category !== 'all') {
      postData.category = category;
    }

    $.ajax({
      url: '/api/product',
      type: 'POST',
      data: postData,
      dataType: 'json',
      success: function (response) {
        isLoading = false;
        $list.empty();

        if (response.success === 200 && response.products && response.products.length > 0) {
          var rows = '<div class="row g-3">';
          response.products.forEach(function (product) {
            var timeAgo = moment(product.created_at).locale('vi').fromNow();
            var rawImg = product.images || '';
            var img = rawImg
              ? (/^https?:\/\//i.test(rawImg) ? rawImg : '/' + rawImg.replace(/^\/+/, ''))
              : '/assets/media/svg/files/doc.svg';
            rows += '<div class="col-6 col-sm-4 col-md-3 col-xl-2-4 dvr-item mb-1">' +
              '<div class="product-card">' +
                '<div class="product-img-wrap">' +
                  '<a href="/view/' + product.slug + '">' +
                    '<img src="' + img + '" alt="' + product.name + '" loading="lazy" onerror="this.src=\'/assets/media/svg/files/doc.svg\'"/>' +
                  '</a>' +
                '</div>' +
                '<div class="product-card-body">' +
                  '<a href="/view/' + product.slug + '" class="product-name text-decoration-none d-block" title="' + product.name + '">' + product.name + '</a>' +
                  '<div class="product-seller">' +
                    '<img src="/assets/media/avatars/user-placeholder.svg" alt="">' +
                    '<span>' + (product.user_name || 'Admin') + ' &bull; ' + timeAgo + '</span>' +
                  '</div>' +
                  '<div class="product-footer">' +
                    '<span class="product-price">' + number_format(product.price, 0, ',', '.') + '₫</span>' +
                    '<a href="/view/' + product.slug + '" class="btn-buy-now">Mua ngay</a>' +
                  '</div>' +
                '</div>' +
              '</div>' +
            '</div>';
          });
          rows += '</div>';
          $list.html(rows);

          if (typeof notyf !== 'undefined') {
            notyf.success('Đã tải ' + response.products.length + ' sản phẩm');
          }
        } else {
          $list.html(
            '<div class="col-12 text-center py-5">' +
              '<div style="font-size:3rem;margin-bottom:12px;">📦</div>' +
              '<p style="color:#a1a5b7;font-size:.95rem;">Chưa có sản phẩm nào trong danh mục này.</p>' +
            '</div>'
          );
        }
      },
      error: function () {
        isLoading = false;
        if (typeof notyf !== 'undefined') {
          notyf.error('Lỗi kết nối, vui lòng thử lại.');
        }
        $('.js-product-list').html(
          '<div class="col-12 text-center py-5"><p style="color:#e94560;">Không thể tải sản phẩm. Hãy thử lại.</p></div>'
        );
      }
    });
  }
});
