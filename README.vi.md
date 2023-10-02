# API Quản Lý Công Việc

## Mô Tả

API Quản Lý Công Việc được xây dựng bằng Laravel và chức năng chính của nó là quản lý và phân phối công việc cho các nhân viên trong tổ chức của bạn. Dự án này cho phép bạn tạo, cập nhật, xóa và theo dõi trạng thái của các công việc, cũng như phân phối công việc cho các nhân viên khác nhau.

## Các Tính Năng Chính

1. **Quản Lý Công Việc**:
    - Tạo mới công việc với tiêu đề, mô tả, hạn chót và mức độ ưu tiên.
    - Xem danh sách các công việc hiện có.
    - Cập nhật thông tin của công việc (tiêu đề, mô tả, hạn chót, ưu tiên).
    - Xóa công việc khỏi hệ thống.

2. **Phân Phối Công Việc**:
    - Giao công việc cho một hoặc nhiều nhân viên.
    - Xem danh sách các công việc đã được giao cho từng nhân viên.
    - Hủy giao công việc cho nhân viên khi cần.

3. **Trạng Thái Công Việc**:
    - Theo dõi trạng thái của công việc (hoàn thành, đang thực hiện, chưa bắt đầu).
    - Cập nhật trạng thái công việc khi hoàn thành.

4. **Quản Lý Nhân Viên**:
    - Tạo mới nhân viên với thông tin cơ bản (tên, email, vị trí công việc, v.v.).
    - Xem danh sách các nhân viên trong tổ chức.
    - Cập nhật thông tin của nhân viên.
    - Xóa nhân viên khỏi hệ thống.

## Các Endpoint API

Dự án này cung cấp các endpoint API sau:

- `GET /api/tasks`: Lấy danh sách các công việc.
- `POST /api/tasks`: Tạo mới công việc.
- `GET /api/tasks/{id}`: Lấy thông tin chi tiết về một công việc.
- `PUT /api/tasks/{id}`: Cập nhật công việc.
- `DELETE /api/tasks/{id}`: Xóa công việc.
- `GET /api/employees`: Lấy danh sách các nhân viên.
- `POST /api/employees`: Tạo mới nhân viên.
- `GET /api/employees/{id}`: Lấy thông tin chi tiết về một nhân viên.
- `PUT /api/employees/{id}`: Cập nhật thông tin nhân viên.
- `DELETE /api/employees/{id}`: Xóa nhân viên.
- `POST /api/tasks/{task_id}/assign/{employee_id}`: Giao công việc cho nhân viên.
- `DELETE /api/tasks/{task_id}/unassign/{employee_id}`: Hủy giao công việc cho nhân viên.
- `PATCH /api/tasks/{task_id}/status/{status}`: Cập nhật trạng thái của công việc.

## Xác Thực

Để sử dụng API này, bạn cần xác thực bằng cách sử dụng mã thông báo JSON Web Token (JWT). Hãy đảm bảo rằng bạn đã đăng nhập và có mã thông báo hợp lệ trước khi truy cập các điểm cuối được bảo vệ.

## Cài Đặt

1. Tôi sẽ bổ sung phần này trong tương lai

## Sử Dụng

Bây giờ, bạn có thể sử dụng API để quản lý và phân phối công việc trong tổ chức của bạn.

## Phiên Bản Laravel

Dự án này được xây dựng bằng Laravel [10.25.2](https://laravel.com/docs/10.x). Đảm bảo rằng bạn có phiên bản Laravel tương thích để chạy dự án một cách trơn tru.

## Tài Liệu Bổ Sung

Để biết thêm chi tiết về cách sử dụng API và hướng dẫn cài đặt, vui lòng tham khảo tài liệu trong dự án hoặc thêm thông tin bổ sung vào tệp README.md.

### License

This project is licensed under the [MIT License](https://opensource.org/license/mit/).

### Author

- Minh Việt (VietD)
- GitHub: [https://github.com/vietdm](https://github.com/vietdm)
