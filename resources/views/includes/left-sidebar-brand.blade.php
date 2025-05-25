@if(isset($brands))
    <div class="brands_products">
        <h2>Brands</h2>
        <div class="brands-name">
            <ul class="nav nav-pills nav-stacked">
                @foreach($brands as $brand)
                    <li><a href="#"> <span class="pull-right">({{$brand['total']}})</span>{{$brand['title']}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
