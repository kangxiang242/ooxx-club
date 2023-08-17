<div class="btnbox btnbox-article" data-btn-scroll id="btn_peg">
    <a href="{{ app('cache.config')->get('line_url') }}" target="_blank" class="button ripple" data-inquire="" data-inquire-type="line" data-inquire-position="top">
        <div class="btn-bg uwu"></div>
        <div class="btn-bg"></div>
        <div class="text shake1">
            <i class="iconfont ">&#xebf5;</i>
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
