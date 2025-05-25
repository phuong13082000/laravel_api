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
                                    <li><a href="#">{{$child->title}} </a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a href="#">{{$category->title}} </a></h4>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif
