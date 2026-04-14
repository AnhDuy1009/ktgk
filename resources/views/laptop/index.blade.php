<x-laptop-layout>
    <x-slot name="title">
        Laptop
    </x-slot>
    <div class="row mt-4 mb-3">
        <div class="col-md-12">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between bg-light p-3 rounded border gap-2">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <span class="font-weight-bold">Sắp xếp:</span>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}" class="btn btn-sm {{ request('sort') == 'asc' ? 'btn-primary text-white' : 'btn-outline-secondary' }}">Giá tăng dần</a>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}" class="btn btn-sm {{ request('sort') == 'desc' ? 'btn-primary text-white' : 'btn-outline-secondary' }}">Giá giảm dần</a>
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary">Xóa lọc</a>
                </div>
                @if(request('brand_id'))
                    <div class="text-muted">
                        Đang hiển thị thương hiệu: <strong>{{ $brands->firstWhere('id', request('brand_id'))->ten_danh_muc ?? 'Unknown' }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="list-laptop">
        @foreach($laptops as $item)
            <div class="laptop shadow-sm bg-white mb-3 rounded" style="border: 1px solid #e0e0e0; position: relative;">
                <a href="{{ url('laptop/detail/'.$item->id) }}" style="text-decoration: none; color: inherit; display: block;">
                    <div class="p-2 text-center">
                        <img src="{{ asset('storage/image/'.$item->hinh_anh) }}" 
                             alt="{{ $item->tieu_de }}" 
                             class="img-fluid" 
                             style="height: 160px; object-fit: contain; width: 100%;">
                    </div>
                    
                    <div class="p-2">
                        <h6 class="font-weight-bold mb-1" style="font-size: 14px; line-height: 1.3; white-space: normal;">
                            {{ $item->tieu_de }}
                        </h6>
                    </div>
                </a>
                <div class="px-2 pb-2">
                    <p class="text-danger font-weight-bold mb-0 text-center" style="font-size: 15px;">
                        {{ number_format($item->gia, 0, ',', '.') }} đ
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    @if($laptops->isEmpty())
        <div class="alert alert-info mt-4 text-center">
            Không tìm thấy sản phẩm nào phù hợp với lựa chọn của bạn.
        </div>
    @endif
</x-laptop-layout>