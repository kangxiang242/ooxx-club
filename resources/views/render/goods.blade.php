@php
    $per_page = $product->perPage();
    $currentPage = $product->currentPage()-1;
    $current_count = $currentPage*$per_page;

@endphp
@foreach($product->shuffle() as $key=>$goods)
    @php
        $current_count += 1;
    @endphp

<div class="goods hide">
    <div class="label">
        <p class="labeltext">{{ $goods->quicks->first()->text }}</p>
    </div>
    <a href="{{ url('product/'.$goods->id) }}">
        <div class="cover">
            <div class="serve">
                @foreach($goods->withServes as $key=>$serve)
                    @if($key<4)
                        <p class="item">{{ $serve->name }}</p>
                    @endif
                @endforeach
            </div>
            <div class="flag">
                <img src="{{ asset_upload($goods->birthplace->icon) }}" alt="{{ $goods->birthplace->name }}">
            </div>
            <p class="wh">{{ $goods->height }}/{{ $goods->weight }}kg
                <span class="cup">{{ $goods->cup }}杯</span>
            </p>
            <div class="master {{ $current_count%7==0?"have-video222":"" }}" >
                <img class="goods-img" fetchpriority="low" src="{{ asset_upload($goods->thumbnail('small','cover')) }}" data-lazyload data-src="{{ asset_upload($goods->cover) }}" alt="{{ $goods->name }}">
                {{--@if($current_count%7==0)
                    <video preload="metadata" class="g-video" style="object-fit:cover;" data-src="{{ asset_upload($goods->video) }}" autoplay poster="{{ asset_upload($goods->video_cover) }}" loop="" muted="" width="100%" playsinline="" >
                    </video>
                @endif--}}
            </div>
        </div>
        <div class="message">
            <div class="namebox">
                <p class="goodname">{{ $goods->name }}<span class="age">{{ $goods->age }}</span></p>
                <div class="mode">
                    @if($goods->fixation)
                    <p class="type">定點</p>
                    @endif
                    @if($goods->outgoing)
                    <p class="type">外送</p>
                    @endif
                </div>
            </div>
            <div class="pricebox">
                <span class="price">$&nbsp;{{ $goods->price_start }}<span class="up">底</span></span>
            </div>
        </div>
    </a>
</div>
@endforeach
