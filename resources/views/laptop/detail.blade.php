<x-laptop-layout>
    <x-slot name="title">
        Chi tiết - {{ $laptop->tieu_de }}
    </x-slot>

    <div class="container mt-4">
        <div class="row align-items-start mb-4">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="border rounded shadow-sm p-3 bg-white text-center">
                    <img src="{{ asset('storage/image/'.$laptop->hinh_anh) }}" 
                         alt="{{ $laptop->tieu_de }}" 
                         class="img-fluid"
                         style="max-height: 500px; object-fit: contain; width: 100%;">
                </div>
            </div>

            <div class="col-lg-7">
                <h4 class="font-weight-bold text-dark mb-3">{{ $laptop->tieu_de }}</h4>

                <div class="bg-white p-4 rounded shadow-sm" style="border: 1px solid #dee2e6;">
                    <h5 class="font-weight-bold mb-3">Thông tin chi tiết</h5>

                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="mb-2"><strong>CPU:</strong> {{ $laptop->cpu ?? 'Đang cập nhật' }}</p>
                            <p class="mb-2"><strong>RAM:</strong> {{ $laptop->ram ?? 'Đang cập nhật' }}</p>
                            <p class="mb-2"><strong>Ổ cứng:</strong> {{ $laptop->o_cung ?? 'Đang cập nhật' }}</p>
                            <p class="mb-2"><strong>Card đồ họa:</strong> {{ $laptop->vga ?? 'Đang cập nhật' }}</p>
                            <p class="mb-2"><strong>Nhu cầu:</strong> {{ $laptop->nhu_cau ?? 'Đang cập nhật' }}</p>
                            <p class="mb-2"><strong>Màn hình:</strong> {{ $laptop->man_hinh ?? 'Đang cập nhật' }}</p>
                            <p class="mb-2"><strong>Hệ điều hành:</strong> {{ $laptop->he_dieu_hanh ?? 'Đang cập nhật' }}</p>
                            <p class="mb-2"><strong>Giá:</strong> <span class="text-danger font-weight-bold">{{ number_format($laptop->gia, 0, ',', '.') }} VNĐ</span></p>
                        </div>
                    </div>

                    <form action="{{ url('cart/add/'.$laptop->id) }}" method="POST">
                        @csrf
                        <div class="form-row align-items-center mb-3">
                            <div class="col-auto">
                                <label for="quantity" class="mb-0 font-weight-bold text-dark">Số lượng:</label>
                            </div>
                            <div class="col-auto">
                                <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control text-center" style="width: 100px; border: 1px solid #ccc;">
                            </div>
                             <button type="submit" class="btn btn-warning font-weight-bold" style="color: #333; padding: 12px 28px; font-size: 15px;">
                            Thêm vào giỏ hàng <i class="fa fa-cart-plus ml-1"></i>
                            </button>
                        </div>

                       
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success mt-3">
                            <i class="fa fa-check-circle mr-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    <hr>

                    <h5 class="font-weight-bold mb-3">Thông tin khác</h5>
                    <div class="row">
                        <div class="col-12">
                            <p class="mb-2"><strong>Khối lượng:</strong> {{ $laptop->khoi_luong ?? 'Đang cập nhật' }}</p>
                            <p class="mb-2"><strong>Webcam:</strong> {{ $laptop->webcam ?? 'Đang cập nhật' }}</p>
                            <p class="mb-2"><strong>Pin:</strong> {{ $laptop->pin ?? 'Đang cập nhật' }}</p>
                            <p class="mb-2"><strong>Kết nối không dây:</strong> {{ $laptop->ket_noi_khong_day ?? 'Đang cập nhật' }}</p>
                            <p class="mb-2"><strong>Bàn phím:</strong> {{ $laptop->ban_phim ?? 'Đang cập nhật' }}</p>
                            <p class="mb-0"><strong>Cổng kết nối:</strong> {{ $laptop->cong_ket_noi ?? 'Đang cập nhật' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-laptop-layout>