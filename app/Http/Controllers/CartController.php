<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function listCart()
    {  
        
        $cart = session()->get('cart');

        $total = 0;
        $subTotal = 0;

        foreach ($cart as $key => $item) {
            $subTotal += $item['so_luong'] * $item['gia'];
           
        }
        $shipping = 3000;
        $total = $subTotal + $shipping;

        return view('clients.giohang', compact('cart','total','subTotal','shipping'));
    }
    public function addCart(Request $request)
    {
        $productID= $request->input('product_id');
        $quantity= $request->input('quantity');

        $sanPham = SanPham::query()->findOrFail($productID);

        // khởi tạo mảng chứa thông tin giỏ hàng trên session

        $cart = session()->get('cart', []);
        if (isset($cart[$productID])) {
            //sản phẩm đã có trong mảng cart
            $cart[$productID]['so_luong'] += $quantity;
        }else{
             // sản phẩm chưa có trong mảng cart
             $cart[$productID] =[
                 'ten_san_pham' => $sanPham->ten_san_pham,
                //  'don_gia' => $sanPham->gia_san_pham,
                 'so_luong' => $quantity,
                 'hinh_anh' => $sanPham->hinh_anh,
                 'gia' => isset($sanPham->gia_khuyen_mai) ? $sanPham->gia_khuyen_mai : $sanPham->gia_san_pham,

             ];
        } 
        session()->put('cart', $cart);
        // dd(session()->get('cart'));
        return redirect()->back();
       
    }
    public function updateCart(Request $request)
    {
        $cartnew = $request->input('cart',[]);

        session()->put('cart', $cartnew);

      return redirect()->back();
    }
}
