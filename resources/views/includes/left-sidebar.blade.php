<div class="left-sidebar">
    @if(isset($categories))
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordian">
            @foreach($categories as $category)
                @if($category->children)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordian" href="#{{$category->slug}}">
                                    <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                    {{$category->title}}
                                </a>
                            </h4>
                        </div>

                        <div id="{{$category->slug}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul>
                                    @foreach($category->children as $child)
                                        <li>
                                            <a href="{{route('shop', array_merge(request()->query(), ['category' => $child->slug])) }}">
                                                {{$child->title}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="{{route('shop', array_merge(request()->query(), ['category' => $category->slug])) }}">
                                    {{$category->title}}
                                </a>
                            </h4>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    @if(isset($brands))
        <div class="brands_products">
            <h2>Brands</h2>
            <div class="brands-name">
                <ul class="nav nav-pills nav-stacked">
                    @foreach($brands as $brand)
                        <li>
                            <a href="{{route('shop', array_merge(request()->query(), ['brand' => $brand->slug])) }}">
                                <span class="pull-right">({{$brand['products']->count() ?? 0}})</span>
                                {{$brand['title']}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="price-range">
        <h2>Price Range</h2>
        <div class="well text-center">
            <input
                type="text"
                class="span2"
                data-slider-min="0"
                data-slider-max="600"
                data-slider-step="5"
                data-slider-value="[{{ request('min', 100) }},{{ request('max', 500) }}]"
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
