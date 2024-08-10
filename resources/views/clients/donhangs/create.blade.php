@extends('layouts.client')

@section('css')
@endsection

@section('content')
<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Đặt hàng</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- checkout main wrapper start -->
    <div class="checkout-page-wrapper section-padding">
        <div class="container">
            <form action="{{ route('donhangs.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Checkout Billing Details -->
                    <div class="col-lg-6">
                        <div class="checkout-billing-details-wrap">
                            <h5 class="checkout-title">Thông tin đặt hàng</h5>
                            <div class="billing-form-wrap">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                

                                <div class="single-input-item">
                                    <label for="ten_nguoi_nhan" class="required">Tên người nhận</label>
                                    <input type="text" id="ten_nguoi_nhan" name="ten_nguoi_nhan" value="{{ Auth::user()->name }}">
                                    @error('ten_nguoi_nhan')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>

                                <div class="single-input-item">
                                    <label for="email_nguoi_nhan" class="required">Email người nhận</label>
                                    <input type="email" id="email_nguoi_nhan" name="email_nguoi_nhan" value="{{ Auth::user()->email }}">
                                    @error('email_nguoi_nhan')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>

                                <div class="single-input-item">
                                    <label for="so_dien_thoai_nguoi_nhan" class="required">Số điện thoại người nhận</label>
                                    <input type="text" id="so_dien_thoai_nguoi_nhan" name="so_dien_thoai_nguoi_nhan" value="{{  Auth::user()->phone }}">
                                    @error('so_dien_thoai_nguoi_nhan')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>

                                <div class="single-input-item">
                                    <label for="dia_chi_nguoi_nhan" class="required">Địa chỉ người nhận</label>
                                    <input type="text" id="dia_chi_nguoi_nhan" name="dia_chi_nguoi_nhan" value="{{  Auth::user()->address }}">
                                    @error('dia_chi_nguoi_nhan')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>

                                <div class="single-input-item">
                                    <label for="ghi_chu">Ghi chú</label>
                                    <textarea name="ghi_chu" id="ghi_chu" cols="30" rows="3" placeholder="Ghi chú">{{ old('ghi_chu') }}</textarea>
                                </div>

                                <!--  -->
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Details -->
                    <div class="col-lg-6">
                        <div class="order-summary-details">
                            <h5 class="checkout-title">Tổng quan đơn hàng</h5>
                            <div class="order-summary-content">
                                <!-- Order Summary Table -->
                                <div class="order-summary-table table-responsive text-center">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($carts as $key => $item)
                                            <tr>
                                                <td>
                                                    <a href="{{route('products.detail', $key)}}">
                                                        {{$item['ten_san_pham']}}<strong> × {{$item['so_luong']}}</strong>
                                                    </a>
                                                </td>
                                                <td>{{number_format($item['gia'] * $item['so_luong'], 0, ',', '.')}}đ</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>Tổng tiền hàng</td>
                                                <td><strong>{{number_format($subTotal, 0, ',', '.')}}đ</strong></td>
                                                <input type="hidden" name="tien_hang" value="{{ $subTotal }}">
                                            </tr>
                                            <tr>
                                                <td>Phí vận chuyển</td>
                                                <td><strong>{{number_format($shipping, 0, ',', '.')}}đ</strong></td>
                                                <input type="hidden" name="tien_ship" value="{{$shipping}}">
                                            </tr>
                                            <tr>
                                                <td>Tổng cộng</td>
                                                <td><strong>{{number_format($total, 0, ',', '.')}}đ</strong></td>
                                                <input type="hidden" name="tong_tien" value="{{$total}}">
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>


                                <div class="summary-footer-area mt-5">
                                    <button type="submit" class="btn btn-sqr">Xác nhận đặt hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    </div>
    
    <!-- checkout main wrapper end -->
</main>
@endsection

@section('js')
@endsection