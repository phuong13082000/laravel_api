@if($sliders)
    @php
        $i = 0;
    @endphp

    <section id="slider">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach($sliders as $slider)
                                <li data-target="#slider-carousel" data-slide-to="{{$i}}" class="{{$slider['active'] ? 'active' : ''}}"></li>
                                @php
                                    $i += 1
                                @endphp
                            @endforeach
                        </ol>

                        <div class="carousel-inner">
                            @foreach($sliders as $slider)
                                <div class="item {{$slider['active'] ? 'active' : ''}}">
                                    <div class="col-sm-6">
                                        <h1><span>E</span>-SHOPPER</h1>
                                        <h2>{{$slider['title']}}</h2>
                                        <p>{{$slider['description']}}</p>
                                        <button type="button" class="btn btn-default get">Get it now</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <img src="{{$slider['background']}}" class="girl img-responsive"
                                             alt=""/>
                                        <img src="{{$slider['background1']}}" class="pricing" alt=""/>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endif
