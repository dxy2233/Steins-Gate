    function gradeChange(){
        var data={};
        var s_province = $('#s_province').val();
        data.s_province=s_province;
         $.ajax({
            url:'/region/region/list',
            type:'POST',
            data:data,
            jsonType:'json',
            success:function(data){
                $('#s_city').empty();
                $('#s_county').empty();
                if(data.list){
                    $('#s_city').append('<option value="">请选择</option>');
                    for(var i in data.list){
                        $('#s_city').append('<option value="'+data.list[i].region_code+'">'+data.list[i].region_name+'</option>');
                    }
                    $('#s_county').append('<option value="">请选择</option>');
                }else{
                    $('#s_city').append('<option value="">请选择</option>');
                }
            } 
        });
    }
    function gradeChangetwo(){
        var data={};
        var s_city = $('#s_city').val();
        data.s_province=s_city;
         $.ajax({
            url:'/region/region/list',
            type:'POST',
            data:data,
            jsonType:'json',
            success:function(data){
                $('#s_county').empty();
                if(data.list){
                    $('#s_county').append('<option value="">请选择</option>');
                    for(var i in data.list){
                        $('#s_county').append('<option value="'+data.list[i].region_code+'">'+data.list[i].region_name+'</option>');
                    }
                }else{
                    $('#s_county').append('<option value="">请选择</option>');
                }
            } 
        });
    }