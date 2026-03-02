@extends('web.layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('static/less/message.css') }}?v={{ app('cache.config')->get('asset_version') }}"/>
@stop

@section('script')
    @parent
    <script src="{{ asset('static/js/jquery.contip.js') }}"></script>
    <script src="{{ asset('static/js/sweetalert2.js') }}"></script>

    <script>

        var beforeCallback = function(){
            //获取产品前加载loading
            $('.goods-section').html($('#loading-template').html());

        }

        var successCallback = function(html){
            //获取到产品后
            $('.goods-section').html(html);
        }
        window.addEventListener('load', function () {
            var tab = parseInt("{{ $tab  }}");
            getGoods2(true,false,{tab:tab});
        });
    </script>

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
                    $('#phone').addClass('phone-top');
                    $('#parttwo-show').addClass('parttwo-top').addClass('parttwo-show-top');
                    $('.partone').addClass('partone-top');
                    $('.wrapper').addClass('wrapper-top');
                    $('.factorbox').addClass('factorbox-top');

                }else if($(document).scrollTop() < 20 ){
                    $('#phone').removeClass('phone-top');
                    $('#parttwo-show').removeClass('parttwo-top').removeClass('parttwo-show-top');
                    $('.wrapper').removeClass('wrapper-top');
                    $('.partone').removeClass('partone-top');
                    $('.factorbox').removeClass('factorbox-top');
                }
            }
        }
    </script>

    <!-- <script>
        if(window.matchMedia('(max-width: 768px)').matches){
            $(function() {
                let LastScrollTop = 0;

                $(window).scroll(function() {
                    let NewScrollTop = $(this).scrollTop();

                    if (NewScrollTop >= LastScrollTop) {
                        $('#phone').addClass('phone-top');
                        $('#parttwo-show').addClass('parttwo-top');
                        $('.wrapper').addClass('wrapper-top');
                    } else {
                        $('#phone').removeClass('phone-top');
                        $('#parttwo-show').removeClass('parttwo-top');
                        $('.wrapper').removeClass('wrapper-top');
                    }

                    LastScrollTop = NewScrollTop;
                });

            });
        }
    </script> -->


    <script>
        $(function() {
            $('#search').click(function() {
                $('#parttwo-show').toggleClass('parttwo-hide');
                $('body').toggleClass('bodyoverflow');
                $('.modebox').toggleClass('modebox-open');
                $('.choose-sec').toggleClass('choose-show');
                $('#title1').toggleClass('title1hide');
                $('#title2').toggleClass('title2hide');

                var win_height = window.innerHeight - $('header .wrapper').height() - $('.buttonbox').height();
                $('.parttwo-show').css('--height',win_height+'px');
            });
        });
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

@section('breadcrumb')
    <ul class="breadcrumb">
        <li><a href="{{ url('/') }}">首頁</a></li>
        <li class="active">聯繫我們</li>
    </ul>
@stop

@section('content')

    <section class="pc">
        @if(!is_mobile())<x-filter></x-filter>@endif
        <div class="goodpart">
            @if($factorbox)
            <div class="factorbox">
                <p class="factor">台灣
                    <svg t="1690789204748" class="factorclose" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="9156" width="200" height="200"><path d="M512 102.4a409.6 409.6 0 1 0 409.6 409.6 409.6 409.6 0 0 0-409.6-409.6z m181.248 518.144a51.2 51.2 0 0 1-72.704 72.704L512 584.192l-108.544 109.056a51.2 51.2 0 0 1-72.704-72.704L439.808 512 330.752 403.456a51.2 51.2 0 0 1 72.704-72.704L512 439.808l108.544-109.056a51.2 51.2 0 0 1 72.704 72.704L584.192 512z" fill="" p-id="9157"></path></svg>
                </p>
                <p class="factor">氣質
                    <svg t="1690789204748" class="factorclose" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="9156" width="200" height="200"><path d="M512 102.4a409.6 409.6 0 1 0 409.6 409.6 409.6 409.6 0 0 0-409.6-409.6z m181.248 518.144a51.2 51.2 0 0 1-72.704 72.704L512 584.192l-108.544 109.056a51.2 51.2 0 0 1-72.704-72.704L439.808 512 330.752 403.456a51.2 51.2 0 0 1 72.704-72.704L512 439.808l108.544-109.056a51.2 51.2 0 0 1 72.704 72.704L584.192 512z" fill="" p-id="9157"></path></svg>
                </p>
                <p class="factor">美腿長腿
                    <svg t="1690789204748" class="factorclose" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="9156" width="200" height="200"><path d="M512 102.4a409.6 409.6 0 1 0 409.6 409.6 409.6 409.6 0 0 0-409.6-409.6z m181.248 518.144a51.2 51.2 0 0 1-72.704 72.704L512 584.192l-108.544 109.056a51.2 51.2 0 0 1-72.704-72.704L439.808 512 330.752 403.456a51.2 51.2 0 0 1 72.704-72.704L512 439.808l108.544-109.056a51.2 51.2 0 0 1 72.704 72.704L584.192 512z" fill="" p-id="9157"></path></svg>
                </p>
            </div>
            @endif

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
