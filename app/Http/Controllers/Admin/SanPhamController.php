<?php

namespace App\Http\Controllers\Admin;

use App\Models\Danhmuc;
use App\Models\SanPham;
use Illuminate\Http\Request;
use App\Models\HinhAnhSanPham;
use App\Http\Controllers\Controller;
use App\Http\Requests\SanPhamRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SanPhamController extends Controller
{
    public function index()
    {
        $title = "Thông tin sản phẩm";
        $listSanpham = SanPham::all();

        return view('admins.sanphams.index', compact('title', 'listSanpham'));
    }

    public function create()
    {
        $title = "Thêm sản phẩm";
        $listDanhMuc = Danhmuc::all();

        return view('admins.sanphams.create', compact('title', 'listDanhMuc'));
    }

    public function store(SanPhamRequest $request)
    {
        try {
            DB::beginTransaction();

            $params = $request->except('_token');

            // Kiểm tra mã sản phẩm đã tồn tại chưa
            if (SanPham::where('ma_san_pham', $params['ma_san_pham'])->exists()) {
                return back()->withErrors(['ma_san_pham' => 'Mã sản phẩm đã tồn tại'])->withInput();
            }

            $params['is_new'] = $request->has('is_new') ? 1 : 0;
            $params['is_hot'] = $request->has('is_hot') ? 1 : 0;
            $params['is_hot_deal'] = $request->has('is_hot_deal') ? 1 : 0;
            $params['is_show_home'] = $request->has('is_show_home') ? 1 : 0;

            $params['noi_dung'] = $request->input('noi_dung');
           

            if ($request->hasFile('hinh_anh')) {
                $params['hinh_anh'] = $request->file('hinh_anh')->store('uploads/sanpham', 'public');
            }

            $sanPham = SanPham::create($params);

            if ($sanPham && $request->hasFile('list_hinh_anh')) {
                foreach ($request->file('list_hinh_anh') as $hinhAnh) {
                    $path = $hinhAnh->store('uploads/hinhanhsanpham/id_' . $sanPham->id, 'public');
                    $sanPham->hinhAnhSanPham()->create([
                        'hinh_anh' => $path,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admins.sanphams.index')->with('success', 'Đã thêm sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi thêm sản phẩm: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $title = "Cập nhật thông tin sản phẩm";
        $listDanhMuc = Danhmuc::all();
        $sanPham = SanPham::findOrFail($id);

        return view('admins.sanphams.edit', compact('title', 'listDanhMuc', 'sanPham'));
    }

    public function update(SanPhamRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $sanPham = SanPham::findOrFail($id);
            $params = $request->except('_token', '_method');

            // Kiểm tra mã sản phẩm có bị thay đổi và đã tồn tại chưa
            if ($params['ma_san_pham'] !== $sanPham->ma_san_pham &&
                SanPham::where('ma_san_pham', $params['ma_san_pham'])->exists()) {
                return back()->withErrors(['ma_san_pham' => 'Mã sản phẩm đã tồn tại'])->withInput();
            }

            $params['is_new'] = $request->has('is_new') ? 1 : 0;
            $params['is_hot'] = $request->has('is_hot') ? 1 : 0;
            $params['is_hot_deal'] = $request->has('is_hot_deal') ? 1 : 0;
            $params['is_show_home'] = $request->has('is_show_home') ? 1 : 0;
            // $params['noi_dung'] = $request->input('noi_dung');

            if ($request->hasFile('hinh_anh')) {
                if ($sanPham->hinh_anh && Storage::disk('public')->exists($sanPham->hinh_anh)) {
                    Storage::disk('public')->delete($sanPham->hinh_anh);
                }
                $params['hinh_anh'] = $request->file('hinh_anh')->store('uploads/sanpham', 'public');
            }

            $sanPham->update($params);

            // Xử lý album ảnh
            if ($request->hasFile('list_hinh_anh')) {
                $currentImages = $sanPham->hinhAnhSanPham()->pluck('id')->toArray();
                $newImages = array_keys($request->list_hinh_anh);

                // Xóa ảnh cũ không còn trong danh sách mới
                foreach ($currentImages as $imageId) {
                    if (!in_array($imageId, $newImages)) {
                        $image = HinhAnhSanPham::find($imageId);
                        if ($image) {
                            Storage::disk('public')->delete($image->hinh_anh);
                            $image->delete();
                        }
                    }
                }

                // Thêm hoặc cập nhật ảnh mới
                foreach ($request->list_hinh_anh as $key => $image) {
                    if (is_file($image)) {
                        $path = $image->store('uploads/hinhanhsanpham/id_' . $id, 'public');
                        if (is_numeric($key)) {
                            // Cập nhật ảnh hiện có
                            $hinhAnhSanPham = HinhAnhSanPham::find($key);
                            if ($hinhAnhSanPham) {
                                Storage::disk('public')->delete($hinhAnhSanPham->hinh_anh);
                                $hinhAnhSanPham->update(['hinh_anh' => $path]);
                            }
                        } else {
                            // Thêm ảnh mới
                            $sanPham->hinhAnhSanPham()->create(['hinh_anh' => $path]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('admins.sanphams.index')->with('success', 'Đã cập nhật sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật sản phẩm: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $sanPham = SanPham::findOrFail($id);

            // Xóa hình ảnh chính
            if ($sanPham->hinh_anh && Storage::disk('public')->exists($sanPham->hinh_anh)) {
                Storage::disk('public')->delete($sanPham->hinh_anh);
            }

            // Xóa album ảnh
            foreach ($sanPham->hinhAnhSanPham as $hinhAnh) {
                Storage::disk('public')->delete($hinhAnh->hinh_anh);
            }
            $sanPham->hinhAnhSanPham()->delete();

            // Xóa thư mục chứa ảnh sản phẩm
            $path = 'uploads/hinhanhsanpham/id_' . $sanPham->id;
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->deleteDirectory($path);
            }

            // Xóa sản phẩm
            $sanPham->delete();

            DB::commit();
            return redirect()->route('admins.sanphams.index')->with('success', 'Đã xóa sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage());
        }
    }
}