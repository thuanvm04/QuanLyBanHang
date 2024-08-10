@extends('layouts.client')

@section('css')
<style>
    .tab-one img {
        max-width: 250px;
    }
</style>
@endsection

@section('content')
<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <!-- ... (giữ nguyên phần này) ... -->
    </div>
    <!-- breadcrumb area end -->

    <!-- cart main wrapper start -->
    <div class="cart-main-wrapper section-padding">
        <div class="container">
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">Close</button>
            </div>
            @endif
            <div class="section-bg-color">
                <form action="{{ route('cart.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Cart Table Area -->
                            <div class="cart-table table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="pro-thumbnail">Thumbnail</th>
                                            <th class="pro-title">Product</th>
                                            <th class="pro-price">Price</th>
                                            <th class="pro-quantity">Quantity</th>
                                            <th class="pro-subtotal">Total</th>
                                            <th class="pro-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart as $key => $item)
                                        <tr>
                                            <td class="pro-thumbnail">
                                                <a href="#"><img class="img-fluid" src="{{ Storage::url($item['hinh_anh'])}}" alt="Product" /></a>
                                                <input type="hidden" name="cart[{{$key}}][hinh_anh]" value="{{ $item['hinh_anh']}}">
                                            </td>
                                            <td class="pro-title">
                                                <a href="{{ route('products.detail', $key ) }}">{{ $item['ten_san_pham']}}</a>
                                                <input type="hidden" name="cart[{{$key}}][ten_san_pham]" value="{{ $item['ten_san_pham']}}">
                                            </td>
                                            <td class="pro-price">
                                                <span>{{number_format($item['gia'],0 , '','.')}}đ</span>
                                                <input type="hidden" name="cart[{{$key}}][gia]" value="{{ $item['gia']}}">
                                            </td>
                                            <td class="pro-quantity">
                                                <div class="pro-qty">
                                                    <input type="text" class="quantityInput" data-price="{{$item['gia']}}" name="cart[{{$key}}][so_luong]" value="{{ $item['so_luong']}}">
                                                </div>
                                            </td>
                                            <td class="pro-subtotal">
                                                <span class="subtotal">{{number_format($item['gia'] * $item['so_luong'],0 , '','.')}}đ</span>
                                            </td>
                                            <td class="pro-remove">
                                                <a href="#"><i class="fa fa-trash-o"></i></a>
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
                </form>
                <div class="row">
                    <div class="col-lg-5 ml-auto">
                        <!-- Cart Calculation Area -->
                        <div class="cart-calculator-wrapper">
                            <div class="cart-calculate-items">
                                <h6>Cart Totals</h6>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>Sub Total</td>
                                            <td class="sub-total">{{number_format($subTotal,0 , '','.')}}đ</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping</td>
                                            <td class="shipping">{{number_format($shipping,0 , '','.')}}đ</td>
                                        </tr>
                                        <tr class="total">
                                            <td>Total</td>
                                            <td class="total-amount">{{number_format($total,0 , '','.')}}đ</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <a href="{{route('donhangs.create')}}" class="btn btn-sqr d-block">Proceed Checkout</a>
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
<script>
    $(document).ready(function() {
        $('.pro-qty').prepend('<span class="dec qtybtn">-</span>');
        $('.pro-qty').append('<span class="inc qtybtn">+</span>');

        function updateTotal() {
            var subTotal = 0;
            $('.quantityInput').each(function() {
                var input = $(this);
                var price = parseFloat(input.data('price'));
                var quantity = parseFloat(input.val());
                subTotal += price * quantity;
            });
            var shipping = parseFloat($('.shipping').text().replace(/\./g, '').replace('đ', ''));
            var total = subTotal + shipping;

            $('.sub-total').text(subTotal.toLocaleString('vi-VN') + ' đ');
            $('.total-amount').text(total.toLocaleString('vi-VN') + ' đ');
        }

        $('.qtybtn').on('click', function() {
            var $button = $(this);
            var $input = $button.parent().find('input');
            var oldValue = parseFloat($input.val());

            if ($button.hasClass('inc')) {
                var newVal = oldValue + 1;
            } else {
                var newVal = oldValue > 1 ? oldValue - 1 : 1;
            }
            $input.val(newVal);

            updateProductTotal($input);
            updateTotal();
        });

        $('.quantityInput').on('change', function() {
            var value = parseInt($(this).val(), 10);
            if (isNaN(value) || value < 1) {
                alert('Số lượng phải lớn hơn 1');
                $(this).val(1);
                value = 1;
            }

            updateProductTotal($(this));
            updateTotal();
        });

        function updateProductTotal($input) {
            var price = parseFloat($input.data('price'));
            var quantity = parseFloat($input.val());
            var $row = $input.closest('tr');
            var subtotalElement = $row.find('.subtotal');
            var newSubtotal = quantity * price;
            subtotalElement.text(newSubtotal.toLocaleString('vi-VN') + ' đ');
        }

        $('.pro-remove').on('click', function(event) {
            event.preventDefault();
            $(this).closest('tr').remove();
            updateTotal();
        });

        updateTotal();
    });
</script>
@endsection