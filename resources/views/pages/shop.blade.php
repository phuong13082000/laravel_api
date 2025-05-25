@extends('app')

@section('frontend')
    @include('includes.header')

    <section id="advertisement">
        <div class="container">
            <img src="{{asset('client/images/shop/advertisement.jpg')}}" alt=""/>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        @include('includes.left-sidebar-category')
                        @include('includes.left-sidebar-brand')

                        <div class="price-range"><!--price-range-->
                            <h2>Price Range</h2>
                            <div class="well">
                                <input
                                    type="text"
                                    class="span2"
                                    value=""
                                    data-slider-min="0"
                                    data-slider-max="600"
                                    data-slider-step="5"
                                    data-slider-value="[250,450]"
                                    id="sl2"
                                >
                                <br/>
                                <b>$ 0</b> <b class="pull-right">$ 600</b>
                            </div>
                        </div><!--/price-range-->

                        <div class="shipping text-center"><!--shipping-->
                            <img src="{{asset('client/images/home/shipping.jpg')}}" alt=""/>
                        </div><!--/shipping-->
                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->
                        <h2 class="title text-center">Features Items</h2>
                        @foreach($products as $product)
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="{{$product['image']}}" alt=""/>
                                            <h2>${{$product['price']}}</h2>
                                            <p>{{$product['title']}}</p>
                                            <a href="#" class="btn btn-default add-to-cart">
                                                <i class="fa fa-shopping-cart"></i>Add to cart
                                            </a>
                                        </div>

                                        <div class="product-overlay">
                                            <div class="overlay-content">
                                                <h2>${{$product['price']}}</h2>
                                                <p>{{$product['title']}}</p>
                                                <a href="#" class="btn btn-default add-to-cart">
                                                    <i class="fa fa-shopping-cart"></i>Add to cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="choose">
                                        <ul class="nav nav-pills nav-justified">
                                            <li><a href=""><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                            <li><a href=""><i class="fa fa-plus-square"></i>Add to compare</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <ul class="pagination">
                            <li class="active"><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">&raquo;</a></li>
                        </ul>
                    </div><!--features_items-->
                </div>
            </div>
        </div>
    </section>

    @include('includes.footer')
@endsection
