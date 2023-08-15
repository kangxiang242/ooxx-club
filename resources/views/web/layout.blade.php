<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge">
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimal-ui">
    @if(isset($layout['seo']))
        <title>{{ isset($layout['seo'])?$layout['seo']->title:"" }}</title>
    @else
        <title>@yield('title')</title>
    @endif

    @hasSection('keywords')
    <meta name="keywords" content="@yield('keywords')"/>
    @else
    <meta name="keywords" content="{{ isset($layout['seo'])?$layout['seo']->key_word:"" }}"/>
    @endif

    @hasSection('description')
    <meta name="description" content="@yield('description')"/>
    @else
    <meta name="description" content="{{ isset($layout['seo'])?$layout['seo']->description:"" }}"/>
    @endif
    <meta name="apple-mobile-web-app-capable" content="no" />
    <meta name="apple-touch-fullscreen" content="no" />

    <link rel="canonical" href="{{ config('app.url') }}/{{ trim(request()->getBaseUrl(),'/') }}">
    <link rel="alternate" hreflang="zh-TW">
    <link rel="shortcut icon" href="{{ \App\Services\ConfigService::get('favicon')?asset('uploads/'.\App\Services\ConfigService::get('favicon')):'/favicon.ico' }}?v={{ app('cache.config')->get('asset_version') }}">

    @section('style')

        <link rel="stylesheet" type="text/css" href="{{ asset('static/css/style.css') }}?v={{ app('cache.config')->get('asset_version') }}"/>
        <link rel="stylesheet" type="text/less" href="{{ asset('static/less/global.less') }}?v={{ app('cache.config')->get('asset_version') }}"/>
        <link rel="stylesheet" href="{{ asset('static/font_3122894_ix34x1wtlao/iconfont.css') }}?v={{ app('cache.config')->get('asset_version') }}">
    @show

    <script src="{{ asset('static/js/jquery.min.js') }}?v={{ app('cache.config')->get('asset_version') }}"></script>
    <script src="{{ asset('static/js/jquery.waypoints.min.js') }}?v={{ app('cache.config')->get('asset_version') }}"></script>
    <script src="{{ asset('static/jquery_lazyload/jquery.lazyload.min.js') }}"></script>
    <script src="{{ asset('static/js/inquiry.js') }}"></script>
    <script src="{{ asset('static/js/area.js') }}"></script>

</head>
<body class="_show_loading">

<div class="global-loading" id="loading">
    <img width="50" src="{{ asset_upload(app('cache.config')->get('loading_image')) }}" alt="loading">
</div>

<div class="main-body">


@yield('content')


</div>
<div class="mask-shade"></div>


<div class="m-upper-apex">
    <p><i class="iconfont">&#xe66a;</i></p>
</div>

</body>

@section('script')
<script src="{{ asset('static/js/less.min.js') }}"></script>
<script src="{{ asset('static/js/jquery.cookie.js') }}"></script>
<script src="{{ asset('static/js/jquery.marquee.min.js') }}"></script>
<script src="{{ asset('static/js/jquery.masonry.min.js') }}"></script>
<script src="{{ asset('static/js/api.js') }}?v={{ app('cache.config')->get('asset_version') }}"></script>

{!! \App\Services\ConfigService::get('google_ga') !!}
<script>



    $('.upper-apex,.m-upper-apex').click(function(){
        $('body,html').scrollTop(0);
    })

    $('[data-point]').click(function(){
        var key = $(this).attr('id');

        var el = $('[data-scroll-key="'+key+'"]')

        var elOffset = el.offset().top;
        var elHeight = el.height();
        var windowHeight = $(window).height();
        var offset;

        if (elHeight < windowHeight) {
            offset = elOffset - ((windowHeight / 2) - (elHeight / 2));
        }
        else {
            offset = elOffset;
        }
        var speed = 0;
        $('html, body').animate({scrollTop:offset}, speed);
    })


</script>

<script>

    $(function(){
        $('#loading').animate({'visibility':'auto'},1600,function(){
            loading(0)
        });
    });


    function loading(is_show){
        if(is_show){
            $('body').addClass('_show_loading');
        }else{
            $('body').removeClass('_show_loading');
        }

    }

    $('.icons,.icons-top').click(function(){
        if($('.m-nav-sec').hasClass('m-show')){
            $('.m-nav-sec').removeClass('m-show')
            $('body').removeClass('show-mobile-menu')
            $('.drawer-btn').removeClass('show-open');
            $(this).find('.text-en').text('MENU');
        }else{
            $('.m-nav-sec').addClass('m-show')
            $('body').addClass('show-mobile-menu')
            $('.drawer-btn').addClass('show-open');
            $(this).find('.text-en').text('CLOSE');
        }
    });

    $('.mask-shade').click(function(){
        $('.m-nav-sec').removeClass('m-show')
        $('body').removeClass('show-mobile-menu')
    });


    $('[data-trigger].invisible').waypoint(function() {
        $($(this)[0].element).removeClass('invisible').addClass('visible')
    }, { offset: "100%" });
</script>



@show


</html>
