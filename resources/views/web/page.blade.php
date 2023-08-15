@extends('web.layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/less" href="{{ asset('static/less/page.less') }}?v={{ app('cache.config')->get('asset_version') }}"/>

@stop

@section('script')
    @parent



@stop
@section('topic-title',$page->title )
@section('breadcrumb')
    <ul class="breadcrumb">
        <li><a href="{{ url('/') }}">首頁</a></li>
        <li class="active">{{ $page->title }}</li>
    </ul>
@stop
@section('content')


    <div class="container">


        <div class="main">
            <div id="page-about">

                <div class="content">
                    {!! $page->content !!}
                </div>

            </div>
        </div>
    </div>




@endsection
