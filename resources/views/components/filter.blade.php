<link rel="stylesheet" href="{{ asset('static/jRange/jquery.range.css') }}">

<div class="filter" id="filter">

    <div class="partone" id="partone">
        <input type="checkbox" id="search">
        <label for="search" class="search">
            <div class="searchbox">
                <div class="searchopen">
                    <span class="item-count">0</span>
                    <span class="searchtext">進階搜尋</span>
                </div>
                <div class="searchcancel">
                    <svg t="1690769505475" class="closeicon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="9007" width="200" height="200"><path d="M621.714286 512 1002.057143 131.657143c29.257143-29.257143 29.257143-80.457143 0-109.714286-29.257143-29.257143-80.457143-29.257143-109.714286 0L512 402.285714 131.657143 21.942857c-29.257143-29.257143-80.457143-29.257143-109.714286 0-29.257143 29.257143-29.257143 80.457143 0 109.714286L402.285714 512 21.942857 892.342857c-29.257143 29.257143-29.257143 80.457143 0 109.714286 29.257143 29.257143 80.457143 29.257143 109.714286 0L512 621.714286l380.342857 380.342857c29.257143 29.257143 80.457143 29.257143 109.714286 0 29.257143-29.257143 29.257143-80.457143 0-109.714286L621.714286 512z" p-id="9008"></path></svg>
                    <span class="searchtext">取消搜尋</span>
                </div>
            </div>
        </label>
    </div>
    <div class="parttwo-show parttwo-hide" id="parttwo-show">
        <div class="choose-sec" id="choose-sec">
            <p class="title">喝茶方式</p>
            <div class="modebox" >
                <div class="tabs">
                    <input type="radio" id="fit-tabs-1" name="tabs" value="1">
                    <label class="tab" for="fit-tabs-1">外送</label>
                    <input type="radio" id="fit-tabs-2" name="tabs" value="2">
                    <label class="tab" for="fit-tabs-2">定點</label>
                    <span class="glider"></span>
                </div>
            </div>
        </div>
        <div class="choose-sec" id="choose-sec">
            <p class="title">地區</p>
            <div class="citybox">
                <div class="city">
                    <div class="arrowicon">
                        <input type="checkbox" id="city" name="city">
                        <label class="area" for="city">
                            {{--<p class="itemname">台北</p>--}}
                            <select name="city" id="fit-city" data-abolish="true"></select>
                            <div class="arrow"></div>
                        </label>
                    </div>
                </div>
                <div class="city">
                    <div class="arrowicon">
                        <input type="checkbox" id="area" name="area">
                        <label class="area" for="area">
                            {{--<p class="itemname">萬華區</p>--}}
                            <select name="county" id="fit-county" data-abolish="true"></select>
                            <div class="arrow"></div>
                        </label>
                    </div>
            </div>
        </div>
        </div>
        <div class="choose-sec" id="choose-sec">
            <p class="title">類型</p>
            <div class="bodychoose">
                @foreach($quick as $item)
                <div class="group"><input data-equ="quick" data-tips="{{ $item->text }}" type="checkbox" name="quick[]" value="{{ $item->id }}" id="quick-{{ $item->id }}"><label class="body" for="quick-{{ $item->id }}"><p class="bodyitem">{{ $item->text }}</p></label></div>
                @endforeach
            </div>
        </div>
        <div class="choose-sec" id="choose-sec">
            <p class="title">茶溫<span class="eng">（Age）</span></p>
            <div class="sliderbar">
                <input type="hidden" class="age-range-slider" name="age" value="20,33"/>
            </div>
        </div>
        <div class="choose-sec" id="choose-sec">
            <p class="title">預算<span class="eng">（NT$）</span></p>
            <div class="sliderbar">
                <input type="hidden" class="price-range-slider" name="price" value="3000,18000"/>
            </div>
        </div>
        <div class="choose-sec" id="choose-sec">
            <p class="title">茶杯<span class="eng">（Cup）</span></p>
            <div class="cupchoose">
                <div class="group"><input data-equ="cup" data-tips="A杯" type="checkbox" name="cup[]" value="A" id="cup-A"><label class="cup" for="cup-A"><p class="cupitem">A</p></label></div>
                <div class="group"><input data-equ="cup" data-tips="B杯" type="checkbox" name="cup[]" value="B" id="cup-B"><label class="cup" for="cup-B"><p class="cupitem">B</p></label></div>
                <div class="group"><input data-equ="cup" data-tips="C杯" type="checkbox" name="cup[]" value="C" id="cup-C"><label class="cup" for="cup-C"><p class="cupitem">C</p></label></div>
                <div class="group"><input data-equ="cup" data-tips="D杯" type="checkbox" name="cup[]" value="D" id="cup-D"><label class="cup" for="cup-D"><p class="cupitem">D</p></label></div>
                <div class="group"><input data-equ="cup" data-tips="E杯" type="checkbox" name="cup[]" value="E" id="cup-E"><label class="cup" for="cup-E"><p class="cupitem">E</p></label></div>
                <div class="group"><input data-equ="cup" data-tips="F杯" type="checkbox" name="cup[]" value="F" id="cup-F"><label class="cup" for="cup-F"><p class="cupitem">F</p></label></div>
                <div class="group"><input data-equ="cup" data-tips="G+杯" type="checkbox" name="cup[]" value="G" id="cup-G"><label class="cup" for="cup-G"><p class="cupitem">G+</p></label></div>
            </div>
        </div>
        <div class="choose-sec" id="choose-sec">
            <p class="title">身高<span class="eng">（cm）</span></p>
            <div class="bodychoose">
                <div class="group"><input data-equ="height" data-tips="160以下" type="checkbox" name="height[]" value="1" id="height-1"><label class="body" for="height-1"><p class="bodyitem">160以下</p></label></div>
                <div class="group"><input data-equ="height" data-tips="160~170" type="checkbox" name="height[]" value="2" id="height-2"><label class="body" for="height-2"><p class="bodyitem">160~170</p></label></div>
                <div class="group"><input data-equ="height" data-tips="170以上" type="checkbox" name="height[]" value="3" id="height-3"><label class="body" for="height-3"><p class="bodyitem">170以上</p></label></div>
            </div>
        </div>
        <div class="choose-sec" id="choose-sec">
            <p class="title">體重<span class="eng">（kg）</span></p>
            <div class="bodychoose">
                <div class="group"><input data-equ="weight" data-tips="50kg以下" type="checkbox" name="weight[]" value="1" id="weight-1"><label class="body" for="weight-1">50以下</label></div>
                <div class="group"><input data-equ="weight" data-tips="50kg~60kg" type="checkbox" name="weight[]" value="2" id="weight-2"><label class="body" for="weight-2">50~60</label></div>
                <div class="group"><input data-equ="weight" data-tips="60kg以上" type="checkbox" name="weight[]" value="3" id="weight-3"><label class="body" for="weight-3">60以上</label></div>
            </div>
        </div>
        <div class="choose-sec" id="choose-sec">
            <p class="title">茶籍</p>
            <div class="comechoose">
                @foreach($birthplace as $item)
                    <div class="group">
                        <input type="checkbox" data-equ="birthplace" data-tips="{{ $item->name }}" name="birthplace[]" value="{{ $item->id }}" id="birthplace-{{ $item->id }}">
                        <label class="come" for="birthplace-{{ $item->id }}">
                            <div class="flag"><img src="{{ asset_upload($item->icon) }}" alt="{{ $item->name }}"></div>
                            <p class="flagname">{{ $item->name }}</p>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        @foreach($category as $item)
        <div class="choose-sec" id="choose-sec">
            <p class="title">{{ $item->name }}</p>
            <div class="outlookchoose">
                @foreach($item->sub as $sub)
                    <div class="group">
                        <input type="checkbox" data-equ="category" data-tips="{{ $sub->name }}" name="category[]" value="{{ $sub->id }}" id="category-{{ $sub->id }}">
                        <label class="outlook" for="category-{{ $sub->id }}">{{ $sub->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="choose-sec" id="choose-sec">
            <p class="title">可配合</p>
            <div class="coopchoose">
                @foreach($serve as $item)
                    <div class="group">
                        <input type="checkbox" data-equ="serve" name="serve[]" data-tips="{{ $item->name }}" value="{{ $item->id }}" id="serve-{{ $item->id }}">
                        <label class="coop" for="serve-{{ $item->id }}">
                            <img src="{{ asset_upload($item->icon) }}" class="coopicon" alt="{{ $item->name }}">
                            <span>{{ $item->name }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="buttonbox">
            <button class="reset">
                <span>全部清除</span>
            </button>
            <button class="conform">
                <span class="result">查看挑選 200+ 結果</span>
            </button>
        </div>
    </div>

</div>
<script src="{{ asset('static/jRange/jquery.range-min.js') }}"></script>
<script>
    var age_pointer;
    $('.age-range-slider').jRange({
        from: 18,
        to: 35,
        step: 1,
        scale: [],
        format: function (value,pointer) {
            age_pointer = pointer;
            return pointer == 'high' && value>=this.to ? value + '+':value;
        },
        width: 300,
        showLabels: true,
        isRange : true,
        onstatechange:function (value) {
            var gpa = 4;
            var split = value.split(',');
            var start = parseInt(split[0]);
            var end = parseInt(split[1]);
            var dis = end - start;
            if(dis<=gpa){
                if(age_pointer == 'high'){
                    var high_ef = end - gpa;
                    if(start <= 18 && end - high_ef <= gpa){
                        end = 18+gpa;
                    }
                    $('.age-range-slider').jRange('setValue', high_ef+','+end);
                }else{

                    var low_ef = end + (start + gpa - end);
                    $('.age-range-slider').jRange('setValue', start+','+low_ef);
                }
                return false;
            }
        },
    });
    $('.age-range-slider').jRange('setValue', '18,26');


    var price_pointer;
    $('.price-range-slider').jRange({
        from: 2500,
        to: 20000,
        step: 500,
        scale: [],
        format: function (value,pointer) {
            price_pointer = pointer;
            return pointer == 'high' && value>=this.to ? value + '+':value;
        },
        width: 300,
        showLabels: true,
        isRange : true,
        onstatechange:function (value) {
            var gpa = 5000;
            var split = value.split(',');
            var start = parseInt(split[0]);
            var end = parseInt(split[1]);
            var dis = end - start;
            if(dis<=gpa){
                if(price_pointer == 'high'){
                    var high_ef = end - gpa;
                    if(start <= 2500 && end - high_ef <= gpa){
                        end = 2500+gpa;
                    }
                    $('.price-range-slider').jRange('setValue', high_ef+','+end);
                }else{

                    var low_ef = end + (start + gpa - end);
                    $('.price-range-slider').jRange('setValue', start+','+low_ef);
                }
                return false;
            }
        },
    });

</script>
