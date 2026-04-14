# Hướng Dẫn Thiết Lập Quản Lý Sản Phẩm

Tài liệu này hướng dẫn cách thiết lập và sử dụng tính năng quản lý sản phẩm với xóa mềm (soft delete), DataTable, và phân trang.

## 📋 Các Tính Năng Được Thêm

1. ✅ **Migration thêm cột status** - Tạo cột `status` trong bảng `san_pham` với giá trị mặc định là 1
2. ✅ **Product Model** - Model để quản lý dữ liệu sản phẩm với scope Active/Trashed
3. ✅ **ProductController** - Controller xử lý các logic:
   - `index()` - Hiển thị danh sách sản phẩm (phân trang 10 sản phẩm/trang)
   - `show()` - Hiển thị chi tiết sản phẩm
   - `destroy()` - Xóa mềm sản phẩm (update status = 0)
   - `getData()` - API endpoint cho DataTable (AJAX)
4. ✅ **Views**:
   - `products/index.blade.php` - Danh sách sản phẩm với DataTable
   - `products/show.blade.php` - Chi tiết sản phẩm
5. ✅ **Routes** - Các route cho Product Management
6. ✅ **DataTables** - Hiển thị danh sách với bảng, lọc, sắp xếp, tìm kiếm

## 🚀 Hướng Dẫn Sử Dụng

### Bước 1: Chạy Migration

```bash
php artisan migrate
```

Điều này sẽ thêm cột `status` vào bảng `san_pham` với giá trị mặc định là 1 (hoạt động).

### Bước 2: Truy Cập Danh Sách Sản Phẩm

Mở trình duyệt và vào đường dẫn:
```
http://localhost:8000/products
```

### Bước 3: Sử Dụng Các Tính Năng

#### **Lọc theo Thương Hiệu**
- Chọn thương hiệu từ dropdown "Chọn thương hiệu"
- Bảng sẽ tự động cập nhật để hiển thị sản phẩm của thương hiệu đó

#### **Sắp Xếp theo Giá**
- Chọn "Giá: Thấp → Cao" hoặc "Giá: Cao → Thấp"
- Bảng sẽ sắp xếp lại dữ liệu

#### **Tìm Kiếm Sản Phẩm**
- Nhập từ khóa vào ô "Tìm kiếm sản phẩm..."
- Tìm kiếm sẽ thực hiện trên các trường: `tieu_de`, `ten`, `cpu`, `ram`

#### **Xem Chi Tiết Sản Phẩm**
- Nhấp nút **"Xem"** trong cột "Hành Động"
- Sẽ mở trang hiển thị đầy đủ thông tin sản phẩm
- Trên trang chi tiết, có nút **"Thêm Vào Giỏ Hàng"** để thêm sản phẩm vào giỏ

#### **Xóa Mềm Sản Phẩm**
- Nhấp nút **"Xóa"** trong cột "Hành Động"
- Xác nhận xóa khi được yêu cầu
- Sản phẩm sẽ được đánh dấu là xóa (`status = 0`)
- Sản phẩm sẽ **không** xuất hiện trong danh sách nữa
- ⚠️ **Lưu ý**: Dữ liệu sản phẩm vẫn được lưu trữ trong database (xóa mềm)

## 📊 Cấu Trúc Dữ Liệu

### Bảng `san_pham` - Cột status

```sql
ALTER TABLE `san_pham` ADD COLUMN `status` TINYINT DEFAULT 1 COMMENT '1: Active, 0: Deleted';
```

**Giá trị:**
- `1` = Sản phẩm đang bán
- `0` = Sản phẩm đã xóa (xóa mềm)

## 📁 Cấu Trúc Tệp

```
app/
├── Http/
│   └── Controllers/
│       ├── ProductController.php      (Controller mới)
│       └── HomeController.php          (Hiện có)
├── Models/
│   ├── Product.php                    (Model mới)
│   └── Category.php                   (Model mới)

database/
└── migrations/
    └── 2025_04_14_000003_add_status_to_san_pham_table.php

resources/views/
└── products/
    ├── index.blade.php                (Danh sách sản phẩm)
    └── show.blade.php                 (Chi tiết sản phẩm)

routes/
└── web.php                            (Cập nhật routes)
```

## 🔧 Các Routes Mới

```php
GET    /products/data/get                   # API endpoint cho DataTable
GET    /products                             # Danh sách sản phẩm
GET    /products/{id}                        # Chi tiết sản phẩm
DELETE /products/{id}                        # Xóa mềm sản phẩm
```

## 💾 Lưu Ý Quan Trọng

1. **Xóa Mềm (Soft Delete)**: Khi xóa sản phẩm, chỉ cập nhật `status = 0`, dữ liệu vẫn được lưu
2. **Hiển Thị**: Chỉ hiển thị sản phẩm có `status = 1` trong danh sách
3. **Khôi Phục**: Nếu muốn khôi phục sản phẩm đã xóa, cập nhật `status = 0` thành `1` trực tiếp trong database
4. **DataTable**: Sử dụng server-side processing để xử lý dữ liệu lớn hiệu quả
5. **Phân Trang**: Mặc định 10 sản phẩm mỗi trang

## 🎯 Các Thay Đổi Cụ Thể Trong Code

### ProductController - Phương thức getData()

```php
public function getData(Request $request)
{
    $query = Product::active(); // Chỉ lấy sản phẩm có status = 1
    
    // Lọc, sắp xếp, tìm kiếm...
    // Trả về JSON cho DataTable
}
```

### Product Model - Scope Active

```php
public function scopeActive($query)
{
    return $query->where('status', 1);
}
```

## ❓ Câu Hỏi Thường Gặp

**Q: Làm cách nào để khôi phục sản phẩm đã xóa?**
A: Đăng nhập vào database hoặc tạo một admin panel để update `status = 0` → `1`

**Q: Có thể xóa vĩnh viễn không?**
A: Có, nhưng hiện tại hệ thống không có tính năng này. Bạn có thể thêm bằng cách tạo method `forceDelete()` trong controller

**Q: Trang chi tiết sản phẩm hoạt động như thế nào?**
A: Khi nhấn nút "Xem", sẽ redirected tới `/products/{id}` hiển thị giao diện chi tiết

**Q: Làm cách nào để tìm kiếm sản phẩm?**
A: Nhập từ khóa vào ô tìm kiếm, nó sẽ tìm trên tiêu đề, tên, CPU, RAM

## 📞 Hỗ Trợ

Nếu có câu hỏi hoặc vấn đề, vui lòng kiểm tra:
1. Xem logs: `storage/logs/laravel.log`
2. Kiểm tra migrations đã chạy: `php artisan migrate:status`
3. Xóa cache: `php artisan cache:clear`

---

**Ngày tạo**: 2026-04-14
**Phiên bản**: 1.0
