<x-laptop-layout>
    <x-slot name="title">
        {{ $product->tieu_de }}
    </x-slot>

    <div class="container mt-4 mb-5">
        <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">← Quay Lại</a>
        
        <div class="card">
            <div class="card-body">
                <h2>{{ $product->tieu_de }}</h2>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        @if($product->hinh_anh)
                            <img src="{{ asset('storage/image/' . $product->hinh_anh) }}" class="img-fluid rounded" alt="{{ $product->tieu_de }}">
                        @else
                            <img src="https://via.placeholder.com/400x400" class="img-fluid rounded" alt="No image">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h4 class="text-success">Giá: {{ number_format($product->gia, 0, ',', '.') }} đ</h4>
                        
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Tên:</strong></td>
                                <td>{{ $product->ten }}</td>
                            </tr>
                            <tr>
                                <td><strong>Series/Model:</strong></td>
                                <td>{{ $product->series_model ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Màu sắc:</strong></td>
                                <td>{{ $product->mau_sac ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nhu cầu:</strong></td>
                                <td>{{ $product->nhu_cau ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Bảo hành:</strong></td>
                                <td>{{ $product->bao_hanh ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Trạng thái:</strong></td>
                                <td>
                                    @if($product->status == 1)
                                        <span class="badge badge-success">Đang bán</span>
                                    @else
                                        <span class="badge badge-danger">Đã xóa</span>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <div class="mt-4">
                            <button class="btn btn-warning mr-2" data-toggle="modal" data-target="#addToCartModal">
                                🛒 Thêm Vào Giỏ Hàng
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Tiếp Tục Mua Sắm</a>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Chi tiết kỹ thuật -->
                <h4 class="mt-4">Thông Tin Chi Tiết</h4>
                <table class="table table-hover">
                    <tr>
                        <td width="30%"><strong>CPU:</strong></td>
                        <td>{{ $product->cpu ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Chip Đồ Hoạ:</strong></td>
                        <td>{{ $product->chip_do_hoa ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Màn Hình:</strong></td>
                        <td>{{ $product->man_hinh ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Webcam:</strong></td>
                        <td>{{ $product->webcam ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>RAM:</strong></td>
                        <td>{{ $product->ram ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Lưu Trữ:</strong></td>
                        <td>{{ $product->luu_tru ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Cổng Kết Nối:</strong></td>
                        <td>{!! $product->cong_ket_noi ?? 'N/A' !!}</td>
                    </tr>
                    <tr>
                        <td><strong>Kết Nối Không Dây:</strong></td>
                        <td>{{ $product->ket_noi_khong_day ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Bàn Phím:</strong></td>
                        <td>{{ $product->ban_phim ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Hệ Điều Hành:</strong></td>
                        <td>{{ $product->he_dieu_hanh ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Pin:</strong></td>
                        <td>{{ $product->pin ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Khối Lượng:</strong></td>
                        <td>{{ $product->khoi_luong ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Bảo Mật:</strong></td>
                        <td>{{ $product->bao_mat ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal thêm vào giỏ hàng -->
    <div class="modal fade" id="addToCartModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Vào Giỏ Hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="quantity">Số Lượng:</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Thêm Vào Giỏ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-laptop-layout>
