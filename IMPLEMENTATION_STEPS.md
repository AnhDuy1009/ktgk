# 📋 Hướng Dẫn Triển Khai Chi Tiết

## ✅ Các Bước Đã Hoàn Thành

### 1. **Tạo Migration** ✓
- File: `database/migrations/2025_04_14_000003_add_status_to_san_pham_table.php`
- Chức năng: Thêm cột `status` (TINYINT, default = 1) vào bảng `san_pham`

### 2. **Tạo Models** ✓
- **Product Model** (`app/Models/Product.php`)
  - Table: `san_pham`
  - Scopes: `active()`, `trashed()`
  - Relationship: Relates to Category
  
- **Category Model** (`app/Models/Category.php`)
  - Table: `danh_muc_laptop`
  - Relationship: Has many Products

### 3. **Tạo ProductController** ✓
- File: `app/Http/Controllers/ProductController.php`
- Methods:
  - `index()` - Danh sách sản phẩm
  - `show()` - Chi tiết sản phẩm
  - `destroy()` - Xóa mềm (AJAX)
  - `getData()` - API cho DataTable

### 4. **Tạo Views** ✓
- **products/index.blade.php**
  - DataTable với 10 sản phẩm/trang
  - Filter: Thương hiệu, sắp xếp, tìm kiếm
  - Nút: Xem, Xóa
  
- **products/show.blade.php**
  - Hiển thị chi tiết sản phẩm
  - Nút "Thêm vào giỏ hàng"
  - Thông tin kỹ thuật đầy đủ

### 5. **Cập Nhật Routes** ✓
- File: `routes/web.php`
- Routes thêm:
  ```php
  GET    /products/data/get    [ProductController@getData]
  GET    /products             [ProductController@index]
  GET    /products/{id}        [ProductController@show]
  DELETE /products/{id}        [ProductController@destroy]
  ```

---

## 🚀 Các Bước Để Chạy Ứng Dụng

### **Bước 1: Chạy Migration**

```bash
# Chạy tất cả migrations
php artisan migrate

# Hoặc chạy migration cụ thể
php artisan migrate --path=database/migrations/2025_04_14_000003_add_status_to_san_pham_table.php
```

**Kết quả:**
- Cột `status` được thêm vào bảng `san_pham`
- Tất cả bản ghi cũ sẽ có giá trị `status = 1`

### **Bước 2: Kiểm Tra Database**

```sql
-- Kiểm tra cột status đã được thêm
SELECT `status` FROM `san_pham` LIMIT 1;

-- Hoặc kiểm tra cấu trúc bảng
DESCRIBE `san_pham`;
```

### **Bước 3: Truy Cập Ứng Dụng**

```
http://localhost:8000/products
```

### **Bước 4: Thử Các Tính Năng**

1. **Lọc theo thương hiệu**
   - Chọn từ dropdown "Chọn thương hiệu"
   
2. **Sắp xếp giá**
   - Chọn "Giá: Thấp → Cao" hoặc "Giá: Cao → Thấp"
   
3. **Tìm kiếm**
   - Nhập từ khóa (tên, CPU, RAM, etc.)
   
4. **Xem chi tiết**
   - Nhấp nút "Xem" → Hiển thị trang chi tiết
   - Có thể thêm vào giỏ hàng
   
5. **Xóa mềm**
   - Nhấp nút "Xóa" → Modal xác nhận
   - Status sẽ update từ 1 → 0
   - Sản phẩm biến mất khỏi danh sách

---

## 📊 Cấu Trúc Dữ Liệu Status

| Status | Ý Nghĩa | Hiển Thị |
|--------|---------|---------|
| 1 | Sản phẩm đang bán | ✅ Có |
| 0 | Sản phẩm đã xóa (mềm) | ❌ Không |

---

## 🔍 Kiểm Tra DataTable

### Kiểm Tra AJAX Request

1. Mở **Developer Tools** (F12)
2. Vào tab **Network**
3. Tải lại trang `/products`
4. Tìm request tới `/products/data/get`
5. Kiểm tra response JSON

**Ví dụ Response:**
```json
{
  "draw": 1,
  "recordsTotal": 312,
  "recordsFiltered": 10,
  "data": [
    {
      "id": 1,
      "tieu_de": "Laptop Dell...",
      "gia": "28.990.000 đ",
      "hinh_anh": "laptop-dell-...",
      "trang_thai": "Đang bán",
      "action": "<a href='/products/1' class='btn btn-sm btn-info'>Xem</a>..."
    }
  ]
}
```

---

## ⚠️ Các Vấn Đề Có Thể Gặp

### **Lỗi 1: Migration không chạy**
```
SQLSTATE[42S21]: Column already exists
```
**Giải pháp:**
- Kiểm tra xem cột `status` đã tồn tại hay chưa
- Nếu có, hãy rollback migration beforehand

### **Lỗi 2: JavaScript không hoạt động**
```
404 Not Found - /products/data/get
```
**Giải pháp:**
- Kiểm tra route được định nghĩa đúng
- Chắc chắn rằng `GET /products/data/get` được định nghĩa TRƯỚC `GET /products/{id}`

### **Lỗi 3: Modal không hiển thị**
```
$(...).modal is not a function
```
**Giải pháp:**
- Kiểm tra Bootstrap JS được load từ `laptop-layout.blade.php`
- Đảm bảo jQuery được load trước Bootstrap

### **Lỗi 4: Không xóa được sản phẩm**
```
405 Method Not Allowed
```
**Giải pháp:**
- Kiểm tra method DELETE trong controller
- Chắc chắn CSRF token được gửi đúng

---

## 🎯 Tệp Được Tạo/Sửa

```
✅ TẠOMỚI:
  - app/Models/Product.php
  - app/Models/Category.php
  - app/Http/Controllers/ProductController.php
  - resources/views/products/index.blade.php
  - resources/views/products/show.blade.php
  - database/migrations/2025_04_14_000003_add_status_to_san_pham_table.php

✏️ SỬAĐỔI:
  - routes/web.php (thêm routes)

📄 HƯỚNGDẪN:
  - PRODUCT_MANAGEMENT_SETUP.md
  - IMPLEMENTATION_STEPS.md (file này)
```

---

## 📝 Các Lệnh Hữu Ích

```bash
# Kiểm tra migration status
php artisan migrate:status

# Rollback migration nếu cần
php artisan migrate:rollback

# Xóa cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Chạy server development
php artisan serve

# Kiểm tra route
php artisan route:list | grep products
```

---

## ✨ Tính Năng Thêm (Tùy Chọn)

### Nếu muốn thêm khôi phục sản phẩm:
```php
// Thêm method trong ProductController
public function restore($id)
{
    $product = Product::find($id);
    if ($product) {
        $product->update(['status' => 1]);
        return response()->json(['success' => true]);
    }
}

// Thêm route
Route::patch('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
```

### Nếu muốn xóa vĩnh viễn:
```php
// Thêm method
public function forceDelete($id)
{
    Product::destroy($id);
    return response()->json(['success' => true]);
}
```

---

## 💡 Tips & Tricks

1. **Tối ưu hiệu suất**: 
   - Sử dụng server-side DataTable processing
   - Thêm index trên cột `status` nếu có nhiều dữ liệu

2. **Bảo mật**:
   - Tất cả DELETE request require CSRF token
   - Kiểm tra authorization nếu cần

3. **UI/UX**:
   - Loading spinner khi tải DataTable
   - Toast notification thay vì alert()

---

**Hoàn thành**: 100%
**Ngày cập nhật**: 2026-04-14
