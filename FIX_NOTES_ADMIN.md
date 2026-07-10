# Ghi Chú Sửa Lỗi Admin Dashboard (Tháng 7/2026)

Tài liệu này ghi lại chi tiết các lỗi đã phát sinh trên trang Admin (đặc biệt là mục Quản lý Mã nguồn và Tên miền) cùng với nguyên nhân gốc rễ và cách khắc phục để tiện theo dõi về sau.

## 1. Lỗi Datatable bị kẹt ở "Processing..." (Đang tải...)

**Triệu chứng:**
Khi truy cập vào `/Cpanel/code` hoặc các trang quản lý khác, bảng dữ liệu (Datatable) hiển thị thông báo "Processing..." không bao giờ kết thúc. Dữ liệu không được render.

**Nguyên nhân gốc rễ:**
*   **Lỗi 401 Unauthorized từ API:** Do môi trường local đang chạy ở port `9022`, Laravel Sanctum mặc định chặn các request gọi qua API (`/api/Cpanel/code`) vì domain này không nằm trong danh sách "stateful domains".
*   **Lỗi Crash Javascript:** Trong cấu hình của Datatables ở file Blade, có gọi các hàm custom tiện ích như `$setLoading`, `$removeLoading`, và `$truncate`. Tuy nhiên, các hàm này bị thiếu (chưa được định nghĩa do mất file `functions.js` của Vite). Khi API trả về lỗi 401, Javascript nhảy vào khối `error` và cố gắng gọi các hàm này, dẫn đến crash toàn bộ JS trên trang, khiến bảng kẹt vĩnh viễn ở trạng thái "Processing".
*   **Lỗi Null Resource Backend:** Một vài bản ghi không có thông tin `user` hoặc `created_at` gây ra lỗi Backend khi gọi các thuộc tính như `$product->user->username`.

**Cách đã khắc phục:**
1.  **Cấu hình Sanctum:** 
    * Sửa file `bootstrap/app.php` bật middleware `$middleware->statefulApi();`.
    * Thêm `127.0.0.1:9022` và `localhost:9022` vào biến `SANCTUM_STATEFUL_DOMAINS` trong file `.env`.
2.  **Sửa lỗi Backend:** Trong các Controller API (`CodeApiController.php`, `DomainApiController.php`), đổi sang dùng Null-safe operator (`$product->user?->username`) để trả về null thay vì ném ra Exception 500.
3.  **Dọn dẹp Frontend (Tạm thời):** Xóa bỏ các dòng gọi `$setLoading()` và `$truncate()` không tồn tại trong cấu hình Datatables ở các file `index.blade.php`.

---

## 2. Lỗi các nút thao tác CRUD (Kích hoạt, Duyệt, Xóa) bấm không phản hồi (Không ăn)

**Triệu chứng:**
Khi bấm vào nút "Kích hoạt" (Toggle) hoặc nút "Duyệt", trang web hiện SweetAlert ghi "Đang xử lý - Vui lòng chờ..." nhưng bị treo mãi không tắt. Request hoàn toàn không được gửi đi.

**Nguyên nhân gốc rễ:**
Đây là hậu quả của việc vỡ kiến trúc Frontend Javascript sau khi bỏ sử dụng `@vite('resources/js/app.js')` (do bị lỗi ViteException).
1.  **Mất thư viện Axios:** File Blade của Admin sử dụng hàm `axios.post()` ở khắp nơi, nhưng thư viện Axios chưa hề được nhúng vào trang qua thẻ `<script>`. Khi click nút, JS gọi `axios.post()` sinh ra lỗi `ReferenceError: axios is not defined`.
2.  **Mất cấu hình CSRF Token:** Laravel yêu cầu mọi request POST phải có header `X-CSRF-TOKEN`. Do Axios bị mất cấu hình chuẩn của Laravel, các request gửi lên sẽ bị lỗi `419 Page Expired`.
3.  **Mất hàm `$catchMessage()`:** Hàm này được dùng trong các khối `.catch()` để bóc tách thông báo lỗi hiển thị lên SweetAlert. Do bị thiếu, quá trình bắt lỗi lại tiếp tục sinh ra một lỗi khác (`$catchMessage is not defined`), làm crash Javascript trước khi kịp đóng thông báo "Đang xử lý".

**Cách đã khắc phục triệt để:**
Đã inject trực tiếp (Hardcode) cấu hình vào file `resources/views/admin/layouts/partials/head.blade.php`:
1.  Nhúng thư viện Axios trực tiếp thông qua CDN.
2.  Viết lại các Polyfill (Khai báo bù) cho toàn bộ các hàm tiện ích bị thiếu: `$catchMessage`, `$setLoading`, `$removeLoading`, `$showLoading`, `$truncate`.
3.  Thêm đoạn script tự động lấy CSRF token từ `window.webData.csrfToken` gán vào Default Header của Axios (`axios.defaults.headers.common['X-CSRF-TOKEN']`).

Nhờ vậy, toàn bộ các hàm JS liên quan đến Ajax/Axios ở tất cả các trang Admin đã được khôi phục hoạt động bình thường, gửi request POST chuẩn xác và thông báo lỗi đúng như thiết kế ban đầu
