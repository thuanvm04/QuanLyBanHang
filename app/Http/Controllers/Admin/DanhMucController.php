<?php

namespace App\Http\Controllers\Admin;

use App\Models\Danhmuc;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\DanhMucRequest;
use Illuminate\Support\Facades\Storage;

class DanhMucController extends Controller
{
    public function index()
    {
        $title = "Danh mục sản phẩm";
        $listDanhmuc = Danhmuc::all();

        return view('admins.danhmucs.index', compact('title', 'listDanhmuc'));
    }

    public function create()
    {
        $title = "Thêm danh mục sản phẩm";
        return view('admins.danhmucs.create', compact('title'));
    }

    public function store(DanhMucRequest $request)
    {
        if ($request->isMethod('POST')) {
            $param = $request->except('_token');
            if ($request->hasFile('hinh_anh')) {
                $filepath = $request->file('hinh_anh')->store('uploads/danhmucs', 'public');
            } else {
                $filepath = null;
            }
            $param['hinh_anh'] = $filepath;
            Danhmuc::create($param);
            return redirect()->route('admins.danhmucs.index')->with('success', 'Đã thêm danh mục thành công');
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $title = "Chỉnh sửa danh mục sản phẩm";
        $danhmuc = Danhmuc::findOrFail($id);
        return view('admins.danhmucs.edit', compact('title', 'danhmuc'));
    }

    public function update(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $param = $request->except('_token', '_method');
            $danhmuc = Danhmuc::findOrFail($id);

            if ($request->hasFile('hinh_anh')) {
                if ($danhmuc->hinh_anh && Storage::disk('public')->exists($danhmuc->hinh_anh)) {
                    Storage::disk('public')->delete($danhmuc->hinh_anh);
                }
                $filepath = $request->file('hinh_anh')->store('uploads/danhmucs', 'public');
                $param['hinh_anh'] = $filepath;
            }
           
            $danhmuc->update($param);
            return redirect()->route('admins.danhmucs.index')->with('success', 'Cập nhật danh mục thành công');
        }
    }

   public function destroy(string $id)
{
    try {
        DB::beginTransaction();

        // Lấy danh mục cần xóa
        $danhmuc = Danhmuc::findOrFail($id);

        // Lấy tất cả sản phẩm liên quan đến danh mục này
        $sanPhams = SanPham::where('danhmuc_id', $danhmuc->id)->get();

        // Xóa tất cả sản phẩm liên quan
        foreach ($sanPhams as $sanPham) {
            // Xóa hình ảnh sản phẩm nếu có
            if ($sanPham->hinh_anh && Storage::disk('public')->exists($sanPham->hinh_anh)) {
                Storage::disk('public')->delete($sanPham->hinh_anh);
            }

            // Xóa sản phẩm
            $sanPham->delete();
        }

        // Xóa hình ảnh của danh mục nếu có
        if ($danhmuc->hinh_anh && Storage::disk('public')->exists($danhmuc->hinh_anh)) {
            Storage::disk('public')->delete($danhmuc->hinh_anh);
        }

        // Xóa danh mục
        $danhmuc->delete();

        DB::commit();

        return redirect()->route('admins.danhmucs.index')->with('success', 'Xoá danh mục thành công');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
    }
}


}