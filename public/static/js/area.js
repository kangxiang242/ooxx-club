(function($) {



    $.extend({

        area:function(data){
            var options = {
                data:[],
                city:{
                    element:'',
                    default:0,
                    change:function (city) {

                    }
                },
                county:{
                    element:'',
                    default:0,
                    change:function (city,county) {

                    }
                }
            };

            options.data = data.data;
            options.city = data.city;
            options.county = data.county;
            setCity();
            setCounty(options.city.default)
            function setCity(){
                var option_html = '<option value="0">全部</option>';
                $.each(options.data,function (index,value) {
                    var selected = options.city.default == value.id?"selected":""
                    option_html += '<option value="'+value.id+'" '+selected+'>'+value.name+'</option>';
                });
                $(options.city.element).html(option_html);
            }

            $(options.city.element).change(function () {
                setCounty($(this).val());
                options.city.change($(this).val());
            })

            function setCounty(pid){

                var option_html = '<option value="0">全部</option>';
                if(pid > 0){
                    $.each(options.data,function (index,value) {
                        if(value.id == pid){
                            $.each(value.sub,function (key,val) {
                                var selected = options.county.default == val.id?"selected":""
                                option_html += '<option value="'+val.id+'" '+selected+'>'+val.name+'</option>';
                            })
                            return false;
                        }
                    });
                }
                $(options.county.element).html(option_html);
            }

            $(options.county.element).change(function () {
                options.county.change($(options.city.element).val(),$(this).val());
            })


        },


    })

}(jQuery));
