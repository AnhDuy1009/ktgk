<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation; 

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

    // 3. Hàm hiển thị giỏ hàng
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        $brands = DB::table('danh_muc_laptop')->get();
        
        return view('cart.index', compact('cart', 'brands'));
    }

    // 4. Hàm xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.view')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    // 5. Hàm xử lý đặt hàng
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        
        // Kiểm tra nếu giỏ hàng trống
        if(empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Giỏ hàng của bạn trống!');
        }

        // Kiểm tra người dùng đã đăng nhập chưa
        if(!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước khi đặt hàng!');
        }

        // Lấy thông tin thanh toán từ form
        $paymentMethod = $request->input('payment_method');
        
        // Tính tổng tiền
        $totalPrice = 0;
        foreach($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Lấy thông tin người dùng hiện tại
        $user = auth()->user();
        
        try {
            // Gửi email xác nhận đặt hàng
            Mail::to($user->email)->send(new OrderConfirmation(
                $cart,
                $totalPrice,
                $paymentMethod,
                $user->name,
                $user->email
            ));
        } catch (\Exception $e) {
            // Log lỗi email nhưng không cản trở quá trình đặt hàng
            \Log::error('Email gửi thất bại: ' . $e->getMessage());
        }

        // Lưu thông tin đơn hàng vào database (nếu có bảng orders)
        // Ở đây bạn có thể lưu đơn hàng nếu có table orders
        
        // Xóa giỏ hàng sau khi đặt hàng
        session()->forget('cart');

        // Quay lại trang giỏ hàng với thông báo thành công
        return redirect()->route('cart.view')->with('success', 'Đặt hàng thành công! Email xác nhận đã được gửi tới ' . $user->email);
    }

    // 6. Hàm hiển thị trang xác nhận đặt hàng thành công
    public function orderSuccess()
    {
        return view('cart.order-success');
    }
}