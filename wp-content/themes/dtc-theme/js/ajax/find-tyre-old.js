
jQuery(document).ready(function($){
    $('.ht_find_vehicle span').click(function(){

        var data = {};
        data['type'] = getParameterByName('type');
        
        var stt = $('.ht_find_vehicle span').index(this);

        $('.ht_find_vehicle span').each(function(index,value){
            var id = $(this).attr('attr_id'),
                step_vehicle = $(this).attr('class');
            if(index >stt){
                id ='';
            }
            data[step_vehicle]=id;
        });
        setGetParameterOBJ(data);
    });

    $('.btn-box .back').click(function(){
        window.history.go(-1);
    })

    //by vehicle
    $('.item-vehicle').click(function(){
        var brand = $(this).attr('brand'),
            model = $(this).attr('model'),
            product_year = $(this).attr('product_year'),
            variant = $(this).attr('variant');

        var data = {};
        data['type'] = getParameterByName('type');
        data['brand']=brand;
        data['variant']=variant;
        // data['car_maker']=car_maker;
        data['model']=model;
        data['product_year']=product_year;
        setGetParameterOBJ(data);
        //$('.btn-box .next').attr('brand',brand);
        //$('.btn-box .next').attr('model',model);
        //$('.btn-box .next').attr('product_year',product_year);
        //$('.item').removeClass('active');
        //$(this).addClass('active')
    })


    //$('.btn-box .next-vehicle').click(function(){
    //    var id = $(this).attr('id'),
    //        brand = $(this).attr('brand'),
    //        model = $(this).attr('model'),
    //        product_year = $(this).attr('product_year'),
    //        data = {};
    //        data['brand']=brand;
    //        data['model']=model;
    //        data['product_year']=product_year;
    //    setGetParameterOBJ(data);
    //})
    //by size

    $('.item-size').click(function(){
        data = {};
        data['type'] = getParameterByName('type');
        var first_number = $(this).attr('first_number'),
            second_number = $(this).attr('second_number'),
            third_number = $(this).attr('third_number');
        //$('.btn-box .next').attr('first_number',first_number);
        //$('.btn-box .next').attr('second_number',second_number);
        //$('.btn-box .next').attr('third_number',third_number);
        data['first_number']=first_number;
        data['second_number']=second_number;
        data['third_number']=third_number;
        setGetParameterOBJ(data);
        //$('.item').removeClass('active');
        //$(this).addClass('active')
    })
    //$('.btn-box .next-size').click(function(){
    //    var id = $(this).attr('id'),
    //        first_number = $(this).attr('first_number'),
    //        second_number = $(this).attr('second_number'),
    //        third_number = $(this).attr('third_number'),
    //        data = {};
    //    data['first_number']=first_number;
    //    data['second_number']=second_number;
    //    data['third_number']=third_number;
    //    setGetParameterOBJ(data);
    //})


    function setGetParameterOBJ(data) {
        var url_fix = window.location.protocol + '//' + window.location.host + window.location.pathname
        window.location.href = url_fix+'?' + $.param(data);
    }

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

});