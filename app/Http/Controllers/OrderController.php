<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Mail\OrderConfirm;
use Illuminate\Http\Request;
use App\Models\ChiTietDonHang;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $donHangs = Auth::user()->donHang;

        $trangThaiDonHang = DonHang::TRANG_THAI_DON_HANG;

        $type_cho_xac_nhan = DonHang::CHO_XAC_NHAN;

        $type_dang_van_chuyen = DonHang::DANG_VAN_CHUYEN;
        return view('clients.donhangs.index', compact('donHangs', 'trangThaiDonHang', 'type_cho_xac_nhan', 'type_dang_van_chuyen'));
    }

    public function create()
    {
        $carts = session()->get('cart', []);
        Log::info('Cart contents: ' . json_encode($carts));

        if (!empty($carts)) {
            $subTotal = 0;
            foreach ($carts as $item) {
                $subTotal += $item['so_luong'] * $item['gia'] * 0.9;
            }
            $shipping = 30000;
            $total = $subTotal + $shipping;

            return view('clients.donhangs.create', compact('total', 'subTotal', 'shipping', 'carts'));
        }

        return redirect()->route('cart.list')->with('error', 'Giỏ hàng trống');
    }

    public function store(Request $request)  // Temporarily using Request instead of OrderRequest
    {
        Log::info('Order store method called');
        Log::info('Request data: ' . json_encode($request->all()));

        if ($request->isMethod('POST')) {
            DB::beginTransaction();
            try {
                $params = $request->except('_token');
                $params['ma_don_hang'] = $this->generateUniqueOrderCode();
                $params['user_id'] = Auth::id();  // Ensure user_id is set

                Log::info('Order data before creation: ' . json_encode($params));

                $donHang = DonHang::create($params);
                $donHangId = $donHang->id;

                $carts = session()->get('cart', []);
                Log::info('Cart data for order creation: ' . json_encode($carts));

                foreach ($carts as $key => $item) {
                    $thanhTien = $item['so_luong'] * $item['gia'];
                    $donHang->ChiTietDonHang()->create([
                        'don_hang_id' => $donHangId,
                        'san_pham_id' => $key,
                        'don_gia' => $item['gia'],
                        'so_luong' => $item['so_luong'],
                        'thanh_tien' => $thanhTien
                    ]);
                }

                DB::commit();

                // gửi mail
                Mail::to($donHang->email_nguoi_nhan)->queue(new OrderConfirm($donHang));


                session()->forget('cart');
                Log::info('Order created successfully: ' . $donHang->id);

                return redirect()->route('donhangs.index')->with('success', 'Đặt hàng thành công!');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error creating order: ' . $e->getMessage());
                return redirect()->route('cart.list')->with('error', 'Đã xảy ra lỗi khi đặt hàng: ' . $e->getMessage());
            }
        }

        return redirect()->route('cart.list')->with('error', 'Phương thức không hợp lệ');
    }

    public function show(string $id)
    {
        $donHang = DonHang::findOrFail($id);

        $trangThaiDonHang = DonHang::TRANG_THAI_DON_HANG;

        $trangThaiThanhToan = DonHang::TRANG_THAI_THANH_TOAN;





        return view('clients.donhangs.show', compact(
            'donHang',
            'trangThaiDonHang',
            'trangThaiThanhToan'
        ));
    }


    public function update(Request $request, string $id)
    {
        $donHang =  DonHang::query()->findOrFail($id);
        DB::beginTransaction();

        try {

            if ($request->has('huy_don_hang')) {
                $donHang->update(['trang_thai_don_hang' => DonHang::HUY_DON_HANG]);
            } else if ($request->has('da_giao_hang')) {
                $donHang->update(['trang_thai_don_hang' => DonHang::DA_GIAO_HANG]);
            }

            DB::commit();

          
        } catch (\Exception $e) {
            DB::rollBack();
        }
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        // Implement destroy logic here
    }

    private function generateUniqueOrderCode()
    {
        do {
            $orderCode = 'ORD-' . Auth::id() . "-" . now()->timestamp . "-" . rand(1000, 9999);
        } while (DonHang::where('ma_don_hang', $orderCode)->exists());
        return $orderCode;
    }
}
