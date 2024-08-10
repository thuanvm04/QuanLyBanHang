<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaiVietRequest;
use App\Http\Resources\BaiVietResource;
use App\Models\BaiViet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiBaiVietController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BaiViet::query();

        if ($request->has('tieu_de')) {
            $query->where('tieu_de', 'like', '%' . $request->input('tieu_de') . '%');
        }

        $baiViets = $query->paginate(10);

        return BaiVietResource::collection($baiViets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BaiVietRequest $request)
    {
        $params = $request->all();

        if ($request->hasFile('hinh_anh')) {
            $imagePath = $request->file('hinh_anh')->store('uploads/baiviets', 'public');
            $params['hinh_anh'] = $imagePath;
        }

        $baiViet = BaiViet::create($params);

        return response()->json([
            'data' => new BaiVietResource($baiViet),
            'status' => true,
            'message' => 'Bài viết đã được thêm thành công.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $baiViet = BaiViet::query()->findOrFail($id);

        return new BaiVietResource($baiViet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BaiVietRequest $request, string $id)
    {
        $baiViet = BaiViet::query()->findOrFail($id);

        $params = $request->all();

        // Xử lý ảnh 
        if ($request->hasFile('hinh_anh')) {
            if ($baiViet->hinh_anh && Storage::disk('public')->exists($baiViet->hinh_anh)) {
                Storage::disk('public')->delete($baiViet->hinh_anh);
            }

            $imagePath = $request->file('hinh_anh')->store('uploads/baiviets', 'public');
            $params['hinh_anh'] = $imagePath;
        }

        $baiViet->update($params);

        return response()->json([
            'data' => new BaiVietResource($baiViet),
            'status' => true,
            'message' => 'Bài viết đã được sửa thành công.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $baiViet = BaiViet::query()->findOrFail($id);

        if ($baiViet->hinh_anh && Storage::disk('public')->exists($baiViet->hinh_anh)) {
            Storage::disk('public')->delete($baiViet->hinh_anh);
        }

        $baiViet->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa bài viết thành công.'
        ], 200);
    }
}
