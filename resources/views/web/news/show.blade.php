@extends('web.layout')
@if($news->seo_title)
    @section('title', $news->seo_title)
@else
    @section('title', $news->title)
@endif

@if($news->seo_keyword)
    @section('keywords', $news->seo_keyword)
@endif

@if($news->seo_description)
    @section('description', $news->seo_description)
@endif
@section('style')
    @parent
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <link rel="stylesheet" type="text/less" href="{{ asset('static/less/shownews.less') }}?v={{ app('cache.config')->get('asset_version') }}"/>
    <style>
        .banner-section .banner-content{
            margin-bottom: 20px;
        }
        .breadcrumb{
            display: flex;
            justify-content:flex-start;
            position: relative;
            margin: 0 auto;
            width: 85.35871%;
            max-width: 1400px;
        }
        .rep{
            display: none;
        }
        @media screen and (max-width: 1024px) {
            .breadcrumb{

                margin: 0;

            }
            .rep{
                margin-bottom: 0;
                margin-top: 10px;
            }
        }
    </style>
@stop

@section('script')
    @parent
    <script src="{{ asset('static/js/jquery-ui-1.9.1.custom.min.js') }}"></script>
    <script src="{{ asset('static/tocify/javascripts/jquery.tocify.js') }}"></script>
    <script>
        document.domain = "{{ getMainDomain() }}";
        function setIframeHeight(iframe) {
            if (iframe) {
                var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
                if (iframeWin.document.body) {
                    iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
                }}
        };
        window.onload = function () {
            setIframeHeight(document.getElementById('external-frame'));
        };
    </script>

    <script>
        $(function(){
            $('#toc').tocify({
                context:"#content",
                selectors:"h2",
                showAndHide:false,
                showAndHideOnScroll:false,
                scrollTo:140,
                smoothScroll:false,
                extendPage:false,
            });
        })

    </script>
    <script>
        $(function () {
            finalArticleTop();
            $(document).scroll(function(){
                finalArticleTop();
            })
            const btns = document.querySelectorAll('[data-btn-scroll]');
            btns.forEach((btn, index) => {
                const nextbtn = btns[index + 1];
                window.addEventListener('scroll', () => {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                    if (index >= 0) {
                        const btnOffsetTop = btn.offsetTop;
                        if(nextbtn){
                            const nextbtnOffsetTop = nextbtn.offsetTop;
                            const heightDiff = nextbtnOffsetTop - btnOffsetTop;

                            if (heightDiff <= window.innerHeight) {
                                btn.classList.add('position');
                            } else {
                                btn.classList.remove('position');
                            }
                        }

                    }
                });
            });
        })
        function finalArticleTop(){
            if (window.innerWidth > 768) {
                return false;
            }

            var top =  $(document).scrollTop();
            var _this = null;
            $('div[data-btn-scroll]').each(function(){
                var btn_peg = $(this).offset().top
                if(top>=btn_peg-80){
                    _this = $(this);
                }
            });
            if(_this){
                _this.addClass('btnbox-top').removeClass('btnbox-article');
                _this.siblings('div[data-btn-scroll]').removeClass('btnbox-top').addClass('btnbox-article');
                $('header .icons').addClass('icons-top');
            }else{
                $('div[data-btn-scroll]').removeClass('btnbox-top').addClass('btnbox-article');
                $('header .icons').removeClass('icons-top');
            }



        }
    </script>
@stop




@section('content')
    <ul class="m-nav">
        <li>
            <a href="" class="base">
                <svg t="1689323762663" class="baseicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="8030" width="200" height="200"><path d="M0 0h1024v1024H0z" p-id="8031"></path></svg>
                <p>首頁選茶</p>
            </a>
        </li>
        <li>
            <a href="" class="base">
                <svg t="1689323762663" class="baseicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="8030" width="200" height="200"><path d="M0 0h1024v1024H0z" p-id="8031"></path></svg>
                <p>新手必看</p>
            </a>
        </li>
        <li>
            <a href="{{ url('blog') }}" class="base">
                <svg t="1689323762663" class="baseicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="8030" width="200" height="200"><path d="M0 0h1024v1024H0z" p-id="8031"></path></svg>
                <p>最新消息</p>
            </a>
        </li>
        <li class="contect">加line</li>
    </ul>
    <div class="container">
        
        <div class="news-main">
            <div class="news-box">
                <div class="left">
                    <div class="news-cover">
                        <a href="" class="back">
                            <svg t="1689328151908" class="backicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="8030" width="200" height="200"><path d="M300.303599 490.89725601c-0.486519 0.97303701-1.337926 1.824445-1.702815 2.79748199-8.514075 17.757928-5.716593 39.651265 9.365483 53.881934L651.69165 872.692719c18.730966 17.757928 48.28697 16.90652101 66.044898-1.824445 17.757928-18.730966 16.90652101-48.28697-1.824445-66.044898l-308.452785-291.789524L714.695807 216.987291c18.609336-17.87955801 19.095855-47.435562 1.216296-66.044898-9.122224-9.487112-21.406818-14.352298-33.569783-14.35229801-11.676446 0-23.352892 4.378667-32.353486 13.13600201l-340.563012 328.278418c-0.608148 0.608148-0.851408 1.58118501-1.581185 2.189334-0.486519 0.486519-0.973037 0.851408-1.581185 1.337926C303.46597 484.329255 302.128044 487.734885 300.303599 490.89725601L300.303599 490.89725601zM300.303599 490.89725601" fill="#fff" p-id="8031"></path></svg>
                        </a>
                        <img src="{{ asset_upload($news->img) }}" alt="{{ $news->title }}" style="width: 100%;">
                        <h1 class="news-title">{{ $news->title }}</h1>
                        <div class="labelbox">
                            <p class="time">2023-01-01</p>
                            <div class="views">
                                <p class="editor">By.XXXX</p>
                                <svg t="1689216927090" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2591" width="200" height="200"><path d="M132.693333 453.76C235.946667 278.997333 377.6 199.253333 512 199.253333c134.4 0 276.053333 79.786667 379.306667 254.506667 21.162667 35.882667 21.162667 80.597333 0 116.48-103.253333 174.762667-244.906667 254.506667-379.306667 254.506667-134.4 0-276.053333-79.786667-379.306667-254.506667a114.645333 114.645333 0 0 1 0-116.48z m850.432-54.272C865.28 199.978667 692.309333 92.586667 512 92.586667S158.72 199.978667 40.832 399.488a221.312 221.312 0 0 0 0 225.024C158.72 824.021333 331.690667 931.413333 512 931.413333c180.309333 0 353.28-107.392 471.125333-306.901333a221.312 221.312 0 0 0 0-225.024zM437.333333 512a74.666667 74.666667 0 1 1 149.333334 0 74.666667 74.666667 0 0 1-149.333334 0zM512 330.666667a181.333333 181.333333 0 1 0 0 362.666666 181.333333 181.333333 0 0 0 0-362.666666z" p-id="2592"></path></svg>
                                <p class="num">9341</p>
                            </div>
                            
                        </div>
                        <!-- <div class="tocnav">
                            <p class="tocnavtitle">攻略速覽</p>
                            <div id="toc"></div>
                        </div> -->
                    </div>
                    <div class="content">
                        <article id="content">
                            {!! $news->content !!}
                        </article>
                    </div>

                </div>
                <div class="right-sticky">
                    <div class="right">
                        <div class="hot-box">
                            <h3 class="title">最新消息</h3>
                            <div class="list">
                                <ul>
                                    @foreach($recommend as $item)
                                        <li class="hot-news">
                                            <a href="{{ url('blog/'.$item->id) }}">
                                                <img src="{{ asset_upload($news->img) }}" alt="{{ $news->title }}">
                                                <p class="hot-news-title">{{ $item->title }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="btnbox">
                            <a href="{{ app('cache.config')->get('line_url') }}" target="_blank" class="button ripple" data-inquire="" data-inquire-type="line" data-inquire-position="top">
                                <div class="btn-bg uwu"></div>
                                <div class="btn-bg"></div>
                                <div class="text shake1">
                                    <i class="iconfont">&#xebf5;</i>
                                    <p>
                                        <span class="btn-text">Line預約</span>
                                        <span class="btn-num">{{ app('cache.config')->get('line_id') }}</span>
                                    </p>
                                </div>

                            </a>
                            <a href="tel::+886{{ app('cache.config')->get('service_phone') }}" class="button ripple"  data-inquire="" data-inquire-type="phone" data-inquire-position="top">
                                <div class="btn-bg uwu"></div>
                                <div class="btn-bg"></div>
                                <div class="text shake2">
                                    <i class="iconfont">&#xe6bc;</i>
                                    <p>
                                        <span class="btn-text">電話預約</span>
                                        <span class="btn-num">{{ app('cache.config')->get('service_phone') }}</span>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>




@endsection
