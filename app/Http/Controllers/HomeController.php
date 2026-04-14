<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('san_pham');

        // 1. Kiểm tra lọc theo thương hiệu (brand_id)
        if ($request->has('brand_id') && $request->brand_id != '') {
            $query->where('id_danh_muc', $request->brand_id);
            // Không dùng take() ở đây để lấy TẤT CẢ sản phẩm của thương hiệu
        } else {
            // Nếu ở trang chủ mặc định (không chọn menu), lấy 20 sản phẩm
            $query->take(20);
        }

        // 2. Sắp xếp theo giá (Tăng dần / Giảm dần)
        if ($request->sort == 'asc') {
            $query->orderBy('gia', 'asc');
        } elseif ($request->sort == 'desc') {
            $query->orderBy('gia', 'desc');
        } else {
            // Sắp xếp mặc định
            $query->latest('id'); 
        }

        // Lấy dữ liệu sản phẩm
        $laptops = $query->get();

        // Lấy danh sách thương hiệu (nếu cần dùng)
        $brands = DB::table('danh_muc_laptop')->get();
        
        return view("laptop.index", compact('laptops', 'brands'));
    }
    // 1. Hàm hiển thị chi tiết sản phẩm
    public function detail($id)
    {
        // Lấy thông tin laptop theo id
        $laptop = DB::table('san_pham')->where('id', $id)->first();
        
        // Nếu không tìm thấy sản phẩm, báo lỗi 404
        if (!$laptop) {
            abort(404);
        }

        // Lấy danh mục để hiển thị lên menu của Layout
        $brands = DB::table('danh_muc_laptop')->get();

        return view('laptop.detail', compact('laptop', 'brands'));
    }

    // 2. Hàm xử lý thêm vào giỏ hàng
    public function addToCart(Request $request, $id)
    {
        $laptop = DB::table('san_pham')->where('id', $id)->first();
        
        if(!$laptop) {
            abort(404);
        }

        // Lấy giỏ hàng từ session (nếu chưa có thì tạo mảng rỗng)
        $cart = session()->get('cart', []);
        
        // Lấy số lượng từ form gửi lên (mặc định là 1)
        $quantity = $request->input('quantity', 1);

        // Nếu sản phẩm đã có trong giỏ, cộng dồn số lượng
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            // Nếu chưa có, thêm mới vào mảng giỏ hàng
            $cart[$id] = [
                "name" => $laptop->tieu_de,
                "quantity" => $quantity,
                "price" => $laptop->gia,
                "image" => $laptop->hinh_anh
            ];
        }

        // Lưu giỏ hàng ngược lại vào session
        session()->put('cart', $cart);

        // Quay lại trang chi tiết và báo thành công
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng thành công!');
    }
}