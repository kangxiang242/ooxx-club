@extends('web.layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/less" href="{{ asset('static/less/team.less') }}?v={{ app('cache.config')->get('asset_version') }}"/>

@stop

@section('script')
    @parent
    <script>
        const voiceplay = $('#playbutton .voiceplay');
        const voicestop = $('#playbutton .voicestop');
        var timerElement = $('#timer');
        var timeRemaining = parseInt(timerElement.attr('data-time'));
        var timeRemainingCount = parseInt(timerElement.attr('data-time'));
        var timerInterval;

        function updateTimerDisplay() {
        var minutes = Math.floor(timeRemaining / 60);
        var seconds = timeRemaining % 60;
        var timeString = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
        timerElement.text(timeString);
        }

        function startCountdown() {
            timerInterval = setInterval(function() {
                timeRemaining--;

                if (timeRemaining >= 0) {
                updateTimerDisplay();
                } else {
                clearInterval(timerInterval);
                timeRemaining = timeRemainingCount;
                updateTimerDisplay();
                voiceplay.show();
                voicestop.hide();
                }
            }, 1000);
        }

        $(function() {
            $('#playbutton').click(function() {
                if (voiceplay.is(':visible')) {
                    voiceplay.hide();
                    voicestop.show();
                    $('#voiceicon').addClass('voiceiconplay');
                    voice.play();

                    clearInterval(timerInterval);
                    timeRemaining = timeRemainingCount;
                    updateTimerDisplay();
                    startCountdown();




                } else {
                    voiceplay.show();
                    voicestop.hide();
                    $('#voiceicon').removeClass('voiceiconplay');
                    voice.pause();
                    voice.currentTime = 0;

                    clearInterval(timerInterval);
                    timeRemaining = timeRemainingCount;
                    updateTimerDisplay();
                }



            });


            $('.list-pic').click(function () {
                $('#cover-video').trigger('pause');
                $('#cover-video').css('z-index',0);
                $('#cover').css('z-index',2);
                var src = $(this).find('img').attr('src')
                $(this).addClass('chosen').siblings().removeClass('chosen');
                $('#cover').attr('src',src);

            })

            $('.list-vedio').click(function () {
                $('#cover-video').trigger('play');
                $('#cover-video').css('z-index',2);
                $('#cover').css('z-index',0);
                $(this).addClass('chosen').siblings().removeClass('chosen');
            })

        });

    </script>

    <script>
        $('.question-show').click(function(){
            var is_show = $(this).attr('data-show');
            var height = $(this).find('.q-desc span').outerHeight();
            if(!is_show){
                $(this).find('.q-desc').css('height',height);
                $(this).attr('data-show',1);
                $(this).find('.q-icon').addClass('i-icon-open');
            }else{
                $(this).find('.q-desc').css('height',0);
                $(this).removeAttr('data-show');
                $(this).find('.q-icon').removeClass('i-icon-open');
            }
        });
    </script>

    <script>
        var remove_page = "{{ is_mobile()?1:0 }}";
        window.addEventListener('load', function () {
            if(remove_page){
                getGoods2(false,false,{limit:4});
            }else{
                getGoods2(false,false);
            }

        });
    </script>

@stop

@section('content')
<header>
    <div class="wrapper" id="wrapper">
        <div class="logo-sec">
            <a href="{{ url('/') }}">
                <div class="logo" id="logo">
                    <img src="static/img/mclogo2.png" alt="" style="width:100%;">
                </div>
                <p class="phone" id="phone">
                <svg t="1690939117671" class="phoneicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="18473" width="200" height="200"><path d="M809.669274 830.096535a69.596508 69.596508 0 0 1-14.762896 103.34027L694.940485 1005.142299c-98.278706 71.283696-318.45675-65.800335-492.237123-305.381043S-31.393984 207.945931 66.884722 136.662235l98.700502-71.705494A69.596508 69.596508 0 0 1 268.0819 84.359404l66.222133 126.539106a97.435112 97.435112 0 0 1-5.061565 97.435112l-38.383529 60.316974a97.435112 97.435112 0 0 0 0 102.918472l21.089851 35.43095a1072.208025 1072.208025 0 0 0 109.667226 151.42513l26.995009 31.21298a97.435112 97.435112 0 0 0 98.700503 30.369385l68.331117-18.137272a97.435112 97.435112 0 0 1 94.060735 25.729619z m-87.73378-371.181377a54.833613 54.833613 0 0 0 70.440102-32.478371 166.188026 166.188026 0 0 0-153.112318-223.974217 54.833613 54.833613 0 0 0 0 109.667225 56.520801 56.520801 0 0 1 52.302831 76.34526 54.833613 54.833613 0 0 0 30.369385 70.440103z m207.102337-299.054087A385.100679 385.100679 0 0 0 620.704209 0a54.833613 54.833613 0 0 0 0 109.667225 278.386033 278.386033 0 0 1 256.452588 375.399348 54.833613 54.833613 0 1 0 102.918473 37.961732 388.053258 388.053258 0 0 0-51.037439-363.167234z" p-id="18474"></path></svg>
                    客服 09-8765-4321
                </p>
            </a>
        </div>

        <div class="m-nav">
            <div>
                <a href="{{ url('/') }}" class="base">
                    <svg t="1690532729137" class="baseicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="16557" width="200" height="200"><path d="M793.5 800.6H130c-16.6 0-30 13.4-30 30s13.4 30 30 30h663.5c8 0 15.6-3.2 21.2-8.8 5.6-5.6 8.8-13.3 8.8-21.2 0-8-3.2-15.6-8.8-21.2-5.7-5.7-13.3-8.8-21.2-8.8z m-110.9-56.7h-479C140.9 629.1 71.1 339.9 62.7 163h760.7c-8.3 176.9-78.1 466.1-140.8 580.9zM823.4 485c20.1-84.4 36.1-170.2 45.5-247.8C938.1 257.7 986 305.3 986 356.7c0 63.6-71.8 118.2-162.6 128.3z" p-id="16558"></path></svg>
                    <p>首頁選茶</p>
                </a>

            </div>


            <div>
                <a href="{{ url('blog') }}" class="base">
                    <svg t="1690532865213" class="baseicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="8240" width="200" height="200"><path d="M842.7434082 410.03314209c-13.71917724 0-25.21362305 11.4944458-25.21362304 25.21362304v330.74340821c0 13.71917724 11.4944458 25.21362305 25.21362304 25.21362304 13.71917724 0 25.21362305-11.4944458 25.21362305-25.21362304v-330.00183105c0-14.08996583-11.4944458-25.9552002-25.21362305-25.9552002z" p-id="8241"></path><path d="M765.99017334 791.94537354v-559.89074708C765.99017334 190.52630615 731.87762451 156.04296875 689.97851563 156.04296875H232.05462646C190.15551758 156.04296875 156.04296875 190.52630615 156.04296875 232.05462646v559.14916992c0 41.89910888 34.11254883 76.01165771 76.01165771 76.01165772h533.93554688c24.10125732 0 48.57330323-4.82025146 69.70825195-12.97760009h-6.30340576c-35.22491455 0.74157715-63.40484619-26.69677734-63.40484619-62.29248047zM308.80786133 258.00982666h76.01165771c28.17993164 0 50.79803467 22.61810302 50.79803468 50.79803467v76.01165771c0 28.17993164-22.61810302 50.79803467-50.79803468 50.79803468H308.80786133c-28.17993164 0-50.79803467-22.61810302-50.79803467-50.79803468V308.80786133c0-28.17993164 22.61810302-50.79803467 50.79803467-50.79803467z m330.37261963 482.76672363h-355.95703125c-13.71917724 0-25.21362305-11.4944458-25.21362305-25.21362305s11.4944458-25.21362305 25.21362305-25.21362304h355.95703125c13.71917724 0 25.21362305 11.4944458 25.21362305 25.21362304s-11.4944458 25.21362305-25.21362305 25.21362305z m0-152.76489258h-355.95703125c-13.71917724 0-25.21362305-11.4944458-25.21362305-25.21362304s11.4944458-25.21362305 25.21362305-25.21362305h355.95703125c13.71917724 0 25.21362305 11.4944458 25.21362305 25.21362305s-11.4944458 25.21362305-25.21362305 25.21362304z" p-id="8242"></path></svg>
                    <p>最新消息</p>
                </a>
            </div>

            <div class="contect">
                <div class="text">
                    <svg t="1691137092658" class="lineicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="8095" width="200" height="200"><path d="M826.24 420.821333a26.922667 26.922667 0 0 1 0 53.802667H751.36v48h74.88a26.88 26.88 0 1 1 0 53.717333h-101.802667a26.922667 26.922667 0 0 1-26.752-26.837333V345.941333c0-14.72 12.032-26.88 26.88-26.88h101.802667a26.88 26.88 0 0 1-0.128 53.76H751.36v48h74.88z m-164.48 128.682667a26.88 26.88 0 0 1-26.922667 26.752 26.368 26.368 0 0 1-21.76-10.666667l-104.234666-141.525333v125.44a26.88 26.88 0 0 1-53.632 0V345.941333a26.752 26.752 0 0 1 26.624-26.794666c8.32 0 16 4.437333 21.12 10.837333l105.045333 142.08V345.941333c0-14.72 12.032-26.88 26.88-26.88 14.72 0 26.88 12.16 26.88 26.88v203.562667z m-244.949333 0a26.965333 26.965333 0 0 1-26.922667 26.837333 26.922667 26.922667 0 0 1-26.752-26.837333V345.941333c0-14.72 12.032-26.88 26.88-26.88 14.762667 0 26.794667 12.16 26.794667 26.88v203.562667z m-105.216 26.837333H209.792a27.050667 27.050667 0 0 1-26.88-26.837333V345.941333c0-14.72 12.16-26.88 26.88-26.88 14.848 0 26.88 12.16 26.88 26.88v176.682667h74.922667a26.88 26.88 0 0 1 0 53.717333M1024 440.064C1024 210.901333 794.24 24.405333 512 24.405333S0 210.901333 0 440.064c0 205.269333 182.186667 377.258667 428.16 409.941333 16.682667 3.498667 39.381333 11.008 45.141333 25.173334 5.12 12.842667 3.370667 32.682667 1.621334 46.08l-6.997334 43.52c-1.92 12.842667-10.24 50.602667 44.757334 27.52 55.082667-22.997333 295.082667-173.994667 402.602666-297.6C988.842667 614.101333 1024 531.541333 1024 440.064" p-id="8096"></path></svg>
                    加line預約
                </div>
            </div>
        </div>
    </div>

</header>

<div class="infobody">
    <div class="pic">
        <a href="" class="back">
            <svg t="1689328151908" class="backicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="8030" width="200" height="200"><path d="M300.303599 490.89725601c-0.486519 0.97303701-1.337926 1.824445-1.702815 2.79748199-8.514075 17.757928-5.716593 39.651265 9.365483 53.881934L651.69165 872.692719c18.730966 17.757928 48.28697 16.90652101 66.044898-1.824445 17.757928-18.730966 16.90652101-48.28697-1.824445-66.044898l-308.452785-291.789524L714.695807 216.987291c18.609336-17.87955801 19.095855-47.435562 1.216296-66.044898-9.122224-9.487112-21.406818-14.352298-33.569783-14.35229801-11.676446 0-23.352892 4.378667-32.353486 13.13600201l-340.563012 328.278418c-0.608148 0.608148-0.851408 1.58118501-1.581185 2.189334-0.486519 0.486519-0.973037 0.851408-1.581185 1.337926C303.46597 484.329255 302.128044 487.734885 300.303599 490.89725601L300.303599 490.89725601zM300.303599 490.89725601" fill="#fff" p-id="8031"></path></svg>
        </a>
        <img id="cover" src="{{ asset_upload($product->cover) }}" alt="{{ $product->name }}" style="width: 100%;    position: relative;z-index: 2;">
        <video id="cover-video" style="object-fit:cover;position: absolute;top: 0;left: 0;z-index:0;" loop="" muted="" playsinline="" >
            <source src="{{ asset_upload($product->video) }}" type="video/mp4">
        </video>
        <ul class="spec-list" style="z-index: 2">
            @foreach(explode(',',$product->picture) as $key=>$item)
                <li class="list-pic {{ $key==0?"chosen":"" }}">
                    <img src="{{ asset_upload($item) }}" alt="{{ $product->name }}">
                </li>
            @endforeach
                <li class="list-vedio">
                    <svg t="1689910278906" class="playicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4144" width="200" height="200"><path d="M514 114.3c-219.9 0-398.9 178.9-398.9 398.9 0.1 219.9 179 398.8 398.9 398.8 219.9 0 398.8-178.9 398.8-398.8S733.9 114.3 514 114.3z m173 421.9L437.1 680.5c-17.7 10.2-39.8-2.6-39.8-23V368.9c0-20.4 22.1-33.2 39.8-23L687 490.2c17.7 10.2 17.7 35.8 0 46z" p-id="4145"></path></svg>
                    <div class="screen">
                        <img src="/static/img/screen.jpg" alt="">
                    </div>
                </li>
        </ul>
    </div>

    <div class="info" style="z-index:3">
        <div class="namebox">
            <div class="name">
                <span>{{ $product->name }}</span>
                <div class="flag">
                    <img src="{{ asset_upload($product->birthplace->icon) }}" alt="{{ $product->birthplace->name }}">
                </div>
            </div>

            @if($product->audio)
            <div class="voicebox">
                <button id="playbutton" class="playbutton" >
                    <svg t="1690508793404" class="voiceplay" viewBox="0 0 1756 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1475" width="200" height="200">
                        <path d="M1220.672 487.107657c-0.215771-0.374857-0.453486-0.731429-0.676571-1.098971-6.266514-11.536457-16.010971-21.813029-28.692114-29.134629l-462.6944-267.136c-11.918629-6.880914-24.797257-10.203429-37.198629-10.296686-0.239543-0.003657-0.475429-0.020114-0.7168-0.020114-0.142629 0-0.2816 0.010971-0.424229 0.0128-0.778971 0.007314-1.552457 0.034743-2.327771 0.065829-0.164571 0.007314-0.329143 0.009143-0.493714 0.018286-20.598857 1.000229-39.416686 11.029943-49.634743 28.728686-4.885943 8.462629-7.259429 17.751771-7.389257 27.1488-0.751543 4.337371-1.155657 8.815543-1.155657 13.4016l0 534.273829c0 4.586057 0.404114 9.064229 1.155657 13.4016 0.129829 9.3952 2.505143 18.686171 7.389257 27.1488 10.218057 17.696914 29.034057 27.726629 49.632914 28.728686 0.1664 0.009143 0.334629 0.010971 0.501029 0.018286 0.771657 0.032914 1.543314 0.060343 2.320457 0.065829 0.142629 0.001829 0.2816 0.0128 0.424229 0.0128 0.241371 0 0.479086-0.018286 0.718629-0.020114 12.401371-0.095086 25.278171-3.4176 37.1968-10.296686l462.6944-267.136c12.682971-7.3216 22.4256-17.598171 28.692114-29.134629 0.223086-0.367543 0.4608-0.724114 0.676571-1.098971 5.176686-8.965486 7.533714-18.859886 7.389257-28.8256C1228.205714 505.967543 1225.848686 496.073143 1220.672 487.107657z" p-id="1476"></path>
                    </svg>

                    <svg t="1690514152088" class="voicestop" viewBox="0 0 1756 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3269" width="200" height="200" display="none">
                        <path d="M864 64H160C107 64 64 107 64 160v704c0 53 43 96 96 96h704c53 0 96-43 96-96V160c0-53-43-96-96-96z" p-id="3270"></path>
                </svg>
                </button>
                <div class="voiceicon" style="animation-duration: {{ $product->audio_time }}s;" id="voiceicon">
                    <img src="/static/img/text4.svg" alt="" style="width: 100%; height:100%;">
                </div>
                <span class="timer" id="timer" data-time="{{ $product->audio_time }}">00:{{ str_pad($product->audio_time,2,'0',STR_PAD_LEFT) }}</span>
                <audio src="{{ asset_upload($product->audio) }}" id="voice" style="width:0;"></audio>
            </div>
            @endif

        </div>
        <div class="location">
                <svg t="1689906436933" class="locaicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2323" width="200" height="200"><path d="M509.76 98.11c-196.74 0-356.22 160.4-356.22 358.36 0 98.93 39.9 188.49 104.32 253.38l192.78 193.91c32.59 32.78 85.64 32.78 118.23 0l192.78-193.91a358.303 358.303 0 0 0 104.32-253.38c0.01-197.96-159.48-358.36-356.21-358.36z m0 517.54a158.759 158.759 0 0 1-112.19-46.83 158.822 158.822 0 0 1-46.18-112.46 158.708 158.708 0 0 1 158.36-159.17 158.782 158.782 0 0 1 158.36 159.28A158.724 158.724 0 0 1 509.75 615.7v-0.05z m0 0" p-id="2324"></path></svg>
                <span>{{ mb_substr($product->city->name,0,-1) }} {{ $product->county->name }}</span>
        </div>
        <ul class="codebox">
            <li class="codeitem"><span class="num">{{ $product->age }}</span>歲</li>
            <li class="codeitem"><span class="num">{{ $product->height }}</span>公分</li>
            <li class="codeitem"><span class="num">{{ $product->weight }}</span>公斤</li>
            <li class="codeitem"><span class="num">{{ $product->cup }}</span>罩杯</li>

        </ul>
        <div class="pricebox">
            <p class="title">基礎消費</p>
            <ul class="pricelist">
                @foreach($product->prices as $item)
                    @if($item->status == 1)
                        <li class="item">
                            <span class="text">{{ $item->text }}</span>
                            <div class="dashed"></div>
                            <span class="price">${{ number_format($item->price) }}</span>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="coopbox">
            <p class="title">全程可配合</p>
            <ul class="cooplist">
                @foreach($product->withServes as $serve)
                    <li class="coopitem"><img src="{{ asset_upload($serve->icon) }}" class="coopicon">{{ $serve->name }}</li>
                @endforeach
            </ul>
        </div>
        <div class="addbox">
            <p class="title">可加值服務</p>
            <ul class="addlist">
                @foreach($added as $serve)
                    <li class="additem"><img src="{{ asset_upload($serve->serve->icon) }}" class="coopicon">{{ $serve->serve->name }} {{ $serve->price?"+$".$serve->price:"" }}</li>
                @endforeach
            </ul>
        </div>
        <div class="timebox">
            <p class="title">可約時間</p>
            <ul class="timeline">
                @if(date('H')>=0 && date('H')<=14)
                    <li class="timeitem">{{ date('m-d') }}(今天)<p class="time">16:00~2:00</p></li>
                @else
                    <li class="timeitem">{{ date('m-d') }}(今天)<p class="time">{{ date('H')+2 }}:00~2:00</p></li>
                @endif
                <li class="timeitem">{{ date("m-d",strtotime("+1 day")) }}(明天)<p class="time">16:00~2:00</p></li>
                <li class="othertime"><p>其他時間<br>請聯絡客服哦！</p></li>
            </ul>
        </div>
        @if($product->comment_picture)
        <div class="reviewbox">
            <p class="title">客評截圖</p>
            <ul class="reviewlist">
                @foreach(explode(',',$product->comment_picture) as $item)
                <li class="reviewitem">
                    <img src="{{ asset_upload($item) }}" alt="客評截圖">
                </li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="qabox">
            <p class="title">常見問題</p>
            <ul class="qalist">
                @foreach($faqs as $faq)
                    <div class="qaitem question-show">
                        <p class="q-title">
                            <span class="s1">Q.</span>
                            <span class="s2">{{ $faq->title }}</span>
                            <svg t="1691655414517" class="q-icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="8095" width="200" height="200"><path d="M723.696401 533.10274399c0.486519-0.97303701 1.337926-1.824445 1.702815-2.79748199 8.514075-17.757928 5.716593-39.651265-9.365483-53.881934L372.30835 151.307281c-18.730966-17.757928-48.28697-16.90652101-66.044898 1.824445-17.757928 18.730966-16.90652101 48.28697 1.824445 66.044898l308.452785 291.789524L309.304193 807.012709c-18.609336 17.87955801-19.095855 47.435562-1.216296 66.044898 9.122224 9.487112 21.406818 14.352298 33.569783 14.35229801 11.676446 0 23.352892-4.378667 32.353486-13.13600201l340.563012-328.278418c0.608148-0.608148 0.851408-1.58118501 1.581185-2.189334 0.486519-0.486519 0.973037-0.851408 1.581185-1.337926C720.53403 539.670745 721.871956 536.265115 723.696401 533.10274399L723.696401 533.10274399zM723.696401 533.10274399" fill="#272636" p-id="8096"></path></svg>
                        </p>
                        <p class="q-desc"><span>{{ $faq->content }}</span></p>

                    </div>
                @endforeach
            </ul>
        </div>

    </div>

</div>

<div class="guessbox">
    <p class="title">猜你喜歡</p>
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
            <p class="completetext">老司機還沒挑到合適？請加客服Line解鎖隱藏妹妹！</p>
        </div>
    </div>
</div>




<ul class="info-nav">
    <li class="base">
        <a href="{{ url('/') }}">
            <svg t="1689844099946" class="baseicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2374" width="200" height="200"><path d="M1004.8 896s-12.8 25.6-25.6 0c0 0-147.2-448-512-332.8V704s-6.4 83.2-76.8 25.6L38.4 422.4S-38.4 384 44.8 326.4L403.2 19.2s51.2-38.4 64 25.6V192s672 32 537.6 704z" fill="#000000" p-id="2375"></path></svg>
            <p>返回</p>
        </a>
    </li>
    <li class="contect">
        <div class="text">
            <svg t="1691137092658" class="lineicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="8095" width="200" height="200"><path d="M826.24 420.821333a26.922667 26.922667 0 0 1 0 53.802667H751.36v48h74.88a26.88 26.88 0 1 1 0 53.717333h-101.802667a26.922667 26.922667 0 0 1-26.752-26.837333V345.941333c0-14.72 12.032-26.88 26.88-26.88h101.802667a26.88 26.88 0 0 1-0.128 53.76H751.36v48h74.88z m-164.48 128.682667a26.88 26.88 0 0 1-26.922667 26.752 26.368 26.368 0 0 1-21.76-10.666667l-104.234666-141.525333v125.44a26.88 26.88 0 0 1-53.632 0V345.941333a26.752 26.752 0 0 1 26.624-26.794666c8.32 0 16 4.437333 21.12 10.837333l105.045333 142.08V345.941333c0-14.72 12.032-26.88 26.88-26.88 14.72 0 26.88 12.16 26.88 26.88v203.562667z m-244.949333 0a26.965333 26.965333 0 0 1-26.922667 26.837333 26.922667 26.922667 0 0 1-26.752-26.837333V345.941333c0-14.72 12.032-26.88 26.88-26.88 14.762667 0 26.794667 12.16 26.794667 26.88v203.562667z m-105.216 26.837333H209.792a27.050667 27.050667 0 0 1-26.88-26.837333V345.941333c0-14.72 12.16-26.88 26.88-26.88 14.848 0 26.88 12.16 26.88 26.88v176.682667h74.922667a26.88 26.88 0 0 1 0 53.717333M1024 440.064C1024 210.901333 794.24 24.405333 512 24.405333S0 210.901333 0 440.064c0 205.269333 182.186667 377.258667 428.16 409.941333 16.682667 3.498667 39.381333 11.008 45.141333 25.173334 5.12 12.842667 3.370667 32.682667 1.621334 46.08l-6.997334 43.52c-1.92 12.842667-10.24 50.602667 44.757334 27.52 55.082667-22.997333 295.082667-173.994667 402.602666-297.6C988.842667 614.101333 1024 531.541333 1024 440.064" p-id="8096"></path></svg>
            加line預約
        </div>
    </li>
</ul>

@endsection
