(function($) {



    $.extend({

        area:function(data){
            var options = {
                data:[],
                city:{
                    element:'',
                    default:0,
                    change:function (city) {

                    },
                    init:function (id,text) {

                    }
                },
                county:{
                    element:'',
                    default:0,
                    change:function (city,county) {

                    },
                    init:function (id,text) {

                    }
                }
            };

            options.data = data.data;
            options.city = data.city;
            options.county = data.county;
            setCity()
            setCounty(options.city.default)
            function setCity(){
                var option_html = '<option value="0">全台縣市</option>';
                var init_id = 0;
                var text = '全台縣市'
                $.each(options.data,function (index,value) {
                    var selected = options.city.default == value.id?"selected":""
                    if(options.city.default == value.id){
                        init_id = value.id;
                        text = value.name;
                    }
                    option_html += '<option value="'+value.id+'" '+selected+'>'+value.name+'</option>';
                });
                $(options.city.element).html(option_html);
                options.city.init(init_id,text)
            }

            $(options.city.element).change(function () {
                setCounty($(this).val());
                options.city.change($(this).val());
            })

            function setCounty(pid){
                var init_id = 0;
                var text = '全部地區'
                var option_html = '<option value="0">全部地區</option>';
                if(pid > 0){
                    $.each(options.data,function (index,value) {
                        if(value.id == pid){
                            $.each(value.sub,function (key,val) {
                                var selected = options.county.default == val.id?"selected":""
                                if(options.county.default == val.id){
                                    init_id = val.id;
                                    text = val.name;
                                }
                                option_html += '<option value="'+val.id+'" '+selected+'>'+val.name+'</option>';
                            })
                            return false;
                        }
                    });
                }
                $(options.county.element).html(option_html);
                options.city.init(init_id,text)
            }

            $(options.county.element).change(function () {
                options.county.change($(options.city.element).val(),$(this).val());
            })


        },


    })

}(jQuery));
