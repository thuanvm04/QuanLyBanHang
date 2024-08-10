<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use Illuminate\Http\Request;

class DonHangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Danh sách đơn hàng";
        $listDonHang = DonHang::query()->orderBy('id', 'desc')->get();
        $trangThaiDonHang = DonHang::TRANG_THAI_DON_HANG;

        return view('admins.donhangs.index', compact('title', 'listDonHang', 'trangThaiDonHang'));
    }

 
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $donHang= DonHang::query()->findOrFail($id);
       $currentStatus = $donHang->trang_thai_don_hang;
       $newTrangThai = $request->input('trang_thai_don_hang');
       $trangThai = array_keys(DonHang::TRANG_THAI_DON_HANG);
      if ($currentStatus === DonHang::HUY_DON_HANG) {
        return redirect()->route('admins.donhangs.index')->with('error', 'Đơn hàng đã bị huỷ');
          
      }
      if (array_search($newTrangThai, $trangThai) < array_search($currentStatus, $trangThai)) {
        return redirect()->route('admins.donhangs.index')->with('error', 'Không thể cập nhật lại !');
      }
$donHang->trang_thai_don_hang = $newTrangThai;
$donHang->save();
return redirect()->route('admins.donhangs.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
