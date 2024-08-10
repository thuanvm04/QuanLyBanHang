@extends('layouts.client')

@section('css')

@endsection

@section('content')
<main>
   
    <div class="cart-main-wrapper section-padding">
        <div class="container">
        @if (session('success'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">Close</button>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">Close</button>
            </div>
            @endif
            <div class="section-bg-color">
               
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Cart Table Area -->
                            <div class="cart-table table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th >Mã đơn hàng</th>
                                            <th >Ngày đặt</th>
                                            <th >Trạng thái</th>
                                            <th >Tổng tiền</th>
                                            <th>Hành động</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($donHangs as $key => $item)
    <tr>
        <td class="text-center">
            <a href="{{route('donhangs.show', $item->id)}}" > 
                {{$item->ma_don_hang}}
            </a>
        </td>
        <td>
            {{$item->created_at->format('d/m/Y H:i:s')}}
        </td>
        <td>
            {{$trangThaiDonHang[$item->trang_thai_don_hang]}}
        </td>
        <td>
            {{number_format($item->tong_tien,0 , '','.')}}đ
        </td>
        <td>
            <a href="{{route('donhangs.show', $item->id)}}" class="btn btn-sqr">View</a>
            @if ($item->trang_thai_don_hang === $type_cho_xac_nhan)
                <form action="{{route('donhangs.update', $item->id)}}" method="POST" class="d-inline" style="display: inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="huy_don_hang" id="" value="1">
                    <button type="submit" class="btn btn-sqr bg-danger" onclick="return confirm('Bạn có chắc muốn huỷ đơn hàng ?')">Huỷ</button>
                </form>
            @endif
            @if ($item->trang_thai_don_hang === $type_dang_van_chuyen)
                <form action="{{route('donhangs.update', $item->id)}}" method="POST" class="d-inline" style="display: inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="da_giao_hang" id="" value=" 1">
                    <button type="submit" class="btn btn-sqr bg-success" onclick="return confirm('Bạn có xác nhận đã nhận hàng ?')">Đã nhận</button>
                </form>
            @endif
        </td>
    </tr>
@endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Cart Update Option -->
                            <div class="cart-update-option d-block d-md-flex justify-content-end">
                                <div class="cart-update">
                                    <button type="submit" class="btn btn-sqr">Update Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                
                
            </div>
        </div>
    </div>
    <!-- cart main wrapper end -->
</main>
@endsection

@section('js')

@endsection