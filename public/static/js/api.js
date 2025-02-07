var filter_key = 'filter';
var filter_count_key = 'filter_count';
var area_key = 'area';



function getGoods(data){

    $.ajax({
        url: '/api/goods',
        type: 'GET',
        data : data,
        dataType: 'html',
        beforeSend:function () {
            if(typeof beforeCallback == 'function'){
                beforeCallback();
            }
        },
        success: function (result) {
            if(typeof successCallback == 'function'){
                successCallback(result)
            }
        },
        error: function (XMLHttpRequest) {
            if(typeof errorCallback == 'function'){
                errorCallback(XMLHttpRequest)
            }
        },
        complete: function (XMLHttpRequest) {
            if(typeof completeCallback == 'function'){
                completeCallback(XMLHttpRequest);
            }

        },
    })

}

var $grid = $('.goods-section');
var gutter = window.matchMedia('(max-width: 768px)').matches ? 12 : 50;
/*$grid.masonry({
    itemSelector: '.goods',           // class 选择器
    columnWidth: $('.goods-section').find('.goods .cover').width(), // 一列的宽度 Integer
    isAnimated: false,                // 使用jquery的布局变化 Boolean
    gutter: gutter,              // 列的间隙 Integer
    isResizableL: false,              // 是否可调整大小 Boolean
    transitionDuration: 0,
});*/

var current_page = 0;
var last_page = 1;
var is_load = false;
var random = false;

function getGoods2(filter = false, is_append = true, data = {}, reset_page = false) {
    if (!is_load) {

        if (reset_page == true) {
            current_page = 0;
        }
        if (!is_append) {
            $('.goods-section').empty();
        }

        if (current_page < last_page) {
            if (filter) {
                var filter_data = localStorage.getItem(filter_key);
                if (filter_data) {
                    filter_data = JSON.parse(filter_data);
                    data = Object.assign(data, filter_data);
                    if(random){
                        data.random = 1;
                    }
                }
            }

            is_load = true;
            $('#goods-loading').show();
            $('#goods-complete').hide();
            $.ajax({
                url: '/api/goods2?page=' + parseInt(current_page + 1),
                type: 'GET',
                data: data,
                dataType: 'json',
                success: function (result) {
                    current_page = result.current_page;
                    last_page = result.last_page;


                    // 使用 Masonry v4.x 添加新的项并更新布局
                    var $newItems = $(result.render);
                    /*$grid.masonry('appended', $newItems);
                    if (is_append) {
                        $grid.append($newItems).masonry('appended', $newItems);
                    } else {
                        $grid.html($newItems).masonry('reloadItems').masonry('layout');
                    }*/
                    if(is_append){
                        $grid.append($newItems)
                    }else{
                        $grid.html($newItems)
                    }



                    $newItems.imagesLoaded(function () {
                        $('.goods-section .hide').removeClass('hide');
                        is_load = false;
                        $('#goods-loading').hide();


                        // Masonry v4.x 需要使用 reloadItems 和 layout 来更新
                        //$grid.masonry('reloadItems');
                        //$grid.masonry('layout');



                        if (current_page == last_page) {
                            //$('#goods-complete').show();
                            current_page = 0;
                            random = true;
                            if(result.total < 20){
                                getGoods2();
                            }
                        }

                        setTimeout(function () {
                            lazyload()

                        },100)



                    });



                },
                error: function (XMLHttpRequest) {
                    // 错误处理逻辑
                },
                complete: function (XMLHttpRequest) {
                    // 完成后的操作
                },
            });
        }
    }
}



$(document).ready(function(){
    var is_product = location.pathname == '/product'?true:false;


    if(typeof is_disable_scroll == 'undefined' || !is_disable_scroll){
        $(window).scroll(function(){

            var scrollTop = $(this).scrollTop(); //获取当前页面滚动距离
            var scrollHeight = $(document).height(); //获取页面总高度
            var windowHeight = $(this).height(); //获取当前窗口高度
            if(scrollTop + windowHeight >= scrollHeight - 400){ //判断是否到达页面底部
                if(is_product){
                    getGoods2(true,true);
                }else{
                    getGoods2(false,true);
                }
            }
        });

    }

});




$('#filter .reset').click(function () {
    localStorage.removeItem(filter_key);
    localStorage.removeItem(filter_count_key)
    $('#partone').find('.item-count').text(0);
    $("[data-equ]").prop("checked", false);
    $('#fit-city option:first').attr('selected',true)
    $('#fit-county option:first').attr('selected',true)
})

$('#filter .conform').click(function () {
    var age = $('input[name="age"]').val();
    var price = $('input[name="price"]').val();
    var tab = $('input[name="tabs"]:checked').val()
    var western = $('input[name="western"]:checked').val()
    var city = $('#fit-city').val();
    var county = $('#fit-county').val();
    var filter = {};
    var filter_count = 0;
    $("[data-equ]").each(function(){
        var equ = $(this).attr('data-equ');
        var val = $(this).val();

        if($(this).prop('checked')){

            if(filter){
                if(filter[equ]){
                    if (!filter[equ].includes(val)){
                        filter[equ].push(val)
                    }
                }else{
                    filter[equ] = [val];
                }
            }else{
                var new_data = {};
                new_data[equ] = [val];
                filter = new_data;
            }
            filter_count++;

        }
    });

    filter['age'] = age;
    filter['price'] = price;
    filter['tab'] = tab;
    filter['city'] = city;
    filter['county'] = county;
    localStorage.setItem(filter_key,JSON.stringify(filter));
    localStorage.setItem(filter_count_key,filter_count);
    window.location.href="/product";
});

function addFilterFind(equ,id){
    var filter = {};
    filter[equ] = id;
    localStorage.setItem(filter_key,JSON.stringify(filter));
}

function deleteFilterFind(equ,id){
    var filter = localStorage.getItem(filter_key);
    if(filter){
        filter = JSON.parse(filter);
        if(filter[equ]){
            if (filter[equ].includes(id)){
                delete filter[equ].splice(filter[equ].indexOf(id),1);
                $('[data-equ="'+equ+'"][value="'+id+'"]').prop("checked", false);
            }else{
                delete filter[equ];
            }

            localStorage.setItem(filter_key,JSON.stringify(filter));
            var filter_count = localStorage.getItem(filter_count_key)?localStorage.getItem(filter_count_key):0;
            filter_count = filter_count<1?0:filter_count-1;
            localStorage.setItem(filter_count_key,filter_count)
            $('#partone').find('.item-count').text(filter_count);
        }
    }

}

function CalibrationQuantity(){
    var filter = localStorage.getItem(filter_key);
    var count = 0;
    if(filter){
        filter = JSON.parse(filter);
        //delete filter['tab'];
        //delete filter['city'];
        //delete filter['county'];
        //delete filter['age'];
        //delete filter['height'];
        //delete filter['price'];
        //delete filter['tab'];
        if(filter['city'] == 0){
            delete filter['city'];
        }
        if(filter['county'] == 0){
            delete filter['county'];
        }
        $.each(filter,function (index,value) {

            if(typeof value == 'object'){
                count +=value.length;
            }else{
                count++;
            }
        });
    }

    localStorage.setItem(filter_count_key,count);
}

var selected_type = $.cookie('selected_type')?$.cookie('selected_type'):1;
if(selected_type == 2){
    var factor_html = '<p class="factor" id="factor-tab">定點</p>';
}else{
    var factor_html = '<p class="factor" id="factor-tab">外送</p>';
}

var city_id = 0;
var county_id = 0;
var filterInitializeCallback = function (elem,equ,id) {
    var tip = elem.attr('data-tips');
    factor_html += '<p class="factor" data-equ="'+equ+'" data-id="'+id+'">'+tip+'\n' +
        '                <svg t="1690789204748" class="factorclose" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="9156" width="200" height="200"><path d="M512 102.4a409.6 409.6 0 1 0 409.6 409.6 409.6 409.6 0 0 0-409.6-409.6z m181.248 518.144a51.2 51.2 0 0 1-72.704 72.704L512 584.192l-108.544 109.056a51.2 51.2 0 0 1-72.704-72.704L439.808 512 330.752 403.456a51.2 51.2 0 0 1 72.704-72.704L512 439.808l108.544-109.056a51.2 51.2 0 0 1 72.704 72.704L584.192 512z" fill="" p-id="9157"></path></svg>\n' +
        '            </p>';
}
var filterInitializeCallback2 = function (tip,equ) {
    factor_html += '<p class="factor" data-equ="'+equ+'">'+tip+'\n' +
        '                <svg t="1690789204748" class="factorclose" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="9156" width="200" height="200"><path d="M512 102.4a409.6 409.6 0 1 0 409.6 409.6 409.6 409.6 0 0 0-409.6-409.6z m181.248 518.144a51.2 51.2 0 0 1-72.704 72.704L512 584.192l-108.544 109.056a51.2 51.2 0 0 1-72.704-72.704L439.808 512 330.752 403.456a51.2 51.2 0 0 1 72.704-72.704L512 439.808l108.544-109.056a51.2 51.2 0 0 1 72.704 72.704L584.192 512z" fill="" p-id="9157"></path></svg>\n' +
        '            </p>';
}



if(location.pathname == '/' || location.pathname == '/product'){
    initialize()
}
function initialize(){
    var quick = getQueryString('quick');
    if(quick){
        addFilterFind('quick',[quick])
    }

    var selected_type = $.cookie('selected_type')?$.cookie('selected_type'):1;
    $('input[name="tabs2"][value="'+selected_type+'"]').prop('checked',true)

    var filter = localStorage.getItem(filter_key);

    if(filter){
        filter = JSON.parse(filter);

        $.each(filter,function(index,element){

            if(typeof element == 'object'){
                $.each(element,function(l,v){
                    var elem = $("[data-equ='"+index+"'][value='"+v+"']");
                    elem.prop("checked", true)
                    if(typeof filterInitializeCallback == 'function'){

                        filterInitializeCallback(elem,index,v)
                    }
                });
            }else{
                if(index == 'tab'){
                    $.cookie('selected_type',element);
                    $('input[name="tabs"][value="'+element+'"]').prop('checked',true)
                }else if(index == 'city'){
                    city_id = element
                }else if(index == 'county'){
                    county_id = element;
                }else{

                    $('.'+index+'-range-slider').jRange('setValue', element);

                    if(index == 'age'){
                        filterInitializeCallback2('茶溫: '+element.replace(',','~'),index);
                    }else{
                        filterInitializeCallback2('預算: '+element.replace(',','~'),index);
                    }
                }

            }


        })
    }

    CalibrationQuantity();

    var filter_count = localStorage.getItem(filter_count_key);
    $('#partone').find('.item-count').text(filter_count?filter_count:0);


    var selected_type = $.cookie('selected_type')?$.cookie('selected_type'):1;
    if(selected_type){
        $('input[name="tabs"][value="'+selected_type+'"]').prop('checked',true)
    }
    if(selected_type == 2){
        //$('.county-box').show();
        updatePriceRange(2000,80000)
    }else {
        //$('.county-box').hide();
        updatePriceRange(6000,80000)
    }


}


$('.factorbox').html(factor_html);
$('body').on('click','.factor .factorclose',function () {
    var elem = $(this).parent();
    var equ = elem.attr('data-equ');
    var id = elem.attr('data-id');
    deleteFilterFind(equ,id)
    elem.remove();
    getGoods2(true,false,{},true);

});


function getFilterGoods(){
    var filter = localStorage.getItem(filter_key);
    if(filter){
        filter = JSON.parse(filter);
        getGoods(filter);
    }else{
        getGoods();
    }
}



/**
 * 地区
 * @type {string}
 */
let areas = localStorage.getItem(area_key);
if(!areas){
    $.ajax({
        url: '/api/area',
        type: 'GET',
        dataType: 'json',
        success: function (result) {
            localStorage.setItem(area_key,JSON.stringify(result));
            setArea(result);

        }
    })
}
if(areas){
    setArea(JSON.parse(areas));
}

function setArea(data){
    $.area({
        data:data,
        city:{
            element:'#fil-city',
            default:0,
            change:function (city) {
                getGoods2(false,false,{'city':city},true)
            },
            init:function (id,text) {

            }
        },
        county:{
            element:'#fil-county',
            default:0,
            change:function (city,county) {
                getGoods2(false,false,{'city':city,'county':county},true)
            }
        },
    })

    $.area({
        data:data,
        city:{
            element:'#fit-city',
            default:city_id,
            init:function (id,text) {
                if (id > 0){
                    filterInitializeCallback2(text,'city');
                    $('.factorbox').html(factor_html);
                }

            }
        },
        county:{
            element:'#fit-county',
            default:county_id,
            change:function (city,county) {

            },
            init:function (id,text) {
                if(id > 0){
                    filterInitializeCallback2(text,'county');
                    $('.factorbox').html(factor_html);
                }

            }
        },
    })
}

function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return decodeURI(r[2]);
    return null;
}



/**
 * 下拉刷新
 */
$(document).ready(function(){
    var is_product = location.pathname == '/product'?true:false;


        if(typeof is_disable_scroll == 'undefined' || !is_disable_scroll){
            $(window).scroll(function(){

                var scrollTop = $(this).scrollTop()+400; //获取当前页面滚动距离
                var scrollHeight = $(document).height(); //获取页面总高度
                var windowHeight = $(this).height(); //获取当前窗口高度

                if(scrollTop + windowHeight >= scrollHeight - 1000){ //判断是否到达页面底部
                    if(is_product){
                        getGoods2(true,true);
                    }else{
                        getGoods2(false,true);
                    }
                }
            });

        }

});



/**
 * 定点外送切换
 */
$('#radio-1,#radio-2').click(function () {
    var tab = $(this).val();
    var origin = $.cookie('selected_type')
    if(tab != origin){
        getGoods2(false,false,{tab:tab},true);
        $.cookie('selected_type',tab);
        addFilterFind('tab',tab)
        $('input[name="tabs"][value="'+tab+'"]').prop('checked',true)
    }

/*    if(tab == 2){
        $('.county-box').show();
    }else {
        $('.county-box').hide();
    }*/


});

/*$('#fit-tabs-1,#fit-tabs-2').click(function () {
    var tab = $(this).val();
    if(tab == 2){
        $('#filter .county-box').show();
    }else {
        $('#filter .county-box').hide();
    }
})*/


/**
 * 建立筛选器点击回调事件
 * @type {string}
 */
var filter_group_count = localStorage.getItem(filter_count_key);
filter_group_count = parseInt(filter_group_count?filter_group_count:0);
$('#filter .group input[data-equ]').click(function () {
    if($(this).prop('checked')){
        filter_group_count++
    }else{
        filter_group_count--
    }
    if(typeof EquClickCallback == 'function'){
        EquClickCallback(filter_group_count);
    }

})

function lazyload() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const img = entry.target;

            if (entry.isIntersecting) {
                // 图片进入视口，开始加载
                if(img.dataset.src){
                    img.src = img.dataset.src; // 将真正的图片地址赋值
                }
                img.removeAttribute('data-src')
                //img.style.visibility = 'visible'; // 显示图片
                observer.unobserve(img);//停止监察
            } else {
                // 图片离开视口，隐藏图片
                //img.style.visibility = 'hidden'; // 隐藏图片


            }
        });
    }, {
        root: null, // 监听整个视口
        rootMargin: '400px 0px', // 提前 100px 加载图片
        threshold: 0 // 图片至少 10% 进入视口时触发加载
    });

    // 遍历所有带有 lazyload 属性的图片
    document.querySelectorAll('img[data-lazyload]').forEach(function(img) {
        // 初始化时设置占位符样式
        //img.style.visibility = 'hidden'; // 隐藏图片
        observer.observe(img); // 观察图片
        img.removeAttribute('data-lazyload'); // 移除 data-lazyload 属性
    });

    document.querySelectorAll('.g-video').forEach(function(video) {

        if(video.dataset.src){
            video.src = video.dataset.src; // 将真正的图片地址赋值
        }
    });
}




