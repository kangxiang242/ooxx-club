@extends('web.layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('static/less/news.css') }}?v={{ app('cache.config')->get('asset_version') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('static/less/pagination.css') }}?v={{ app('cache.config')->get('asset_version') }}"/>

@stop

@section('script')
    @parent

@stop


@section('content')

    <div class="container">
        <div class="main case-main" style="margin-bottom: 80px">
            <div class="case">
                <div class="so" id="so" >
                    <div class="present">
                        @if($article && $article->isNotEmpty())
                            @foreach($article as $item)
                                <a href="{{ url('blog/'.$item->id) }}" class="news">
                                    <div class="sim">
                                        <div class="img-wrap">
                                            <img src="{{ asset_upload($item->img) }}" alt="{{ $item->title }}">
                                            @if(config('app.disable_contact'))
                                            <div class="contact-wrap">
                                                @if(liaison_get('line_qrcode'))<div class="qrcode-box"><img src="{{ '/uploads/'.liaison_get('line_qrcode') }}" alt="line"></div>@endif
                                                @if(liaison_get('line_id'))<p class="line">LINE:{{ liaison_get('line_id') }}</p>@endif
                                            </div>
                                            @endif
                                        </div>
                                        <div class="info-wrap">
                                            @if( $item->sub_title)
                                            <p class="sub-title">{{ $item->sub_title }}</p>
                                            @endif
                                            <p class="news-title"><span class="text">{{ $item->title }}</span></p>
                                            <div class="resolution">
                                                <p class="describe">{{ $item->brief }}</p>
                                                <div class="labelbox">
                                                    <p class="time">{{ $item->release_at->format('Y-m-d') }}</p>
                                                    <div class="views">
                                                        @if($item->author)<p class="editor">By.{{ $item->author }}</p>@endif
                                                        <svg t="1689216927090" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2591" width="200" height="200"><path d="M132.693333 453.76C235.946667 278.997333 377.6 199.253333 512 199.253333c134.4 0 276.053333 79.786667 379.306667 254.506667 21.162667 35.882667 21.162667 80.597333 0 116.48-103.253333 174.762667-244.906667 254.506667-379.306667 254.506667-134.4 0-276.053333-79.786667-379.306667-254.506667a114.645333 114.645333 0 0 1 0-116.48z m850.432-54.272C865.28 199.978667 692.309333 92.586667 512 92.586667S158.72 199.978667 40.832 399.488a221.312 221.312 0 0 0 0 225.024C158.72 824.021333 331.690667 931.413333 512 931.413333c180.309333 0 353.28-107.392 471.125333-306.901333a221.312 221.312 0 0 0 0-225.024zM437.333333 512a74.666667 74.666667 0 1 1 149.333334 0 74.666667 74.666667 0 0 1-149.333334 0zM512 330.666667a181.333333 181.333333 0 1 0 0 362.666666 181.333333 181.333333 0 0 0 0-362.666666z" p-id="2592"></path></svg>
                                                        <p class="num">{{ $item->read_num }}</p>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <p class="empty">暫無攻略~</p>
                        @endif
                    </div>

                    @if($article && $article->isNotEmpty())
                        {!! $article->links() !!}
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
