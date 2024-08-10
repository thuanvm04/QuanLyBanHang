@extends('layouts.admin')
@section('title')
{{$title}}
@endsection

@section('css')

@endsection
@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Quản lí đơn hàng</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">


                    <div class="card-body">
                        <div class="table-responsive">

                            @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">Close</button>
                            </div>
                            @endif
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th>Ngày đặt</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>

                                    </tr>
                                    <div class="mb-3">
                                <label for="simpleinput" class="form-label">Tên danh mục</label>
                                <input type="text" id="ten_danh_muc" name="ten_danh_muc" class="form-control" 
                                @error('ten_danh_muc') is-invalid @enderror
                                 value="{{old('ten_danh_muc')}}" placeholder="Nhập tên danh mục">
                                @error('ten_danh_muc')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                                </thead>
                                <tbody>
                                    @foreach ($listDonHang as $key => $item)
                                    <tr>
                                        <td class="">
                                            <a href="{{route('admins.donhangs.show', $item->id)}}">
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
                                            <form action="{{route('admins.donhangs.update' , $item->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select class="form-select" name="trang_thai_don_hang"
                                                onchange="confirmSubmi(this)"
                                                data-default-value={{$item->trang_thai_don_hang}}">
                                                    
                                                    @foreach ($trangThaiDonHang as $key => $trangThai)
                                                    <option value="{{$key}}" @if($item->trang_thai_don_hang == $key) selected @endif>
                                                        {{$trangThai}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-primary">Thay đổi</button>
                                            </form>
                                        </td>
                                        </td>
                                        <td>
                                            
                                                <i class="mdi mdi-eye text-muted fs-18 rounded-2 border p-1 me-1"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div> <!-- content -->

@endsection
@section('js')
<script>
    function confirmSubmi(selectElement) {
       var form = selectElement.closest('form');
       var selectedOp=selectElement.options[selectElement.selectedIndex].text;

       var defaultValue =selectElement.getAttribute('data-default-value');
       if(confirm("Bạn có chắc muốn thay đổi trạng thái ?")){
           form.submit();
       }else{
        selectElement.value=defaultValue;
       }
    }
</script>
@endsection