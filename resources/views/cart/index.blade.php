<x-laptop-layout>
    <x-slot name="title">
        Giỏ hàng
    </x-slot>

    <div class="container mt-4 mb-4">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-4 font-weight-bold">
                    <i class="fa fa-shopping-cart mr-2" style="color: #ff6b6b;"></i>DANH SÁCH SẢN PHẨM
                </h1>
            </div>
        </div>

        <!-- Debug Info -->
        @if(config('app.debug'))
            <div class="alert alert-secondary mb-3" style="font-size: 12px;">
                <strong>Debug Info:</strong> Số sản phẩm trong giỏ: {{ count($cart) }} | Session ID: {{ session()->getId() }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-left: 4px solid #28a745;">
                <strong><i class="fa fa-check-circle mr-2"></i>Thành công!</strong> 
                {{ session('success') }}
                <hr style="margin: 10px 0;">
                <small><i class="fa fa-envelope mr-1"></i>Vui lòng kiểm tra email của bạn để nhận xác nhận chi tiết đơn hàng.</small>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fa fa-exclamation-circle mr-2"></i>Lỗi!</strong> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(!empty($cart) && count($cart) > 0)
            <div class="row">
                <div class="col-lg-8">
                    <div class="bg-white rounded shadow-sm overflow-hidden">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light border-bottom" style="border-bottom: 2px solid #dee2e6;">
                                <tr>
                                    <th style="width: 8%; padding: 15px;" class="font-weight-bold">STT</th>
                                    <th style="width: 35%; padding: 15px;" class="font-weight-bold">Tên sản phẩm</th>
                                    <th style="width: 15%; padding: 15px;" class="font-weight-bold text-center">Số lượng</th>
                                    <th style="width: 18%; padding: 15px;" class="font-weight-bold text-right">Đơn giá</th>
                                    <th style="width: 12%; padding: 15px;" class="font-weight-bold text-center">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalPrice = 0; @endphp
                                @foreach($cart as $id => $item)
                                    @php $itemTotal = $item['price'] * $item['quantity']; $totalPrice += $itemTotal; @endphp
                                    <tr style="border-bottom: 1px solid #e9ecef;">
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <span class="font-weight-bold text-muted">{{ $loop->iteration }}</span>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <span class="font-weight-bold" style="color: #333;">{{ $item['name'] }}</span>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <span class="text-center d-block">{{ $item['quantity'] }}</span>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <span class="font-weight-bold text-danger d-block text-right">{{ number_format($item['price'], 0, ',', '.') }} đ</span>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')" style="padding: 6px 12px;">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-light p-4 rounded shadow-sm sticky-top" style="top: 20px;">
                        <h5 class="font-weight-bold mb-4" style="font-size: 18px;">
                            <i class="fa fa-calculator mr-2" style="color: #007bff;"></i>Tổng cộng
                        </h5>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tổng tiền:</span>
                                <span class="font-weight-bold text-danger" style="font-size: 18px;">
                                    {{ number_format($totalPrice, 0, ',', '.') }} đ
                                </span>
                            </div>
                        </div>

                        <hr class="my-3">

                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="payment_method" class="font-weight-bold mb-2" style="font-size: 14px;">Hình thức thanh toán:</label>
                                <select class="form-control" id="payment_method" name="payment_method" required style="padding: 10px;">
                                    <option value="">-- Chọn hình thức thanh toán --</option>
                                    <option value="tien_mat">💵 Tiền mặt</option>
                                    <option value="chuyen_khoan">🏦 Chuyển khoản</option>
                                    <option value="the_tin_dung">💳 Thẻ tín dụng</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block font-weight-bold" style="padding: 12px; font-size: 15px;">
                                <i class="fa fa-check-circle mr-2"></i>ĐẶT HÀNG
                            </button>
                        </form>

                        <a href="{{ route('home') }}" class="btn btn-secondary btn-block mt-2 font-weight-bold" style="padding: 10px; font-size: 14px;">
                            <i class="fa fa-arrow-left mr-2"></i>Tiếp tục mua hàng
                        </a>
                    </div>
                </div>
            </div>

        @else
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info text-center p-5" role="alert" style="border-radius: 10px; background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); border: none;">
                        <div style="margin-bottom: 20px;">
                            <i class="fa fa-shopping-cart" style="font-size: 64px; color: #1976d2; opacity: 0.7;"></i>
                        </div>
                        <h4 class="mt-3 font-weight-bold" style="color: #1565c0; font-size: 20px;">Giỏ hàng của bạn trống</h4>
                        <p class="mb-3" style="color: #666; font-size: 14px;">Vui lòng thêm sản phẩm vào giỏ hàng trước khi đặt hàng.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary" style="padding: 10px 30px; font-size: 15px;">
                            <i class="fa fa-arrow-left mr-2"></i>Quay lại trang chủ
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

</x-laptop-layout>
