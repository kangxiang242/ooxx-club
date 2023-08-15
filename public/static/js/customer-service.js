$(function(){
    $('#send-message').click(function(){
        sendMessage()
    });

    $('.entrance,.close-chat').click(function(){
        if($('.chat-window').hasClass('close-chat-main')){
            $('.chat-window').removeClass('close-chat-main')
            $('#customer-icon').addClass('xx').html("&#xeca0;");
        }else{
            $('.chat-window').addClass('close-chat-main')
            $('#customer-icon').removeClass('xx').html("&#xe637;");
        }
    })


    recoveryMessageData();

    setInterval(function(){
        reciprocal();
    },2000)
})



function sendMessage(){
    var message = $('#customer-content').val();
    if(!message){
        return false;
    }

    pushTime();

    pushProposeMessage(message)
    $('#customer-content').val('')//清空输入框内容
    var propose_elem = $('#message-content .propose:last-child');
    $.ajax({
        type: "POST",
        url: "/message/send",
        data: {
            message:message,
        },
        dataType: "json",
        beforeSend:function(){

        },
        complete:function(){

        },
        success : function(result) {
            propose_elem.find('.status-bar').addClass('send');
            if(result.data.type == 'message'){

                var rand = Math.floor(Math.random() * 6) + 1;
                setTimeout(function(){
                    pushReplyMessage(result.data.message);
                },rand*1000)

            }else if(result.data.type == 'manual'){
                pushManualQueue(result.data.message)
            }
        },
        error:function(){

        }
    });


    return false;
}

function pushProposeMessage(message){
    if(!message){
        return false;
    }

    var last_elem = $('#message-content>div:last-child')

    var build_message = '<div class="list clearfix"><span class="text">'+message+'</span><span class="status-bar"></span></div>';

    if(last_elem.hasClass('propose')){
        last_elem.append(build_message)

    }else{
        var row_build_message = '<div class="message propose">'+build_message+'</div>'
        $('#message-content').append(row_build_message)
    }
    $('#message-content').scrollTop($('#message-content')[0].scrollHeight); //让滚动条保持在底部
    storeMessageData();
}

function pushReplyMessage(message){
    if(!message){
        return false;
    }

    var last_elem = $('#message-content>div:last-child')

    var build_message = '<div class="list clearfix"><span class="re-avatar"><img src="'+$('#kf-avatar').attr('src')+'"></span><span class="text">'+message+'</span></div>';

    if(last_elem.hasClass('reply')){
        last_elem.append(build_message)

    }else{
        var row_build_message = '<div class="message reply">'+build_message+'</div>'
        $('#message-content').append(row_build_message)
    }
    $('#message-content').scrollTop($('#message-content')[0].scrollHeight); //让滚动条保持在底部
    storeMessageData();
}

function pushManualQueue(message){
    var cus_manual_number = localStorage.getItem("cus_manual_number");
    if(!cus_manual_number){
        cus_manual_number = 46;
        localStorage.setItem("cus_manual_number",cus_manual_number);
        localStorage.setItem("cus_manual_time",Date.parse(new Date())/1000);
    }

    message = message.replace('/d/', cus_manual_number);
    var queue = '<div class="queue"><span class="label"><i class="iconfont"></i>'+message+'</span></div>';
    $('#message-content').append(queue)
    $('#message-content').scrollTop($('#message-content')[0].scrollHeight); //让滚动条保持在底部
    storeMessageData();
}

function pushTime(){
    var new_message_time = localStorage.getItem("new_message_time")?localStorage.getItem("new_message_time"):0;
    var current_time = Date.parse(new Date())/1000;
    if(current_time - new_message_time >= 600){
        localStorage.setItem("new_message_time",current_time)
        var date = new Date();
        var hours = date.getHours();
        var apm = '';
        if(hours<=12){
            apm = "上午";
        }else{
            apm = "下午";
        }

        if(hours < 10) {
            hours ="0" + hours;
        }
        if(hours >= 12) {
            hours =hours-12;
        }

        var minutes = date.getMinutes();
        if(minutes < 10) {
            minutes = "0" + minutes;
        }

        var str = apm + hours+':'+minutes;
        var time = '<div class="time">'+str+'</div>';
        $('#message-content').append(time)
        $('#message-content').scrollTop($('#message-content')[0].scrollHeight); //让滚动条保持在底部
        storeMessageData();

    }




}

function reciprocal(){
    var cus_manual_number = localStorage.getItem("cus_manual_number");

    var cus_manual_time = localStorage.getItem("cus_manual_time");
    var init_count = 50;

    var number = init_count-cus_manual_number;
    var eal = 2;
    if(cus_manual_number<=15) {
        eal = 4;
        if(cus_manual_number<=10){
            eal = 10;
            if(cus_manual_number<5){
                eal = 16

                if(cus_manual_number<2){
                    localStorage.setItem("cus_manual_number",46);
                }
            }
        }
    }

    var time = number*eal;
    var cur_time = Date.parse(new Date())/1000;

    if(cur_time - cus_manual_time >= time){

        setTimeout(function(){
            localStorage.setItem("cus_manual_number",cus_manual_number-1);
            localStorage.setItem("cus_manual_time",Date.parse(new Date())/1000);
        },time*1000);


    }

}


function storeMessageData(message){
    localStorage.setItem("chats_messages",$('#message-content').html());
}

function recoveryMessageData(){
    var  time = localStorage.getItem("new_message_time")
    var is_day = _GetDateStr(time);
    if(!is_day){
        localStorage.removeItem("chats_messages");
        localStorage.removeItem("new_message_time");
    }
    if(localStorage.getItem("chats_messages")){
        $('#message-content').html(localStorage.getItem("chats_messages"))
    }
    $('#message-content').scrollTop($('#message-content')[0].scrollHeight); //让滚动条保持在底部
}

function _GetDateStr(sj_str){
    var data = new Date().toLocaleDateString()
    var dd = Date.parse(data)/1000

    var iday = Math.floor(parseInt(dd-sj_str)/60/60/24);
    if( -1 == iday ){
        return true
    }else if(0 == iday){
        return false
    }else{
        return false;
    }
}
