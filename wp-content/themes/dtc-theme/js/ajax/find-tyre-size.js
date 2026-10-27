/**
 * Created by x on 4/15/2015.
 */
jQuery(document).ready(function($){

    $('.item').click(function(){
        var brand = $(this).attr('brand'),
            model = $(this).attr('model'),
            product_year = $(this).attr('product_year');
        //$('.btn-box .next').attr('brand',brand);
        //$('.btn-box .next').attr('model',model);
        //$('.btn-box .next').attr('product_year',product_year);
        data = {};
        data['brand']=brand;
        data['model']=model;
        data['product_year']=product_year;
        setGetParameterOBJ(data);
        //$('.item').removeClass('active');
        //$(this).addClass('active')
    })

    //$('.btn-box .back').click(function(){
    //    window.history.go(-1);
    //})
    //$('.btn-box .next').click(function(){
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



})

