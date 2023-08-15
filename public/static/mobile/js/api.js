function orderStore(){
    var name = $("input[name='name']").val();
    var phone = $("input[name='phone']").val();
    var email = $("input[name='email']").val();
    var city = $("select[name='city']").val();
    var county = $("select[name='county']").val();
    var street = $("select[name='street']").val();
    var address = $("input[name='address']").val();
    var product_ids = $('.cart-action-num').val();
    var order_type = $("select[name='order_type']").val();
    var store_id = $("input[name='store_id']:checked").val();

    if(!name){
        $('input[name="name"]').focus();
        layer.msg('請填寫收貨人姓名');
        return false;
    }
    if(!phone){
        $('input[name="phone"]').focus();
        layer.msg('請填寫收貨電話');
        return false;
    }
    if(!(/^09\d{8}$/.test(phone))){
        $('input[name="phone"]').focus();
        layer.msg('電話格式錯誤');
        return false;
    }

    if(!email){

        $('input[name="email"]').focus();
        layer.msg('請填寫您的郵箱');
        return false;
    }

    if(email.search(/^([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+\.(?:com|cn|tw|info|net)$/) == -1){
        $('input[name="email"]').focus();
        layer.msg('請填寫正確的郵箱');
        return false;
    }

    if(!city){

        layer.msg('請選擇縣市');
        return false;
    }

    if(!county){
        layer.msg('請選擇區域');
        return false;
    }
    if(!street){
        layer.msg('請選擇路段');
        return false;
    }
    if(order_type > 0){

        if(!store_id){
            layer.msg('請選擇便利店');
            return false;
        }

    }else{
        if(!address){
            $('input[name="address"]').focus();
            layer.msg('請填寫詳細地址');
            return false;
        }
    }
    if(!product_ids){
        /*layer.msg('商品數據有誤，請刷新本頁面或者重新加入購物車！');
        return false;*/
    }

    addLoadingActionBtn('.submit');

    $.ajax({
        type: $('#order-form').attr('method'),
        url: $('#order-form').attr('action'),
        data: $('#order-form').serialize(),
        dataType: "json",
        success: function(data){
            window.location.href = data.redirect;
        },
        error:function(jqXHR, textStatus, errorThrown){
            var response = JSON.parse(jqXHR.responseText)
            xie.error("提交失败",response.message);
            closeLoadingActionBtn('.form-btn');
        }
    });
    return false;
}

function orderCheck(){

    var email = $("#check-popup").find("input[name='email']").val();
    var phone = $("#check-popup").find("input[name='phone']").val();

    if(!phone){
        $("#check-popup").find("input[name='phone']").focus();
        layer.msg('請填寫電話');
        return false;
    }
    if(!(/^09\d{8}$/.test(phone))){
        $("#check-popup").find("input[name='phone']").focus();
        layer.msg('電話格式錯誤');
        return false;
    }
    if(!email){
        $("#check-popup").find("input[name='email']").focus();
        layer.msg('請填寫郵箱');
        return false;
    }
    if(email.search(/^([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+\.(?:com|cn|tw|info|net)$/) == -1){
        $("#check-popup").find("input[name='email']").focus();
        layer.msg('請填寫正確的郵箱');
        return false;
    }

    addLoadingActionBtn('.form-btn');

    $.ajax({
        type: $('#check-form').attr('method'),
        url: $('#check-form').attr('action'),
        data: $('#check-form').serialize(),
        dataType: "json",
        success: function(data){
            if(data.code == 200){
                xie.success(data.message,'正在為您跳轉中,請稍後...');
                window.location.href = data.jump;
            }else{
                xie.success("訂單查詢失敗",'正在為您跳轉中,請稍後...',data.message);
            }
            closeLoadingActionBtn('.form-btn');
        },
        error:function(jqXHR, textStatus, errorThrown){
            var response = JSON.parse(jqXHR.responseText)
            xie.error("查詢失敗",response.message);
            closeLoadingActionBtn('.form-btn');
        }
    });
    return false;

}

function messageStore(){
    var name = $("#message-popup").find("input[name='name").val();
    var phone = $("#message-popup").find("input[name='phone']").val();
    var email = $("#message-popup").find("input[name='email']").val();
    var content = $("#message-popup").find("textarea[name='content']").val();
    if(!name){
        $("#message-popup").find('input[name="name"]').focus();
        layer.msg('請填寫您的昵稱');
        return false;
    }
    if(!phone){
        $("#message-popup").find("input[name='phone']").focus();
        layer.msg('請填寫您的電話');
        return false;
    }
    if(!(/^09\d{8}$/.test(phone))){
        $("#message-popup").find("input[name='phone']").focus();
        layer.msg('電話格式錯誤');
        return false;
    }
    if(!email){
        $("#message-popup").find("input[name='email']").focus();
        layer.msg('請填寫郵箱');
        return false;
    }
    if(email.search(/^([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|_|.]?)*[a-zA-Z0-9]+\.(?:com|cn|tw|info|net)$/) == -1){
        $("#message-popup").find("input[name='email']").focus();
        layer.msg('請填寫正確的郵箱');
        return false;
    }

    if(!content){
        $("#message-popup").find("textarea[name='content']").focus()
        layer.msg('請填寫您的意見或建議');
        return false;
    }

    addLoadingActionBtn('.form-btn');

    $.ajax({
        type: $('#message-form').attr('method'),
        url: $('#message-form').attr('action'),
        data: $('#message-form').serialize(),
        dataType: "json",
        success: function(data){
            if (data.code == 200){
                xie.success(data.msg,data.sub_msg);
                $("#message-popup").find("input[name='name").val('').removeClass('have');
                $("#message-popup").find("input[name='phone']").val('').removeClass('have');
                $("#message-popup").find("input[name='email']").val('').removeClass('have');
                $("#message-popup").find("textarea[name='content']").val('').removeClass('have');
                closeMessage();

            }else{
                xie.error(data.msg,data.sub_msg);
            }
            closeLoadingActionBtn('.form-btn');
        },
        error:function(jqXHR, textStatus, errorThrown){
            var response = JSON.parse(jqXHR.responseText)
            xie.error("留言失敗",response.message);
            closeLoadingActionBtn('.form-btn');
        }
    });
    return false;
}

function warnInfo(elem,text){
    var left = parseInt(elem.parent().css('width'))+10;
    elem.css('color',"rgb(239, 60, 60)");
    elem.text(text);
}


$("input,textarea").blur(function(){
    $(this).attr('placeholder',$(this).attr('x-placeholder'));
    $(this).removeAttr('x-placeholder');
});

$("input,textarea").focus(function(){
    $(this).attr('x-placeholder',$(this).attr('placeholder'));
    $(this).removeAttr('placeholder');
})

function addLoadingActionBtn(elem){
    var load = '<svg xmlns="http://www.w3.org/2000/svg" class="mx-auto block" style="width:50px;height:11px;" viewBox="0 0 120 30" fill="currentColor"><circle cx="15" cy="15" r="15"><animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate><animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate></circle><circle cx="60" cy="15" r="9" fill-opacity="0.3"><animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite"></animate><animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite"></animate></circle><circle cx="105" cy="15" r="15"><animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate><animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate></circle></svg>'
    $(elem).attr('data-tmp-text',$(elem).html());
    $(elem).html(load);
    $(elem).addClass('loading-action-btn-disabled');
    $(elem).attr('disabled','disabled');
}

function closeLoadingActionBtn(elem){
    $(elem).removeClass('loading-action-btn-disabled')
    $(elem).removeAttr('disabled');
    $(elem).html($(elem).attr('data-tmp-text'));
}

