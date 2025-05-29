@extends('app')

@section('frontend')
    @include('includes.header')
    @include('includes.slider')

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        @include('includes.left-sidebar-category')
                        @include('includes.left-sidebar-brand')

                        <div class="price-range">
                            <h2>Price Range</h2>
                            <div class="well text-center">
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
                                <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
                            </div>
                        </div>

                        <div class="shipping text-center">
                            <img src="{{asset('client/images/home/shipping.jpg')}}" alt=""/>
                        </div>
                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">Features Items</h2>
                        @foreach($products as $product)
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="{{Storage::disk('public')->url($product->image)}}" alt=""/>
                                            <h2>${{$product->price}}</h2>
                                            <p>{{$product->title}}</p>
                                            <a href="#" class="btn btn-default add-to-cart">
                                                <i class="fa fa-shopping-cart"></i>Add to cart
                                            </a>
                                        </div>

                                        <div class="product-overlay">
                                            <div class="overlay-content">
                                                <h2>${{$product->price}}</h2>
                                                <p>{{$product->title}}</p>
                                                <a href="#" class="btn btn-default add-to-cart">
                                                    <i class="fa fa-shopping-cart"></i>Add to cart
                                                </a>
                                            </div>
                                        </div>

                                        @if(isset($product->more_details))
                                            @foreach($product->more_details as $key => $value)
                                                @if($key == 'product-sale' && $value == 1)
                                                    <img src="{{ asset('client/images/home/sale.png') }}" class="new"
                                                         alt="Sale"/>
                                                @endif

                                                @if($key == 'product-new' && $value == 1)
                                                    <img src="{{ asset('client/images/home/new.png') }}" class="new"
                                                         alt="New"/>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="choose">
                                        <ul class="nav nav-pills nav-justified">
                                            <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                            <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="category-tab"><!--category-tab-->
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                @foreach($categoriesProducts as $index => $itemCategory)
                                    <li class="{{$index == 0 ? 'active' : ''}}">
                                        <a href="#{{$itemCategory->slug . $index}}" data-toggle="tab">{{$itemCategory->title}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="tab-content">
                            @foreach($categoriesProducts as $index => $itemCategory)
                                <div class="tab-pane fade {{ $index === 0 ? 'active in' : '' }}" id="{{ $itemCategory->slug . $index}}">
                                    @foreach($itemCategory->products as $itemProduct)
                                        <div class="col-sm-3">
                                            <div class="product-image-wrapper">
                                                <div class="single-products">
                                                    <div class="productinfo text-center">
                                                        <img src="{{ Storage::disk('public')->url($itemProduct->image) }}" alt=""/>
                                                        <h2>${{ $itemProduct->price }}</h2>
                                                        <p>{{ $itemProduct->title }}</p>
                                                        <a href="#" class="btn btn-default add-to-cart">
                                                            <i class="fa fa-shopping-cart"></i>Add to cart
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @include('includes.recommended-items')
                </div>
            </div>
        </div>
    </section>

    @include('includes.footer')
@endsection
