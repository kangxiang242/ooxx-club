@extends('web.layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/less" href="{{ asset('static/less/about.less') }}?v={{ app('cache.config')->get('asset_version') }}"/>

@stop

@section('script')
    @parent

    <script>
        $(function(){
            $('.faqs ul li').on('click', function(){
                $(this).siblings().find('dt').removeClass('on').next().slideUp();
                $(this).find('dt').toggleClass('on').next().slideToggle();
            });



            var el = $('#{{ request()->path() }}')
            var elOffset = el.offset().top;
            var elHeight = el.height();
            var windowHeight = $(window).height();
            var offset;
            if (elHeight < windowHeight) {
                offset = elOffset - (window.matchMedia("(max-width: 1024px)").matches?80:140);
            }else {
                offset = elOffset;
            }
            var speed = 0;
            $('html, body').animate({scrollTop:offset}, speed);

        });
    </script>

@stop

@section('content')


    <div class="container">
        <div class="main">
            <div class="about">
                <div class="pagebox" id="about-us">
                    <h1 class="page-title" data-page-title="關於OOXX">關於OOXX</h1>
                </div>
                <div class="card">
                    <div class="aboutus">
                        {!! app('cache.config')->get('about_content') !!}
                    </div>
                </div>
            </div>
            <div class="faq">
                <div class="pagebox" id="about-faq">
                    <h2 class="page-title" data-page-title="FAQS">FAQS</h2>
                </div>
                <div class="faqs">
                    <ul class="invisible" data-trigger="">
                        @foreach($faqs as $key=>$item)
                            <li style="transition-delay: {{ 2*($key+1)*100 }}ms;">
                                <dl>
                                    <dt class="">{{ $item->title }} <i class="iconfont">&#xeca2;</i></dt>
                                    <dd style="display: none;">{!! $item->content !!}</dd>
                                </dl>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>




@endsection
