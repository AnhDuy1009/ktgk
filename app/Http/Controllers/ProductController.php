<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index(Request $request)
    {
        $query = Product::active();

        // Lọc theo thương hiệu
        if ($request->has('brand_id') && $request->brand_id != '') {
            $query->where('id_danh_muc', $request->brand_id);
        }

        // Sắp xếp theo giá
        if ($request->sort == 'asc') {
            $query->orderBy('gia', 'asc');
        } elseif ($request->sort == 'desc') {
            $query->orderBy('gia', 'desc');
        } else {
            $query->latest('id');
        }

        // Phân trang (10 sản phẩm mỗi trang)
        $products = $query->paginate(10);

        // Lấy danh sách thương hiệu
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    // Hiển thị chi tiết sản phẩm
    public function show($id)
    {
        $product = Product::active()->find($id);

        if (!$product) {
            abort(404, 'Sản phẩm không tồn tại hoặc đã được xóa');
        }

        $categories = Category::all();

        return view('products.show', compact('product', 'categories'));
    }

    // Xóa mềm sản phẩm
    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại'], 404);
            }

            // Cập nhật status = 0 (xóa mềm)
            $product->update(['status' => 0]);

            return response()->json([
                'success' => true, 
                'message' => 'Sản phẩm đã được xóa thành công'
            ]);
        } catch (\Exception $e) {
            \Log::error('Delete product error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Lỗi khi xóa: ' . $e->getMessage()
            ], 500);
        }
    }

    // API endpoint để lấy danh sách sản phẩm cho DataTable (AJAX)
    public function getData(Request $request)
    {
        try {
            $query = Product::active();

            // Lọc theo thương hiệu
            if ($request->has('brand_id') && $request->brand_id != '') {
                $query->where('id_danh_muc', $request->brand_id);
            }

            // Sắp xếp
            if ($request->has('sort') && $request->sort != '') {
                if ($request->sort == 'asc') {
                    $query->orderBy('gia', 'asc');
                } elseif ($request->sort == 'desc') {
                    $query->orderBy('gia', 'desc');
                }
            } else {
                $query->latest('id');
            }

            // Tìm kiếm
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('tieu_de', 'like', '%' . $search . '%')
                      ->orWhere('ten', 'like', '%' . $search . '%')
                      ->orWhere('cpu', 'like', '%' . $search . '%')
                      ->orWhere('ram', 'like', '%' . $search . '%');
                });
            }

            // Tính tổng số sản phẩm
            $total = $query->count();

            // Phân trang
            $start = $request->get('start', 0);
            $length = $request->get('length', 10);

            $products = $query->offset($start)
                             ->limit($length)
                             ->get();

            // Format dữ liệu cho DataTable
            $data = [];
            foreach ($products as $product) {
                $data[] = [
                    'id' => $product->id,
                    'tieu_de' => $product->tieu_de ?? 'N/A',
                    'cpu' => $product->cpu ? substr($product->cpu, 0, 50) . '...' : 'N/A',
                    'ram' => $product->ram ?? 'N/A',
                    'luu_tru' => $product->luu_tru ?? 'N/A',
                    'khoi_luong' => $product->khoi_luong ?? 'N/A',
                    'nhu_cau' => $product->nhu_cau ?? 'N/A',
                    'gia' => number_format($product->gia, 0, ',', '.'),
                    'hinh_anh' => $product->hinh_anh ?? ''
                ];
            }

            return response()->json([
                'draw' => intval($request->get('draw', 1)),
                'recordsTotal' => intval($total),
                'recordsFiltered' => intval($total),
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'draw' => intval($request->get('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
