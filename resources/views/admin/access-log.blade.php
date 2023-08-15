
    <link rel="stylesheet" href="{{ asset('/static/admin/css/pintuer.css') }}">
    <link rel="stylesheet" href="{{ asset('/static/admin/css/admin.css') }}">


    <link href="{{ asset('static/admin/datepicker/foundation-datepicker.css') }}" rel="stylesheet" type="text/css">

    <script src="{{ asset('static/admin/js/pintuer.js') }}"></script>
    <script src="{{ asset('static/admin/js/jquery.ui.js') }}"></script>

    <style type="text/css">
        td{word-break: break-word;}
        .month_select a{
            border: 1px solid #ccc;
            width: 60px;
            height: 30px;
            line-height: 30px;
            display: inline-block;
            text-align: center;
        }
        .month_select .activate{
            color: #fff;
            background-color: #8fd5f1;
        }
        .form-group{
            /*float:left;*/
        }
    </style>



<div class="panel admin-panel">
    <div class="panel-head">
        <strong>今日訪問情況</strong>
    </div>
    <div class="padding border-bottom">
        <div class="body-content">
            <div class="form-x">
                <div class="form-group button-big text-center">
                    <b>{{ date('Y-m-d', time()) }}</b>
                    <span class="margin-left">訪問IP數量：<b>{{ $data['today_ip'] }}</b></span>
                    <span class="margin-left">訪問總數：<b>{{ $data['today_num'] }}</b></span>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-head">
        <strong>訪問情況</strong>
        <a href="javascript:;" class="text-gray showcanvas">收起/展示</a>
    </div>
    <div class="padding border-bottom canvasBox">
        <div class="month_select">
            <a class="{{$data['select_month_num']==1?'activate':''}}" href="?month_num=1&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">1月</a>
            <a class="{{$data['select_month_num']==2?'activate':''}}" href="?month_num=2&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">2月</a>
            <a class="{{$data['select_month_num']==3?'activate':''}}" href="?month_num=3&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">3月</a>
            <a class="{{$data['select_month_num']==4?'activate':''}}" href="?month_num=4&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">4月</a>
            <a class="{{$data['select_month_num']==5?'activate':''}}" href="?month_num=5&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">5月</a>
            <a class="{{$data['select_month_num']==6?'activate':''}}" href="?month_num=6&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">6月</a>
            <a class="{{$data['select_month_num']==7?'activate':''}}" href="?month_num=7&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">7月</a>
            <a class="{{$data['select_month_num']==8?'activate':''}}" href="?month_num=8&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">8月</a>
            <a class="{{$data['select_month_num']==9?'activate':''}}" href="?month_num=9&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">9月</a>
            <a class="{{$data['select_month_num']==10?'activate':''}}" href="?month_num=10&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">10月</a>
            <a class="{{$data['select_month_num']==11?'activate':''}}" href="?month_num=11&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">11月</a>
            <a class="{{$data['select_month_num']==12?'activate':''}}" href="?month_num=12&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">12月</a>
        </div>
        <div class="body-content">
            <div class="form-x">
                <div class="form-group text-big">
                    <div><b>{{ $data['select_month_num'] }}月訪問情況匯總</b>:</div>
                    <div style="font-size: 13px">
                        {{ $data['select_month_num'] }}月訪問總量：{{ $data['zd_month'] }}
                    </div>
                </div>
                <div class="form-group">
                    <canvas id="month_ctx" width="1200" height="400"></canvas>
                </div>
                <!--<div class="form-group text-big"><b>{$select_month_num}月URL訪問情況(前10個URL)</b>:</div>
                <div class="form-group">
                    <canvas id="url_ctx" width="1200" height="400"></canvas>
                </div>-->
            </div>
        </div>
    </div>

    <div class="panel-head">
        <strong>页面訪問排行</strong>
        <a href="javascript:;" class="text-gray showcanvas2">收起/展示</a>
    </div>
    <div class="padding border-bottom canvasBox2">
        <div class="month_select">
            <a class="{{$data['select_month_num']==1?'activate':''}}" href="?month_num=1&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">1月</a>
            <a class="{{$data['select_month_num']==2?'activate':''}}" href="?month_num=2&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">2月</a>
            <a class="{{$data['select_month_num']==3?'activate':''}}" href="?month_num=3&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">3月</a>
            <a class="{{$data['select_month_num']==4?'activate':''}}" href="?month_num=4&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">4月</a>
            <a class="{{$data['select_month_num']==5?'activate':''}}" href="?month_num=5&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">5月</a>
            <a class="{{$data['select_month_num']==6?'activate':''}}" href="?month_num=6&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">6月</a>
            <a class="{{$data['select_month_num']==7?'activate':''}}" href="?month_num=7&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">7月</a>
            <a class="{{$data['select_month_num']==8?'activate':''}}" href="?month_num=8&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">8月</a>
            <a class="{{$data['select_month_num']==9?'activate':''}}" href="?month_num=9&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">9月</a>
            <a class="{{$data['select_month_num']==10?'activate':''}}" href="?month_num=10&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">10月</a>
            <a class="{{$data['select_month_num']==11?'activate':''}}" href="?month_num=11&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">11月</a>
            <a class="{{$data['select_month_num']==12?'activate':''}}" href="?month_num=12&ip={{request('ip')}}&u={{request('u')}}&v_host={{request('host')}}">12月</a>
        </div>
        <div class="body-content">
            <div class="form-x">

                <div class="form-group text-big"><b>{{ $data['select_month_num'] }}月URL訪問情況(前10個URL)</b>:</div>
                <div class="form-group">
                    <canvas id="url_ctx" width="1200" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>


    <div class="panel-head">
        <strong>訪問數據</strong>
    </div>
    <div class="padding border-bottom">
        <div class="body-content">
            <div class="form-x">
                <form action="" method="get" >
                    <input type="hidden" name="month_num" value="{{$data['select_month_num']}}">
                    <div class="form-group">
                        <div class="label">
                            <label>IP：</label>
                        </div>
                        <div class="w50" style="width: 250px">
                            <input type="text" class="input" value="{{ request('ip') }}" name="ip" placeholder="IP" />
                        </div>
                        <div class="label">
                            <label>URL：</label>
                        </div>
                        <div class="w50" style="width: 250px">
                            <input type="text" class="input" value="{{ request('u') }}" name="u" placeholder="URL" />
                        </div>

                        <div class="label">
                            <label>設備：</label>
                        </div>
                        <div class="w50" style="width: 250px">
                            <select class="input" name="dev">
                                <option value="">全部</option>
                                <option {{ request('dev')=='pc'?"selected":"" }} value="pc">pc</option>
                                <option {{ request('dev')=='mobile'?"selected":"" }} value="mobile">mobile</option>
                            </select>
                        </div>
                        <div class="label">
                            <label>METHOD：</label>
                        </div>
                        <div class="w50" style="width: 250px">
                            <select class="input" name="m">
                                <option value="">全部</option>
                                <option {{ request('m')=='GET'?"selected":"" }} value="GET">GET</option>
                                <option {{ request('m')=='POST'?"selected":"" }} value="POST">POST</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="label">
                            <label>開始日期：</label>
                        </div>
                        <div class="w50" style="max-width: 200px;">
                            <input type="text" class="input" value="{{ request('start_time') }}" name="start_time" id="start_time" readonly />
                        </div>
                        <div class="label">
                            <label>結束日期：</label>
                        </div>
                        <div class="w50" style="max-width: 200px;">
                            <input type="text" class="input" value="{{ request('stop_time') }}" name="stop_time" id="stop_time" readonly>
                        </div>
                        <button class="button bg-main margin-left" type="submit">篩選</button>

                        {{--<div class="button-group radio float-right isGoogle">
                            <label class="button active" data-type="0">
                                <span class="icon icon-check"></span>
                                全部
                            </label>
                            <label class="button" data-type="1">
                                <span class="icon icon-check"></span>
                                Google
                            </label>
                            <label class="button" data-type="2">
                                <span class="icon icon-check"></span>
                                非Google
                            </label>
                            <label class="button" data-type="3">
                                <span class="icon icon-check"></span>
                                只看下單頁
                            </label>
                       </div>--}}
                    </div>
                </form>
            </div>
        </div>
	<div>
        <div style="text-align: right;">IP數量:{{ $data['ip_count'] }}&nbsp;訪問數:{{ $data['total'] }} &nbsp;|&nbsp; PC IP數:<span class="pc-ip-count">{{ $data['pc_ip_count'] }}</span>&nbsp;訪問數:<span class="pc-count">{{ $data['pc_count'] }}</span> &nbsp;|&nbsp; m版 IP數:<span class="m-ip-count">{{ $data['mobile_ip_count'] }}</span>&nbsp; 訪問數:<span class="m-count">{{ $data['mobile_count'] }}</span></div>

    </div>
   </div>
    <table class="table table-hover text-center">
        <tr>
            <th width="2">時間</th>
            <th width="2">IP位址</th>
            <th width="4">URL</th>
            <th width="1">方式</th>
            <th width="4">來源</th>
            <th width="6">載具</th>
            <th width="2">設備</th>
        </tr>

        @foreach($access as $item)
        <tr class="tr" data-id="{$item->id}">
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->ip }}</td>
            <td>{{ $item->url }}</td>
            <td>{{ $item->method }}</td>
            <td>{{ $item->referer }}</td>
            <td>{{ $item->user_agent }}</td>
            <td>{{ $item->device }}</td>
        </tr>
        @endforeach

    </table>
</div>
<div>
    {{ $access->appends(request()->toArray())->links() }}
</div>
<script src="{{ asset('static/js/jquery.cookie.js') }}"></script>
<script src="{{ asset('static/admin/datepicker/foundation-datepicker.js') }}"></script>
<script src="{{ asset('static/admin/datepicker/locales/foundation-datepicker.zh-CN.js') }}"></script>
<script type="text/javascript">

$(function() {

    $('#start_time').fdatepicker({
        format: 'yyyy-mm-dd hh:ii',
        pickTime: true
    });
    $('#stop_time').fdatepicker({
        format: 'yyyy-mm-dd hh:ii',
        pickTime: true
    });
    /*$("#start_time").datetimepicker({
        showSecond: true,
        dateFormat: 'yy-mm-dd',
        timeFormat: 'hh:mm:ss'
    });
    $("#stop_time").datetimepicker({
        showSecond: true,
        dateFormat: 'yy-mm-dd',
        timeFormat: 'hh:mm:ss'
    });*/

    var canvasBox_show = $.cookie('canvasBox_show');

    if(canvasBox_show == 1){
        $('.canvasBox').show();
    }else{
        $('.canvasBox').hide();
    }

    var canvasBox_show2 = $.cookie('canvasBox_show2');
    if(canvasBox_show2 == 1){
        $('.canvasBox2').show();
    }else{
        $('.canvasBox2').hide();
    }

    $('.showcanvas').click(function(){

        if(!$('.canvasBox').is(":visible")){
            $.cookie('canvasBox_show',1);
        }else{
            $.cookie('canvasBox_show',0);
        }
        $('.canvasBox').toggle(300);

    });

    $('.showcanvas2').click(function(){

        if(!$('.canvasBox2').is(":visible")){
            $.cookie('canvasBox_show2',1);
        }else{
            $.cookie('canvasBox_show2',0);
        }
        $('.canvasBox2').toggle(300);

    });

    $('.isGoogle').click(function(){
        var type = $(this).find('.active').attr('data-type');
        if(type == 0){
            $('.tr').show();
        }else if(type == 1){
            $.each($('.tr'), function(i, tr){
                if($(tr).find('.google').length > 0){
                    $(tr).show();
                }else{
                    $(tr).hide();
                }
            });
        }else if(type == 2){
            $.each($('tr'), function(i, tr){
                if($(tr).find('.google').length > 0){
                    $(tr).hide();
                }else{
                    $(tr).show();
                }
            });
        }else{
            $.each($('.tr'), function(i, tr){
                if($(tr).find('.shopping').length > 0){
                    $(tr).show();
                }else{
                    $(tr).hide();
                }
            });
        }
    });



});
</script>

<script type="text/javascript" src="{{ asset('static/admin/js/chart.js') }}"></script>
<script type="text/javascript">
    var month_ctx = $("#month_ctx").get(0).getContext("2d");
    var monthlist = "{{implode(',' , array_keys($month))}}";
    var monthdata = "{{implode(',', array_values($month))}}";

    var data = {
        labels: monthlist.split(","),
        datasets: [
            {
                fillColor: "#8fd5f1",
                strokeColor: "#eee",
                pointColor: "#0ae",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "#eee",
                data: monthdata.split(",")
            },

        ]
    };
    var monthChart = new Chart(month_ctx).Line(data);

    var url_ctx = $("#url_ctx").get(0).getContext("2d");
    var monthlist = "{{implode(',' , array_keys($url))}}";
    var monthdata = "{{implode(',', array_values($url))}}";
    var data = {
        labels: monthlist.split(","),
        datasets: [
        {
            fillColor: "#9feabb",
            strokeColor: "#eee",
            pointColor: "#2c7",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "#eee",
            data: monthdata.split(",")
        }
        ]
    };
    var monthChart = new Chart(url_ctx).Line(data);

    /*$('.canvasBox').toggle();*/

</script>

