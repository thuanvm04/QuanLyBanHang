@component('mail::message')
# Xác nhận đơn hàng

Xin chào {{$donHang->ten_nguoi_nhan}},

Cảm ơn bạn đã đặt hàng . Đây là thông tin đơn hàng của bạn .

*** Mã đơn hàng *** {{$donHang->ma_don_hang}}

*** Sản phẩm đã đặt ***
@foreach ($donHang->chiTietDonHang as $chiTiet)
@if ($chiTiet->sanPham)
- {{$chiTiet->sanPham->ten_san_pham}} X {{$chiTiet->so_luong}} :
{{number_format($chiTiet->thanh_tien)}} VND
@endif
@endforeach

*** Tổng tien *** {{number_format($donHang->tong_tien)}} VND

Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận thông tin giao hàng . #

Trân trọng .

@endcomponent