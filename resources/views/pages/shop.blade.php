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
                    @include('includes.left-sidebar')
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->
                        <h2 class="title text-center">Features Items</h2>
                        @foreach($products as $product)
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="{{ Storage::disk('public')->url($product->image)}}" alt=""/>
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
                                            <li><a href=""><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                            <li><a href=""><i class="fa fa-plus-square"></i>Add to compare</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <ul class="pagination">
                            @if ($products->onFirstPage())
                                <li class="disabled"><span>&laquo;</span></li>
                            @else
                                <li><a href="{{ $products->previousPageUrl() }}">&laquo;</a></li>
                            @endif

                            @for($i = 1; $i <= $products->lastPage(); $i++)
                                @if ($i == $products->currentPage())
                                    <li class="active"><span>{{ $i }}</span></li>
                                @else
                                    <li><a href="{{ $products->url($i) }}">{{ $i }}</a></li>
                                @endif
                            @endfor

                            @if ($products->hasMorePages())
                                <li><a href="{{ $products->nextPageUrl() }}">&raquo;</a></li>
                            @else
                                <li class="disabled"><span>&raquo;</span></li>
                            @endif
                        </ul>
                    </div><!--features_items-->
                </div>
            </div>
        </div>
    </section>

    @include('includes.footer')
@endsection
