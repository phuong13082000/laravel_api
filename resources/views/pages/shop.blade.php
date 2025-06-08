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
                    <div class="features_items">
                        <h2 class="title text-center">Features Items</h2>
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
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
