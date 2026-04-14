<x-laptop-layout>
    <x-slot name="title">
        Quản Lý Sản Phẩm
    </x-slot>
    
    <div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
        <h2 style="text-align: center; color: #0066cc; font-weight: bold; margin: 20px 0;">QUẢN LÝ SẢN PHẨM</h2>

        <!-- Bộ lọc -->
        <div style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 150px;">
                <select id="brandFilter" class="form-control" style="padding: 8px;">
                    <option value="">-- Chọn thương hiệu --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->ten_danh_muc }}</option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 150px;">
                <select id="sortFilter" class="form-control" style="padding: 8px;">
                    <option value="">-- Sắp xếp giá --</option>
                    <option value="asc">Giá: Thấp → Cao</option>
                    <option value="desc">Giá: Cao → Thấp</option>
                </select>
            </div>
            <div style="flex: 2; min-width: 200px;">
                <input type="text" id="searchFilter" class="form-control" placeholder="Tìm kiếm sản phẩm..." style="padding: 8px;">
            </div>
        </div>

        <!-- DataTable -->
        <div style="overflow-x: auto;">
            <table id="productsTable" class="table" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background-color: #f5f5f5; border-bottom: 2px solid #ddd;">
                        <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Tiêu đề</th>
                        <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">CPU</th>
                        <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">RAM</th>
                        <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Ổ cứng</th>
                        <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Khối lượng</th>
                        <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Nhu cầu</th>
                        <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Giá</th>
                        <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Ảnh</th>
                        <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let table = $('#productsTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('products.getData') }}",
                    "type": "GET",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "data": function(d) {
                        d.brand_id = $('#brandFilter').val();
                        d.sort = $('#sortFilter').val();
                        d.search = $('#searchFilter').val();
                    },
                    "error": function(xhr, status, error) {
                        console.log('AJAX Error:', error);
                        console.log('Response:', xhr.responseText);
                    }
                },
                "columns": [
                    { "data": "tieu_de" },
                    { "data": "cpu" },
                    { "data": "ram" },
                    { "data": "luu_tru" },
                    { "data": "khoi_luong" },
                    { "data": "nhu_cau" },
                    { "data": "gia", "render": function(data) {
                        return data + ' đ';
                    }},
                    { "data": "hinh_anh", "render": function(data) {
                        if (data && data.trim() !== '') {
                            let imgPath = "/storage/image/" + data;
                            return '<img src="' + imgPath + '" width="60" height="50" style="object-fit: contain;" onerror="this.style.display=\'none\'" />';
                        }
                        return '<span style="color: #999;">No image</span>';
                    }},
                    { "data": null, "orderable": false, "searchable": false }
                ],
                "columnDefs": [
                    {
                        "targets": -1,
                        "render": function(data, type, row) {
                            return '<button class="btn-sm btn-info view-btn" data-id="' + row.id + '" style="padding: 5px 10px; margin: 2px; border: none; border-radius: 3px; cursor: pointer; background-color: #0066cc; color: white; font-size: 12px;">Xem</button>' +
                                   '<button class="btn-sm btn-danger delete-btn" data-id="' + row.id + '" style="padding: 5px 10px; margin: 2px; border: none; border-radius: 3px; cursor: pointer; background-color: #cc0000; color: white; font-size: 12px;">Xóa</button>';
                        }
                    }
                ],
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50], [10, 25, 50]],
                "language": {
                    "lengthMenu": "_MENU_ entries per page",
                    "search": "Search:",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries to show",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "zeroRecords": "No matching records found",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    },
                    "processing": "Loading..."
                },
                "dom": 'lrt<"bottom"ip>',
                "initComplete": function() {
                    // Styling cho DataTable
                    $('#productsTable_length label').css({
                        "display": "flex",
                        "align-items": "center",
                        "gap": "5px"
                    });
                    $('#productsTable_info').css({
                        "padding": "10px 0"
                    });
                    $('#productsTable_paginate').css({
                        "padding": "10px 0"
                    });
                }
            });

            // Xử lý khi thay đổi filter
            $('#brandFilter, #sortFilter, #searchFilter').on('change keyup', function() {
                table.ajax.reload();
            });

            // Xử lý xóa sản phẩm
            $(document).on('click', '.delete-btn', function() {
                let productId = $(this).data('id');
                
                if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                    $.ajax({
                        url: '/products/' + productId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json'
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log('Success:', response);
                            if (response.success) {
                                alert(response.message || 'Xóa thành công');
                                table.ajax.reload();
                            } else {
                                alert('Lỗi: ' + (response.message || 'Không thể xóa'));
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('Error Status:', xhr.status);
                            console.log('Error Response:', xhr.responseText);
                            
                            if (xhr.status === 404) {
                                alert('Lỗi: Sản phẩm không tồn tại');
                            } else if (xhr.status === 500) {
                                alert('Lỗi server: ' + (xhr.responseJSON?.message || 'Lỗi nội bộ'));
                            } else {
                                alert('Có lỗi xảy ra: ' + error);
                            }
                        }
                    });
                }
            });

            // Xử lý xem chi tiết
            $(document).on('click', '.view-btn', function() {
                let productId = $(this).data('id');
                window.location.href = '/products/' + productId;
            });
        });
    </script>

    <style>
        .table {
            border-collapse: collapse;
            width: 100%;
        }
        .table tbody tr {
            border-bottom: 1px solid #ddd;
        }
        .table tbody tr:hover {
            background-color: #f9f9f9;
        }
        .table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .btn-sm {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            color: white;
            text-decoration: none;
            display: inline-block;
        }
        .btn-info {
            background-color: #0066cc;
        }
        .btn-danger {
            background-color: #cc0000;
        }
        .btn-info:hover {
            background-color: #0052a3;
        }
        .btn-danger:hover {
            background-color: #990000;
        }
        .dataTables_length {
            margin-bottom: 15px;
        }
    </style>
</x-laptop-layout>
