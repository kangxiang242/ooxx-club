@extends('web.layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('static/swiper4/swiper.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('static/less/index.css') }}?v={{ app('cache.config')->get('asset_version') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('static/less/fliter.css') }}?v={{ app('cache.config')->get('asset_version') }}"/>

@stop
@section('script')
    @parent
    <script src="{{ asset('static/swiper4/swiper.min.js') }}"></script>
    <script>
        if(window.matchMedia('(max-width: 768px)').matches){

            $(function () {
                wrapTop();
                $(document).scroll(function(){
                    wrapTop();
                })
            })

            function wrapTop(){
                if($(document).scrollTop() >= 40 ){
                    $('#wrapper').addClass('wrapper-top');
                    $('#phone').addClass('phone-top');
                    $('#modebox').addClass('modebox-top');
                }else if($(document).scrollTop() < 20 ){
                    $('#wrapper').removeClass('wrapper-top');
                    $('#phone').removeClass('phone-top');
                    $('#modebox').removeClass('modebox-top');
                }
            }
        }
    </script>

    <script>
        if(window.matchMedia('(max-width: 768px)').matches){
            $(function () {
                finalTop();
                $(document).scroll(function(){
                    finalTop();
                })
            })
            function finalTop(){
                var filter = $('#filter').offset().top
                if(filter){
                    if($(document).scrollTop()>=filter-54){
                        $('#filter').addClass('filter-top');
                        $('#partone').addClass('partone-top');
                        /* $('#wrapper').css('border-bottom', 'transparent'); */

                    }else{
                        $('#filter').removeClass('filter-top');
                        $('#partone').removeClass('partone-top');
                        /* $('#wrapper').css('border-bottom', '1px solid #e5e5e5'); */

                    }
                }

            }
        }
    </script>

    <script>
        if(window.matchMedia('(max-width: 768px)').matches){
            $(function() {

                $('#search').click(function() {


                    $('.parttwo-show').toggleClass('parttwo-hide');
                    $('body').toggleClass('bodyoverflow');
                    $('.choose-sec').toggleClass('choose-show');

                    if ($('.parttwo-show').hasClass('parttwo-hide')) {
                        $('.logo').html('<img src="static/img/mclogo2.png" alt="" style="width:100%;">');
                    } else {
                        $('.logo').html('<span class="searchtitle">進階搜尋</span>');
                    }

                    if ($('.filter').hasClass('filter-top')) {
                    } else {
                        $('html, body').animate({ scrollTop: '+=410px' }, 40);
                    }

                    var win_height = window.innerHeight - 72 - 60;
                    $('.parttwo-show').css('--height',win_height+'px');

                });
            });
        }
    </script>

    <script>
        window.addEventListener('load', function () {
            getGoods2(false);

        });

        $(function () {
            new Swiper('#banner-swiper', {
                autoplay: { // 自动轮播效果
                    delay:7000,
                    disableOnInteraction: false,
                },
                loop:true,
                slidesPerView: "auto",
                centeredSlides: true,
                spaceBetween : 15,
                resizeObserver:true,

            })
        })
    </script>

    <script>
        var is_lock = false
        var filter_count = localStorage.getItem(filter_count_key);
        var EquClickCallback = function (number) {
            if(!is_lock){
                var qut = Math.round(3000 * (1-number/30));
                if(qut>200){
                    $('.filter .conform .result').text("查看挑選 "+qut+"+ 結果");
                }else{
                    $('.filter .conform .result').text("查看挑選 200+ 結果");
                }

                $('.filter .conform .result').hide();
                $('.filter .conform .loading').show();
                is_lock = true
                setTimeout(function () {
                    $('.filter .conform .result').show();
                    $('.filter .conform .loading').hide();
                    is_lock = false
                },500)
            }
        }
        EquClickCallback(filter_count);
    </script>

@stop


@section('content')


    <section class="swiper-container banner-section" id="banner-swiper">
        @php
            $banners = [];
            try {
                $banners = json_decode(app('cache.config')->get('home_banners'),true);
            }catch (\Exception $exception){}
        @endphp

        <div class="swiper-wrapper homebanner">
            @foreach($banners as $banner)
            <div class="swiper-slide banner">
                @if(array_get($banner,'href'))
                    <a href="{{ array_get($banner,'href') }}"><img src="{{ asset_upload(array_get($banner,'image')) }}" alt="{{ array_get($banner,'alt') }}"></a>
                @else
                    <img src="{{ asset_upload(array_get($banner,'image')) }}" alt="{{ array_get($banner,'alt') }}">
                @endif
                @if(config('app.disable_contact'))
                <div class="contact">
                    @if(liaison_get('line_qrcode'))<div class="qrcode-box"><img src="{{ '/uploads/'.liaison_get('line_qrcode') }}" alt="line"></div>@endif
                    @if(liaison_get('line_id'))<p class="line">LINE:{{ liaison_get('line_id') }}</p>@endif
                </div>
                @endif
            </div>
            @endforeach
        </div>

    </section>

    <section class="quicklink-section" >
        <ul class="quick">
            @foreach($quick as $item)
                <li class="quicklink">
                    <a href="{{ url('product') }}?quick={{ $item->id }}">
                        <img src="{{ asset_upload($item->img) }}" alt="{{ $item->text }}">
                        <p class="quicktitle">{{ $item->text }}</p>
                    </a>
                </li>
            @endforeach
        </ul>
    </section>

    <section class="pc">
        <h1 class="goodtitle">今日{{ app('cache.config')->get('site_keyword') }}推薦</h1>

        <div class="cityboxindex">
            <div class="city">
                <div class="arrowicon">
                    <input type="checkbox" id="city" name="city">
                    <label class="area" for="city">

                        <select name="city" id="fil-city"></select>
                        <div class="arrow"></div>
                    </label>
                </div>
            </div>
            {{--<div class="city county-box" style="display: none">
                <div class="arrowicon">
                    <input type="checkbox" id="area" name="area">
                    <label class="area" for="area">

                        <select name="county" id="fil-county"></select>
                        <div class="arrow"></div>
                    </label>
                </div>
            </div>--}}
        </div>

        <div class="goodpart">
            <x-filter></x-filter>

            <div class="goods-container">
                <section class="goods-section" >
                    {{-- 產品數據輸出 --}}
                </section>
                <div class="goods-loading" id="goods-loading">
                    <div class="loader">
                        <div class="bar1"></div>
                        <div class="bar2"></div>
                        <div class="bar3"></div>
                        <div class="bar4"></div>
                        <div class="bar5"></div>
                        <div class="bar6"></div>
                        <div class="bar7"></div>
                        <div class="bar8"></div>
                        <div class="bar9"></div>
                        <div class="bar10"></div>
                        <div class="bar11"></div>
                        <div class="bar12"></div>
                    </div>
                    <p class="loadtext">正在努力為你加载...</p>
                </div>
                <div class="goods-complete" id="goods-complete">
                    <div class="spinner">
                        <span>已</span>
                        <span>經</span>
                        <span>到</span>
                        <span>底</span>
                        <span>喇</span>
                        <span>～</span>
                    </div>
                    <p class="completetext">老司機還沒挑到合適？請加客服LINE解鎖隱藏妹妹！</p>
                </div>
            </div>

        </div>

    </section>



@endsection
