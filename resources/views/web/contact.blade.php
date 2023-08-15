@extends('web.layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/less" href="{{ asset('static/less/message.less') }}?v={{ app('cache.config')->get('asset_version') }}"/>

    <style>
        .contact-back{
            padding: 120px 0;
        }
        @media screen and (max-width: 768px){
            .contact-back{
                padding: 88px 0;
            }
        }
        .section .section-inner .head .title{
            font-weight: 400;
            font-size: 48px;
            letter-spacing: 0.15em;
            line-height: 1.3;
            margin-bottom: 15px;
            text-align: center;
            color: #fff;
        }
        .bg-area *{
            box-sizing: unset;
        }
    </style>
@stop
@section('marquee')@stop
@section('footer')@stop
@section('script')
    @parent
    <script src="{{ asset('static/js/jquery.contip.js') }}"></script>
    <script src="{{ asset('static/js/sweetalert2.js') }}"></script>
    <script src="{{ asset('static/js/api.js') }}"></script>
{{--    <script src="{{ asset('static/js/main.js') }}"></script>--}}
    <script>

        var marquee_id;


        $(function(){
             marquee();
            $(window).resize(function(){
                /*if(marquee_id){
                    clearInterval(marquee_id)
                }


                marquee();*/
            });

        })




        function marquee(){
            var loopWrapAll = [];
            var loopObject = [];
            $('.loopWrap').each(function(){
                loopObject = [];

                loopObject['height'] = $(this).find('.loopGroup').outerHeight();
                loopObject['elem'] = $(this);
                loopObject['seat'] = 0;
                loopWrapAll.push(loopObject)

                if($(this).find('.loopGroup').length <= 1){
                    $(this).append($(this).html())
                }
            });





            marquee_id = setInterval(function(){

                for (var i=0;i<loopWrapAll.length;i++){

                    if(loopWrapAll[i].seat >= loopWrapAll[i].height){
                        loopWrapAll[i].seat  = 0;
                    }

                    loopWrapAll[i].seat += 0.2;
                    var css = "translate3d(0,-"+loopWrapAll[i].seat+"px,0)";
                    loopWrapAll[i].elem.css('transform',css);

                }

            })
        }
    </script>

@stop
@section('banners')@stop
@section('topic-title','聯絡我們')
@section('breadcrumb')
    <ul class="breadcrumb">
        <li><a href="{{ url('/') }}">首頁</a></li>
        <li class="active">聯絡我們</li>
    </ul>
@stop
@section('content')


    <main class="router page-top" data-namespace="top" data-nav="top" style="--image: url('{{ asset_upload(app('cache.config')->get('contact_back_image')?:app('cache.config')->get('home_contact_image')) }}')">


        <section class="section contact-back" >
            <div class="contact-inner down">
                <div class="head">
                    <h1 class="title contact-title">
                        聯絡方式
                    </h1>
                </div>

                <div class="main">
                    <div class="contact-main">
                        <div class="stackable show-sordown">
                            <div class="cose-head invisible" data-trigger="">
                                <p class="head-title">{{ app('cache.config')->get('contact_left_title') }}</p>
                                <p class="head-desc">{{ app('cache.config')->get('contact_left_desc') }}</p>
                            </div>
                            <div class="stk-content">
                                <div class="skt-item invisible" data-trigger="">
                                    <p class="p1"><i class="iconfont">&#xebf5;</i>LINE 帳號</p>
                                    <p class="p2">{{ app('cache.config')->get('line_id') }}</p>
                                    <p class="btn-box">
                                        <a href="{{ app('cache.config')->get('line_url') }}" class="button ripple" target="_blank" data-inquire="" data-inquire-type="line" data-inquire-position="middle">
                                            <span class="text"><i class="iconfont">&#xebf5;</i>加Line聊聊</span>
                                            <span class="dot"><i class="iconfont">&#xe775;</i></span>
                                        </a>
                                    </p>
                                </div>

                                <div class="skt-item invisible" data-trigger="">
                                    <p class="p1"><i class="iconfont">&#xe6bc;</i>免費專線</p>
                                    <p class="p2">{{ app('cache.config')->get('service_phone') }}</p>
                                    <p class="btn-box">
                                        <a href="tel::+886{{ app('cache.config')->get('service_phone') }}" class="button ripple" data-inquire="" data-inquire-type="phone" data-inquire-position="middle">
                                            <span class="text"><i class="iconfont">&#xe6bc;</i>直接撥號聯繫</span>
                                            <span class="dot"><i class="iconfont">&#xe775;</i></span>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="editor">
                            <div class="cose-head invisible" data-trigger="">
                                <p class="head-title">{{ app('cache.config')->get('contact_right_title') }}</p>
                                <p class="head-desc">{{ app('cache.config')->get('contact_right_desc') }}</p>
                            </div>
                            <div class="contact-form invisible" data-sordown="" data-trigger="">
                                <div class="hide" id="contact-loading">
                                    <img width="50" src="{{ asset_upload(app('cache.config')->get('loading_image')) }}" alt="loading">
                                </div>
                                <div class="result" id="contact-message">
                                    <p class="p1"><span class="proper"><i class="iconfont">&#xe615;</i></span><span class="text">送出成功，我們會儘快聯絡您</span></p>
                                </div>
                                <form id="contact-form" name="pageform1" method="post" action="{{ url('contact') }}" >
                                    {!! csrf_field() !!}
                                    <div class="work">
                                        <div class="list">
                                            <label for="Name"><em>*</em>姓名</label>
                                            <input class="control" type="text" id="Name" name="name" data-verify="required" autocomplete="off">
                                        </div>
                                        <div class="list">
                                            <label for="Line"><em>*</em>LINE ID</label>
                                            <input class="control" type="text" id="Line" name="line_id" autocomplete="off">
                                        </div>
                                        <div class="list">
                                            <label><em>*</em>諮詢職缺</label>
                                            <p class="flag">
                                                <select class="control" name="service_name" id="Title">
                                                    <option value="" selected>請選擇</option>
                                                    @foreach($products as $item)
                                                        <option value="{{ $item->name }}" >{{ $item->name }}</option>
                                                    @endforeach

                                                </select>
                                                <i class="iconfont right-icon">&#xe606;</i>
                                            </p>
                                        </div>
                                        <div class="list">
                                            <label><em>*</em>居住地區</label>
                                            <p class="flag">
                                                <select class="control" name="address" id="Address">
                                                    <option value="">請選擇</option>
                                                    <option value="台北市">台北市</option>
                                                    <option value="基隆市">基隆市</option>
                                                    <option value="新北市">新北市</option>
                                                    <option value="宜蘭縣">宜蘭縣</option>
                                                    <option value="新竹市">新竹市</option>
                                                    <option value="新竹縣">新竹縣</option>
                                                    <option value="桃園縣">桃園縣</option>
                                                    <option value="苗栗縣">苗栗縣</option>
                                                    <option value="台中市">台中市</option>
                                                    <option value="彰化縣">彰化縣</option>
                                                    <option value="南投縣">南投縣</option>
                                                    <option value="嘉義市">嘉義市</option>
                                                    <option value="嘉義縣">嘉義縣</option>
                                                    <option value="雲林縣">雲林縣</option>
                                                    <option value="台南市">台南市</option>
                                                    <option value="高雄市">高雄市</option>
                                                    <option value="屏東縣">屏東縣</option>
                                                    <option value="台東縣">台東縣</option>
                                                    <option value="花蓮縣">花蓮縣</option>
                                                    <option value="澎湖縣">澎湖縣</option>
                                                    <option value="金門縣">金門縣</option>
                                                    <option value="連江縣">連江縣</option>
                                                </select>
                                                <i class="iconfont right-icon">&#xe606;</i>
                                            </p>

                                        </div>
                                        <div class="list">

                                            <label for="Phone"><em>*</em>手機電話</label>
                                            <p class="flag">
                                                <input class="control pd" type="tel" id="Phone" name="phone" autocomplete="off">
                                            </p>
                                        </div>
                                        <div class="list">
                                            <label><em>*</em>聯絡時間</label>
                                            <p class="flag">
                                                <select class="control" id="Company" name="contact_time">
                                                    <option value="都可以" selected>都可以</option>
                                                    <option value="09:00-10:00">09:00-10:00</option>
                                                    <option value="10:00-11:00">10:00-11:00</option>
                                                    <option value="11:00-12:00">11:00-12:00</option>
                                                    <option value="12:00-13:00">12:00-13:00</option>
                                                    <option value="13:00-14:00">13:00-14:00</option>
                                                    <option value="14:00-15:00">14:00-15:00</option>
                                                    <option value="15:00-16:00">15:00-16:00</option>
                                                    <option value="16:00-17:00">16:00-17:00</option>
                                                    <option value="17:00-18:00">17:00-18:00</option>
                                                    <option value="19:00-20:00">19:00-20:00</option>
                                                    <option value="20:00-21:00">20:00-21:00</option>
                                                    <option value="22:00-23:00">22:00-23:00</option>
                                                    <option value="23:00-24:00">23:00-24:00</option>
                                                </select>
                                                <i class="iconfont right-icon">&#xe606;</i>
                                            </p>
                                        </div>
                                        <div class="list">
                                            <label for="captcha"><em>*</em>驗證碼</label>
                                            <div class="column">
                                                <input class="control" name="captcha" type="text"  id="captcha" autocomplete="off">
                                                <img class="captcha_img" src="{{ captcha_src() }}" onclick="$(this).attr('src','{{ captcha_src() }}'+Math.random(1000,9999))">
                                            </div>
                                        </div>
                                        <p class="safe">※ 本網站有 SSL 資安防護，個人資料僅提供專員協助評估，絕不外洩！</p>
                                        <div class="list last">
                                            <p class="btn-submit">
                                                <a href="javascript:$('#contact-form').submit();" class="arr-btn"><span>免費咨詢</span></a>
                                            </p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="flavour">
                        <p class="text"><span class="si"><i class="iconfont">&#xe672;</i></span><span class="s1">需年滿18歲</span></p>
                        <p class="text"><span class="si"><i class="iconfont">&#xe671;</i></span><span class="s1">正職/兼職/打工</span></p>
                        <p class="text"><span class="si"><i class="iconfont">&#xe622;</i></span><span class="s1">可日領/週領薪</span></p>
                        <p class="text"><span class="si"><i class="iconfont">&#xe630;</i></span><span class="s1">專人接洽</span></p>
                        <p class="text"><span class="si"><i class="iconfont">&#xe6a9;</i></span><span class="s1">尊重隱私</span></p>
                    </div>
                </div>
            </div>
        </section>

        <div class="bg-area">

            <div class="loopWrap">
                <ul class="circles loopGroup">
                    @php
                        $loop_k = 1;
                    @endphp
                    @foreach($slide_left_images as $key=>$item)
                        @if($key<5)
                        <li class="img{{ $key+$loop_k }} is-visible">
                            <div class="imgWrap">
                                <img src="{{ asset_upload($item) }}"  alt="">
                            </div>
                        </li>
                        @endif
                        @php
                            $loop_k++;
                        @endphp
                    @endforeach
                    {{--<li class="img3 is-visible">
                        <div class="imgWrap">
                            <img src="/qv_files/fv_img3.png" width="722" height="1172" alt="">
                        </div>
                    </li>
                    <li class="img5 is-visible">
                        <div class="imgWrap">
                            <img src="/qv_files/fv_img5.png" width="788" height="534" alt="">
                        </div>
                    </li>
                    <li class="img7 is-visible">
                        <div class="imgWrap">
                            <img src="/qv_files/fv_img7.png" width="1472" height="903" alt="">
                        </div>
                    </li>--}}
                </ul>

            </div>
            <div class="loopWrap right">
                <ul class="circles loopGroup">
                    @php

                        $loop_k = 1;
                    @endphp
                    @foreach($slide_right_images as $key=>$item)
                        @if($key<5)
                        <li class="img{{ $key+1+$loop_k }} is-visible">
                            <div class="imgWrap">
                                <img src="{{ asset_upload($item) }}" alt="">
                            </div>
                        </li>
                        @endif
                        @php
                            $loop_k++;
                        @endphp
                    @endforeach
                    {{--<li class="img4 is-visible">
                        <div class="imgWrap">
                            <img src="/qv_files/fv_img4.png" width="722" height="1172" alt="">
                        </div>
                    </li>
                    <li class="img6 is-visible">
                        <div class="imgWrap">
                            <img src="/qv_files/fv_img6.png" width="788" height="534" alt="">
                        </div>
                    </li>--}}
                </ul>

            </div>
        </div>

    </main>



@endsection
