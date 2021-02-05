@extends('frontend.master')
@section('cart')
active    
@endsection
@section('content')
    <!-- .breadcumb-area start -->
    <div class="breadcumb-area bg-img-4 ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcumb-wrap text-center">
                        <h2>Shopping Cart</h2>
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li><span>Shopping Cart</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .breadcumb-area end -->
    <!-- cart-area start -->
    <div class="cart-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('CartUpdate') }}" method="post">
                        @csrf
                        <table class="table-responsive cart-wrap">
                            <thead>
                                <tr>
                                    <th class="images">Image</th>
                                    <th class="product">Product</th>
                                    <th class="ptice">Price</th>
                                    <th class="ptice">Color</th>
                                    <th class="ptice">Size</th>
                                    <th class="quantity">Quantity</th>
                                    <th class="total">Total</th>
                                    <th class="remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $grand_total = 0;
                                @endphp
                            
                                @foreach ($carts as $cart)
                                <tr>
                                    <td class="images"><img src="{{ asset('images/'. $cart->product->thumbnail) }}" alt="{{ $cart->product->title }}"></td>
                                    <td class="product"><a target="_blank" href="{{ route('SingleProduct', $cart->product->slug) }}">{{ $cart->product->title }}</a></td>
                                    <td class="price unit_price{{ $cart->id }}" data-unit{{ $cart->id }}="{{ $cart->product->price }}">${{ $cart->product->price }}</td>
                                    <td class="ptice"></td>
                                    <td class="ptice"></td>
                                    <input type="hidden" name="cart_id[]", value="{{ $cart->id }}">
                                    <td class="quantity cart-plus-minus">
                                        <input name="quantity[]" class="qty_quantity{{ $cart->id }}" type="text" value="{{ $cart->quantity }}" />
                                        <div class="dec qtybutton qtyminus{{ $cart->id }}">-</div>
                                        <div class="inc qtybutton qtyplus{{ $cart->id }}">+</div>
                                    </td>
                                    @php
                                        $grand_total += ($cart->quantity * $cart->product->price)
                                    @endphp
                                    
                                    <td class="total tuira total_unit{{ $cart->id }}">{{ $cart->quantity * $cart->product->price }}</td>
                                    <td class="remove"><a href="{{ route('SingleCartDelete', $cart->id) }}"><i class="fa fa-times"></i></a></td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                        <div class="row mt-60">
                            <div class="col-xl-4 col-lg-5 col-md-6 ">
                                <div class="cartcupon-wrap">
                                    <ul class="d-flex">
                                        <li>
                                            <button>Update Cart</button>
                                        </li>
                                        <li><a href="{{ route('shop') }}">Continue Shopping</a></li>
                                    </ul>
                                </form>
                                <form action="{{ route('Cart') }}" method="get">
                                    <h3>Coupon</h3>
                                    <p>Enter Your Coupon Code if You Have One</p>
                                    <div class="cupon-wrap">
                                        <input type="text" value="{{ $code ?? '' }}" name="coupon_code" placeholder="Coupon Code">
                                        <button>Apply Coupon</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                            <div class="col-xl-3 offset-xl-5 col-lg-4 offset-lg-3 col-md-6">
                                <div class="cart-total text-right">
                                    <h3>Cart Totals</h3>
                                    <ul>
                                        {{-- @php
                                            $grand_total-
                                        @endphp --}}
                                        <li><span class="pull-left">Sub Total: </span>${{ $grand_total }}</li>
                                        <li><span class="pull-left">Coupon Discount </span>${{ $coupon_discount }}</li>
                                        <li><span class="pull-left grand_total">Grand Total: </span> $<span class="hasan">{{ $grand_total - $coupon_discount}}</span></li>
                                    </ul>
                                    <a href="{{ route('checkout') }}">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- cart-area end -->
    <!-- start social-newsletter-section -->
    <section class="social-newsletter-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="newsletter text-center">
                        <h3>Subscribe  Newsletter</h3>
                        <div class="newsletter-form">
                            <form>
                                <input type="text" class="form-control" placeholder="Enter Your Email Address...">
                                <button type="submit"><i class="fa fa-send"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end container -->
    </section>
    <!-- end social-newsletter-section -->
@endsection

@section('footer_js')
    <script>
        $(document).ready(function(){
            @foreach($carts as $car)
            
            $('.qtyminus{{ $car->id }}').click(function(){
                let qty_quantity = $('.qty_quantity{{ $car->id }}').val();
                let unit_price = $('.unit_price{{ $car->id }}').attr('data-unit{{ $car->id }}');
                $('.total_unit{{ $car->id }}').html(qty_quantity * unit_price);
                let minus_sub_total = (qty_quantity * unit_price);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                  url: "{{ url('/quantity/update') }}",
                  method: 'post',
                  data: {
                     id: '{{ $car->id }}',
                     qty_quantity: qty_quantity,
                    
                  },
                  success: function(result){
                     console.log(result);
                  }
                });
               

                let c = document.querySelectorAll(".tuira")
                let arr = Array.from(c)
                let sum=0;
                arr.map(item=>{
                    
                    sum += parseInt(item.innerHTML)
                    $('.hasan').html(sum);
                    console.log(typeof parseInt(item.innerHTML))
                })
                
                
          
            
            })
            $('.qtyplus{{ $car->id }}').click(function(){
                let qty_quantity = $('.qty_quantity{{ $car->id }}').val();
                let unit_price = $('.unit_price{{ $car->id }}').attr('data-unit{{ $car->id }}');
                $('.total_unit{{ $car->id }}').html(qty_quantity * unit_price);
                let plus_sub_total = (qty_quantity * unit_price);
               
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                  url: "{{ url('/quantity/update') }}",
                  method: 'post',
                  data: {
                     id: '{{ $car->id }}',
                     qty_quantity: qty_quantity,
                    
                  },
                  success: function(result){
                     console.log(result);
                  }
                });
                
                let c = document.querySelectorAll(".tuira")
                let arr= Array.from(c)
                let sum=0;
                arr.map(item=>{
                    sum += parseInt(item.innerHTML)
                    $('.hasan').html(sum);
                    console.log(sum)
                })
            }) 
            @endforeach
        })
    </script>
@endsection