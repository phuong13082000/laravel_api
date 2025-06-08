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

            <a href="{{route('detail', ['slug' => $product->slug])}}">
                <div class="product-overlay">
                    <div class="overlay-content">
                        <h2>${{$product->price}}</h2>
                        <p>{{$product->title}}</p>
                        <form method="POST" action="{{route('cart.add')}}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <button type="submit" class="btn btn-default add-to-cart">
                                <i class="fa fa-shopping-cart"></i>Add to cart
                            </button>
                        </form>
                    </div>
                </div>
            </a>

            @if(isset($product->more_details))
                @foreach($product->more_details as $key => $value)
                    @if($key == 'product-sale' && $value == 1)
                        <img src="{{ asset('client/images/home/sale.png') }}" class="new" alt="Sale"/>
                    @endif

                    @if($key == 'product-new' && $value == 1)
                        <img src="{{ asset('client/images/home/new.png') }}" class="new" alt="New"/>
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
