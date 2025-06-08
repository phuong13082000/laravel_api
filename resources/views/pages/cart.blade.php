@extends('app')

@php
    $subTotalCart = 0;
    $ecoTax = 2;
    $total = 0;
@endphp

@section('frontend')
    @include('includes.header')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>

            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($products))
                        @foreach($products as $item)
                            @php
                                $subTotalItem = $item->product->price * $item->quantity;
                                $subTotalCart += $subTotalItem;
                            @endphp
                            <tr>
                                <td class="cart_product">
                                    <a href=""><img src="{{ Storage::disk('public')->url($item->product->image)}}" alt=""></a>
                                </td>

                                <td class="cart_description">
                                    <h4><a href="">{{$item->product->title}}</a></h4>
                                    <p>Web ID: {{$item->id}}</p>
                                </td>

                                <td class="cart_price">
                                    <p>${{$item->product->price}}</p>
                                </td>

                                <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                        <a class="cart_quantity_down" href=""> - </a>
                                        <input
                                            class="cart_quantity_input"
                                            type="text"
                                            name="quantity"
                                            value="{{$item->quantity}}"
                                            autocomplete="off"
                                            size="2"
                                        >
                                        <a class="cart_quantity_up" href=""> + </a>
                                    </div>
                                </td>

                                <td class="cart_total">
                                    <p class="cart_total_price">${{$subTotalItem}}</p>
                                </td>

                                <td class="cart_delete">
                                    <form method="POST" action="{{route('cart.remove')}}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <button type="submit" class="cart_quantity_delete">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section> <!--/#cart_items-->

    <section id="do_action">
        <div class="container">
            <div class="heading">
                <h3>What would you like to do next?</h3>
                <p>
                    Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.
                </p>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="chose_area">
                        <ul class="user_option">
                            <li>
                                <input type="checkbox">
                                <label>Use Coupon Code</label>
                            </li>

                            <li>
                                <input type="checkbox">
                                <label>Use Gift Voucher</label>
                            </li>

                            <li>
                                <input type="checkbox">
                                <label>Estimate Shipping & Taxes</label>
                            </li>
                        </ul>

                        <ul class="user_info">
                            <li class="single_field">
                                <label>Country:</label>
                                <select>
                                    <option>United States</option>
                                    <option>Bangladesh</option>
                                    <option>UK</option>
                                    <option>India</option>
                                    <option>Pakistan</option>
                                    <option>Ukraine</option>
                                    <option>Canada</option>
                                    <option>Dubai</option>
                                </select>
                            </li>

                            <li class="single_field">
                                <label>Region / State:</label>
                                <select>
                                    <option>Select</option>
                                    <option>Dhaka</option>
                                    <option>London</option>
                                    <option>Deli</option>
                                    <option>Lahore</option>
                                    <option>Alaska</option>
                                    <option>Canada</option>
                                    <option>Dubai</option>
                                </select>
                            </li>

                            <li class="single_field zip-field">
                                <label>Zip Code:</label>
                                <input type="text">
                            </li>
                        </ul>

                        <a class="btn btn-default update" href="">Get Quotes</a>
                        <a class="btn btn-default check_out" href="">Continue</a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            <li>Cart Sub Total <span>${{$subTotalCart}}</span></li>
                            <li>Eco Tax <span>${{$ecoTax}}</span></li>
                            <li>Shipping Cost <span>Free</span></li>
                            <li>Total <span>${{$subTotalCart + $ecoTax}}</span></li>
                        </ul>
                        <a class="btn btn-default update" href="">Update</a>
                        <a class="btn btn-default check_out" href="">Check Out</a>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/#do_action-->

    @include('includes.footer')
@endsection
