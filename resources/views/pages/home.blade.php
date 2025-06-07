@extends('app')

@section('frontend')
    @include('includes.header')
    @include('includes.slider')

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('includes.left-sidebar')
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">Features Items</h2>
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
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
