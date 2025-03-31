<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge">
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover minimal-ui">
    @if(isset($layout['seo']))
        <title>{{ isset($layout['seo'])?$layout['seo']->title:"" }}</title>
    @else
        <title>@yield('title')</title>
    @endif
    <meta property="og:site_name" content="全台最大外送茶定點茶">
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
    <link rel="canonical" href="{{ request()->url() }}">
    <link rel="alternate" hreflang="zh-TW">
    <link rel="shortcut icon" href="{{ asset_upload(app('cache.config')->get('favicon')) }}">

    @section('style')
        <link rel="stylesheet" type="text/css" href="{{ asset('static/css/style.css') }}?v={{ app('cache.config')->get('asset_version') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('static/less/global.css') }}?v={{ app('cache.config')->get('asset_version') }}"/>
        <link rel="stylesheet" href="{{ asset('static/font_3122894_ix34x1wtlao/iconfont.css') }}?v={{ app('cache.config')->get('asset_version') }}">
    @show

    <script src="{{ asset('static/js/jquery.min.js') }}"></script>
    <script src="{{ asset('static/js/inquiry.js') }}"></script>
    <script src="{{ asset('static/js/area.js') }}?v={{ app('cache.config')->get('asset_version') }}"></script>



</head>
<body class="_show_loading">

<div class="global-loading" id="loading">
    <img src="/static/img/logo3.webp" class="loadinglogo" alt="">
    <p class="slogan">給你全台最好的 外送茶&定點茶</p>
    <div class="circle">{!! app('cache.config')->get('loading_code') !!}</div>

</div>

<div class="main-body">


@yield('content')


</div>
<div class="mask-shade"></div>

</body>

@section('script')
{{--<script src="{{ asset('static/js/less.min.js') }}"></script>--}}
<script src="{{ asset('static/js/jquery.cookie.js') }}"></script>
<script src="{{ asset('static/js/jquery.marquee.min.js') }}"></script>
{{--<script src="{{ asset('static/js/jquery.masonry.min.js') }}"></script>--}}

{{--<script src="{{ asset('static/js/masonry.pkgd.min.js') }}"></script>--}}
<script src="{{ asset('static/js/imagesloaded.pkgd.min.js') }}"></script>

<script src="{{ asset('static/js/api.js') }}?v={{ app('cache.config')->get('asset_version') }}"></script>
{!! \App\Services\ConfigService::get('google_ga') !!}
<script>
    var isChromeOniOS = /CriOS/.test(navigator.userAgent);
    if (isChromeOniOS) {
        $('a').removeAttr('target');
    }
</script>

<script>

    window.addEventListener('load', function () {
        $('#loading').animate({'visibility':'auto'},1400,function(){
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
</script>



@show


</html>
