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
    <script src="{{ datainquireJS() }}"></script>
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
    <header class="main-header">
        <div class="logo-sec">
            <a class="logo" href="{{ url('/') }}">
                <img src="/static/img/mclogo2.png" alt="24h歡樂送LOGO">
            </a>
            <p class="slogan2">給你全台最好的外送茶&定點茶</p>

        </div>
        <a href="{{ liaison_get('line_url') }}" class="contect">
            <svg t="1691137092658" class="lineicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="8095" width="200" height="200"><path d="M826.24 420.821333a26.922667 26.922667 0 0 1 0 53.802667H751.36v48h74.88a26.88 26.88 0 1 1 0 53.717333h-101.802667a26.922667 26.922667 0 0 1-26.752-26.837333V345.941333c0-14.72 12.032-26.88 26.88-26.88h101.802667a26.88 26.88 0 0 1-0.128 53.76H751.36v48h74.88z m-164.48 128.682667a26.88 26.88 0 0 1-26.922667 26.752 26.368 26.368 0 0 1-21.76-10.666667l-104.234666-141.525333v125.44a26.88 26.88 0 0 1-53.632 0V345.941333a26.752 26.752 0 0 1 26.624-26.794666c8.32 0 16 4.437333 21.12 10.837333l105.045333 142.08V345.941333c0-14.72 12.032-26.88 26.88-26.88 14.72 0 26.88 12.16 26.88 26.88v203.562667z m-244.949333 0a26.965333 26.965333 0 0 1-26.922667 26.837333 26.922667 26.922667 0 0 1-26.752-26.837333V345.941333c0-14.72 12.032-26.88 26.88-26.88 14.762667 0 26.794667 12.16 26.794667 26.88v203.562667z m-105.216 26.837333H209.792a27.050667 27.050667 0 0 1-26.88-26.837333V345.941333c0-14.72 12.16-26.88 26.88-26.88 14.848 0 26.88 12.16 26.88 26.88v176.682667h74.922667a26.88 26.88 0 0 1 0 53.717333M1024 440.064C1024 210.901333 794.24 24.405333 512 24.405333S0 210.901333 0 440.064c0 205.269333 182.186667 377.258667 428.16 409.941333 16.682667 3.498667 39.381333 11.008 45.141333 25.173334 5.12 12.842667 3.370667 32.682667 1.621334 46.08l-6.997334 43.52c-1.92 12.842667-10.24 50.602667 44.757334 27.52 55.082667-22.997333 295.082667-173.994667 402.602666-297.6C988.842667 614.101333 1024 531.541333 1024 440.064" p-id="8096"></path></svg>
            <p class="line-text-box">
                <span class="line-text">喝茶約炮點擊加賴</span>
                <span class="line-text">24小時客服在線</span>
            </p>
            <span class="line-id">{{ liaison_get('line_id') }}</span>
        </a>
        <nav class="base">
            <ul class="base-box">
                <li class="base-item">
                    <a href="{{ url('/') }}" class="base-link">首頁</a>
                </li>
                <li class="base-item">
                    <a href="javascript:;" class="base-link">外送茶</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('outgoing') }}">全部外送茶</a></li>
                        @foreach($areas as $area)
                            <li><a href="{{ url($area->name.'外送茶') }}">{{ $area->name }}外送茶</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="base-item">
                    <a href="javascript:;" class="base-link">定點茶</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('fixation') }}">全部定點茶</a></li>
                        @foreach($areas as $area)
                            <li><a href="{{ url($area->name.'定點茶') }}">{{ $area->name }}定點茶</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="base-item">
                    <a href="{{ url('blog') }}" class="base-link">最新消息</a>
                </li>
            </ul>
        </nav>
    </header>

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
