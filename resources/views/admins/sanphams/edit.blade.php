@extends('layouts.admin')
@section('title')
{{$title}}
@endsection

@section('css')
<!-- Quill css -->
<link href="{{asset('assets/admin/libs/quill/quill.core.js')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/libs/quill/quill.snow.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/admin/libs/quill/quill.bubble.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Quản lí thông tin sản phẩm</h4>
            </div>
        </div>



    </div> <!-- container-fluid -->
</div> <!-- content -->

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h5 class="card-title mb-0">{{$title}}</h5>

            </div><!-- end card header -->

            <div class="card-body">

                <form action="{{route('admins.sanphams.update', $sanPham->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="mb-3">
                                <label for="ma_san_pham" class="form-label">Mã sản phẩm</label>
                                <input type="text" id="ma_san_pham" name="ma_san_pham" class="form-control
                                @error('ma_san_pham') is-invalid @enderror" value="{{$sanPham->ma_san_pham}}" placeholder="">
                                @error('ma_san_pham')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ten_san_pham" class="form-label">Tên sản phẩm</label>
                                <input type="text" id="ten_san_pham" name="ten_san_pham" class="form-control
                                @error('ten_san_pham') is-invalid @enderror" value="{{$sanPham->ten_san_pham}}" placeholder="Nhập tên sản phẩm">
                                @error('ten_san_pham')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="gia_san_pham" class="form-label">Giá sản phẩm</label>
                                <input type="number" id="gia_san_pham" name="gia_san_pham" class="form-control
                                @error('gia_san_pham') is-invalid @enderror" value="{{$sanPham->gia_san_pham}}" placeholder="Nhập giá sản phẩm">
                                @error('gia_san_pham')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="gia_khuyen_mai" class="form-label">Khuyến mãi</label>
                                <input type="number" id="gia_khuyen_mai" name="gia_khuyen_mai" class="form-control
                                @error('gia_khuyen_mai') is-invalid @enderror " value="{{$sanPham->gia_khuyen_mai}}" placeholder="Khuyến mãi">
                                @error('gia_khuyen_mai')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="danhmuc_id" class="form-label">Danh mục</label>
                                <select class="form-control form-select
                               " name="danhmuc_id">
                                    <option selected>--Tuỳ chọn--</option>
                                    @foreach($listDanhMuc as $danhMuc)
                                    <option value="{{$danhMuc->id}}" {{$sanPham->danhmuc_id == $danhMuc->id ? 'selected' : ''}}>
                                        {{ $danhMuc->ten_danh_muc }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('danhmuc_id')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="so_luong" class="form-label">Số lượng sản phẩm</label>
                                <input type="number" id="so_luong" name="so_luong" class="form-control
                                @error('so_luong') is-invalid @enderror" value="{{$sanPham->so_luong}}" placeholder="Số lượng sản phẩm">
                                @error('so_luong')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ngay_nhap" class="form-label">Ngày nhập</label>
                                <input type="date" id="ngay_nhap" name="ngay_nhap" class="form-control
                                @error('ngay_nhap') is-invalid @enderror" value="{{$sanPham->ngay_nhap}}" placeholder="Ngày nhập sản phẩm">
                                @error('ngay_nhap')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mo_ta_ngan" class="form-label">Mô tả ngắn</label>

                                <textarea name="mo_ta_ngan" class="form-control
                                 @error('mo_ta_ngan') is-invalid @enderror" id="mo_ta_ngan" row="3" placeholder="Mô tả ngắn">{{$sanPham->mo_ta_ngan}}</textarea>
                                @error('mo_ta_ngan')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="is_type" class="form-label">Tuỳ chỉnh khác</label>
                            <div class=" form-switch mb-2 ps-3 d-flex justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input bg-danger" type="checkbox" id="is_new" name="is_new" {{$sanPham->is_new == 1 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="is_new">New</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input bg-secondary" type="checkbox" id="is_hot" name="is_hot" {{$sanPham->is_hot == 1 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="is_hot">Hot</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input bg-warning" type="checkbox" id="is_hot_deal" name="is_hot_deal" {{$sanPham->is_hot_deal == 1 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="is_hot_deal">Hot dealt</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input bg-success" type="checkbox" id="is_show_home" name="is_show_home" {{$sanPham->is_show_home == 1 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="is_show_home">Show home</label>
                                </div>

                            </div>

                        </div>


                        <div class="col-lg-7">
                            <div class="mb-3 ">
                                <label for="example-select" class="form-label">Mô tả chi tiết sản phẩm</label>
                                <div id="quill-editor" style="height: 400px;">
                                    <h1>Nhập mô tả chi tiết sản phẩm</h1>

                                </div>
                                <textarea name="noi_dung" id="content" class="d-none"></textarea>
                            </div>


                            <div class="mb-3">
                                <label for="hinh_anh" class="form-label">Hình ảnh</label>
                                <input type="file" id="hinh_anh" name="hinh_anh" class="form-control" onchange="showImage(event)">
                                <img src="{{Storage::url($sanPham->hinh_anh)}}" id="img_danh_muc" alt="Hình ảnh sản phẩm" style="width: 100px ">
                                @error('hinh_anh')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Album hình ảnh</label>
                                <i id="add-row" class="mdi mdi-plus text-muted fs-18 rounded-2 
                                        border p-1 ms-3 style=" cursor:pointer"></i>
                                <table class="table align-middle table-nowrap mb-0">
                                    <tbody id="image-table-body">

                                        @foreach ($sanPham->hinhAnhSanPham as $index => $hinhAnh)
                                        <tr>
                                            <td class="d-flex align-items-center">
                                                <img src="{{Storage::url($hinhAnh->hinh_anh)}}" id="preview_{{$index}}" alt="Hình ảnh sản phẩm" style="width: 75px ">
                                                <input type="file" id="hinh_anh" name="list_hinh_anh[{{$hinhAnh->id}}]" class="form-control" onchange="previewImage(this, { $index } )">
                                                <input type="hidden" name="list_hinh_anh[{{$hinhAnh->id}}" value="{{$hinhAnh->id}}" id="">

                                            </td>
                                            <td> <i class="mdi mdi-delete text-muted fs-18 rounded-2 
                                        border p-1 style=" cursor:pointer" onclick="removeRow(this)"></i>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                            </div>



                        </div>


                        <div class="col-sm-10 d-flex gap-2">
                            <label for="is_type" class="form-label">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_type" id="gridRadios1" value="0" {{$sanPham->is_type == 0 ? 'checked' : ''}}>
                                <label class="form-check-label text-danger" for="gridRadios1">
                                    Ẩn
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_type" id="gridRadios2" value="1" {{$sanPham->is_type == 1 ? 'checked' : ''}}>
                                <label class="form-check-label text-success" for="gridRadios2">
                                    Hiển thị
                                </label>
                            </div>
                        </div>


                        <div class="d-flex mt-3">
                            <button type="submit" class="btn btn-primary me-2">Chỉnh sửa</button>
                            <a href="{{route('admins.sanphams.index')}}" class="btn btn-secondary">Quay lại</a>
                        </div>



                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('assets/admin/libs/quill/quill.min.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        var quill = new Quill("#quill-editor", {
            theme: 'snow'
        });
     

        // Hiển thị nội dung cũ
        var old_content = `{!! $sanPham -> noi_dung !!}`;
        quill.root.innerHTML = old_content;

        // Cập nhật lại textarea khi nội dung quill-editor thay đổi
        quill.on('text-change', function(delta, oldDelta, source) {
            document.getElementById('content').value = quill.root.innerHTML;
        });
    });

    function showImage(event) {
        var output = document.getElementById('img_danh_muc');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.style.display = 'block';
    }

    function previewImage(input, index) {
        var file = input.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('preview_' + index);
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    function removeRow(element) {
        var row = element.closest('tr');
        row.remove();
    }

    document.getElementById('add-row').addEventListener('click', function() {
        
        var tableBody = document.getElementById('image-table-body');
        var index = tableBody.children.length;
        var newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="d-flex align-items-center">
                <img src="https://www.shutterstock.com/image-vector/img-vector-icon-design-on-260nw-2164648583.jpg" 
                id="preview_${index}" alt="Hình ảnh sản phẩm" style="width: 75px">
                <input type="file" id="hinh_anh_${index}" name="list_hinh_anh[id_${index}]" 
                class="form-control" onchange="previewImage(this, ${index})">
            </td>
            <td>
                <i class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1" style="cursor:pointer" onclick="removeRow(this)"></i>
            </td>
        `;
        tableBody.appendChild(newRow);
    });
</script>


<script src="{{asset('assets/admin/libs/quill/quill.core.js')}}"></script>
<script src="{{asset('assets/admin/libs/quill/quill.min.js')}}"></script>

@endsection