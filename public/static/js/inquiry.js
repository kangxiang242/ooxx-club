$(function(){
    $('[data-inquire]').click(function(){
        var type = $(this).attr('data-inquire-type');
        var position = $(this).attr('data-inquire-position');
        var referer = window.location.href;
        if(type && position && referer){
            $.post('/take/inquiries',{
                'type':type,
                'position':position,
                'referer':referer,
            },function(resultJSONObject){
            });
        }
    });

})
