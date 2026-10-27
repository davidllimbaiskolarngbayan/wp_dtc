var isreturnpage = false;
(function($){
    window.onpopstate = function() {
        isreturnpage = true;
    };

    window.onload = function(){
        if($('div.findtyre_canvas').length == 1){
            if($('div.vehdd_vehicle').length == 1) {
                window.history.pushState('findtyre', null, '#ft');
            }else if($('div.vehdd_size').length == 1) {
                window.history.pushState('findtyre', null, '#ft');
            }
            if (! isreturnpage) {
                /*pixel();*/
            }
        }
    };
})(jQuery);

jQuery(document).ready(function($){

    //disable select lists except first
    if($('div.findtyre_canvas').length == 1){
        if($('div.vehdd_vehicle').length == 1) {
            $('select.vehcat:not(:first)').prop('disabled', true);
        }else if($('div.vehdd_size').length == 1){
            $('.sizefield select.vehsize:not(:first)').prop('disabled', true);
            $('.sizeoption select.vehsize').prop('disabled', true);
        }
    }

    //pre-define obj
    var size_1 = $('select[name="veh_size_field_1"]');
    var size_2 = $('select[name="veh_size_field_2"]');
    var size_3 = $('select[name="veh_size_field_3"]');
    var size_speed = $('select[name="veh_size_opt_speed"]');
    var size_load = $('select[name="veh_size_opt_load"]');


    function loading_show(){
        //$('.preload').show();
        //$('.preload').attr("style", "display: inline !important");
        $('#findtyre_loading').attr("style", "display: inline !important");
    }
    function loading_hide(){
        //$('.preload').hide();
        //$('.preload').attr("style", "display: none !important");
        $('#findtyre_loading').attr("style", "display: none !important");
    }
    function reset_item_color(){
        //reset row color
        $('#findtyre_items').find('.type-box:visible').each(function(index){
            $(this).css("background-color", ( index % 2 ? "#eeeeef" : "#fff" ));
        });
    }
    function reset_oetyre_item_color(){
        //reset row color
        $('.box-colspace-result').find('.type-box:visible').each(function(index){
            $(this).css("background-color", ( index % 2 ? "#eeeeef" : "#fff" ));
        });
    }
    // ROF
    function filter_rof(){
        console.log("filter ROF()");
        if($('div#findtyre_items').find('div.type-box[data-rof*=on]').length == 0){
            $('div.rof_box').hide(); //remove empty rof
        }else{
            $('div.rof_box').show();
            return;
        }

        if($('div.box-colspace-result').find('div.type-box[data-rof*=on]').length > 0){
            $('div.rof_box').show();
        }
    }
    //ROF

    function filter_cate(){
        $('ul.type-cate > li').each(function(){
            var cate_term = $(this).children('label').attr('for');
            if($('div#findtyre_items').find('div.type-box[data-cat-filter*="'+cate_term+'"]').length == 0){
                $(this).remove(); //remove empty category
            }
        });
    }
    function filter_item_bycate(){
        var cate_term = $(this).attr('for');
        $('div#findtyre_items').find('div.type-box').hide();
        $('div#findtyre_items').find('div.type-box[data-cat-filter*="'+cate_term+'"]').show();

        $('.type-cate > li').removeClass('type_checked');
        $('.type-cate > li').find('label').removeClass('type_checked');
        $(this).addClass('type_checked');

        //reset row color
        $('.type-box:visible').each(function(index){
            $(this).css("background-color", ( index % 2 ? "#eeeeef" : "#fff" ));
        });
    }
    // new OE
    function filter_item_display(selected_cate,rof_on){
        var filterdata = '';
        if(selected_cate !== undefined && selected_cate != '') {
            filterdata += '[data-cat-filter*="'+selected_cate+'"]';
        }
        if(rof_on !== undefined && rof_on == 'on') {
            filterdata += '[data-rof*=on]';
        }
        if(filterdata != ''){
            //console.log('filterdata: '+filterdata);
            $('div#findtyre_output').find('div.type-box').hide(); //hide all item first
            $('div#findtyre_output').find('div.type-box'+filterdata).show();
            reset_item_color();
        }else if(rof_on == 'off'){
            $('div#findtyre_output').find('div.type-box').show(); //show all items
            reset_item_color();
        }

        if($('div#findtyre_items').find('.type-box:visible').length==0){
            if($('div.tab-content').find('p#noresult-fix').length==0)
                $('div.tab-content').find('p#noresult-ajax').show();
        }else{
            $('div.tab-content').find('p#noresult-ajax').hide();
        }


        //For OEtyre
        if($('div#findtyre_result_oetyre').length == 1){
            reset_oetyre_item_color();

            //No item in OEtyre
            oetyre_item_noresult();
            reset_item_color();
        }


    }

    function findtyre_noresult(){
        var total_item = $('#findtyre_items').find('div.type-box').length;
        if(total_item==0){
            $('#findtyre_output').find('div.col-sm-3').hide();
            $('#findtyre_output').find('div.col-sm-9').removeClass('col-sm-9').addClass('col-sm-12');
        }
    }
    function findtyre_ajax(datas,callback){
        //console.log(hatt_params.ajax_url);
        //loading_show();
        $.ajax({
            type: 'POST',
            url: hatt_params.ajax_url,
            data: datas,
            dataType: 'json'
        })
        .done(callback)
        .fail(function(){console.log('Connection fail.');})
        .always(function(){loading_hide()})
        .responseJSON;
    }
    function findtyre_filter(action,extradata,callback){
        var datas = 'action='+action
            + '&' + 'security=' + $('input#ajax-nonce').val()
            + '&' + $('form#vehform').serialize()
            + extradata;

        findtyre_ajax(datas,callback);
    }

    function loadtyre_comparecheck(){

        if($('.compare_item div[class*=compare_add_]').length > 0){
            $('.compare_item div[class*=compare_add_]').each(function(){
                attr_id = $(this).attr('attr_id');

                /*$('#findtyre_items').find('[attr_id='+attr_id+']').each(function(){
                 console.log('has item: '+attr_id);
                 });*/

                $('#findtyre_items').find('div.button_compare_'+attr_id).each(function(){
                    $(this).parent().attr('checked','checked');
                    $(this).removeClass('uncheck').addClass('checked');
                });

            });
            return;
        }
    }

    function loadvehicle_catlist(output, textStatus, xhr){
        //reset output
        $('#findtyre_output').html('');
        filter_rof();

        if(output.result==1){
            $('#findtyre_output').html(output.html);
            filter_cate();
            findtyre_noresult();
        }else{

            var sel_cat = parseInt(output.sel_cat);
            var total_cat = parseInt(output.total_cat);

            for(var i = (sel_cat+1), j = total_cat; i<j; i++ ){
                var elementname = 'veh_cat['+i+']';
                var select_obj = $('select[name="'+elementname+'"]');

                //remove list items
                select_obj.find("option:gt(0)").remove();
                select_obj.find("optgroup").remove();

                if(i == (sel_cat+1) ){
                    //insert list items
                    select_obj.append(output.options);
                    select_obj.prop('disabled', false);
                }else{
                    select_obj.prop('disabled', 'disabled');
                }
            }
        }
    }

    function loadsize_resetselect(sizeno){
        if(sizeno <= 3){
            size_speed.find("option:gt(0)").remove();
            size_speed.prop('disabled', 'disabled');

            size_load.find("option:gt(0)").remove();
            size_load.prop('disabled', 'disabled');

            if(sizeno <= 2){
                size_3.find("option:gt(0)").remove();
                size_3.prop('disabled', 'disabled');

                if(sizeno == 1){
                    size_2.find("option:gt(0)").remove();
                    size_2.prop('disabled', 'disabled');
                }
            }
        }
    }
    function loadsize_img(output){
        if(output.img_left !== undefined){
            $('img#sizeimg_left').attr('src',output.img_left);
        }
        if(output.img_right !== undefined){
            $('img#sizeimg_right').attr('src',output.img_right);
        }
    }
    function loadsize_optional(output){
        if(output.has_optional !== undefined && output.has_optional==1){
            size_speed.append(output.option_speed);
            size_speed.prop('disabled', false);

            size_load.append(output.option_load);
            size_load.prop('disabled', false);
        }
    }
    function loadsize_2(output, textStatus, xhr){
        size_2.append(output.options); //add options
        size_2.prop('disabled', false);

        loadsize_img(output);
    }
    function loadsize_3(output, textStatus, xhr){
        size_3.append(output.options);
        size_3.prop('disabled', false);

        loadsize_optional(output);
        loadsize_img(output);
    }
    function loadsize_item(output, textStatus, xhr){
        $('#findtyre_output').html(output.html);
        filter_cate();
        findtyre_noresult();

        loadsize_optional(output);
        loadsize_img(output);
    }
    function loadsize_optitem(output, textStatus, xhr){
        $('#findtyre_output').html(output.html);
        filter_cate();
        findtyre_noresult();

        loadsize_img(output);
    }

    function loadsize_preload(output, textStatus, xhr){

        size_2.append(output.options_size_2);
        size_3.append(output.options_size_3);

        $('#findtyre_output').html(output.html);
        filter_cate();
        filter_rof();
        findtyre_noresult();

        loadsize_optional(output);
        loadsize_img(output);

        //pre-select options
        $('select[name="veh_size_field_1"] option[value="'+output.data_array.veh_size_field_1+'"]').prop('selected', true);
        $('select[name="veh_size_field_2"] option[value="'+output.data_array.veh_size_field_2+'"]').prop('selected', true);
        $('select[name="veh_size_field_3"] option[value="'+output.data_array.veh_size_field_3+'"]').prop('selected', true);
        if(output.data_array.veh_size_opt_speed != ''){
            $('select[name="veh_size_opt_speed"] option[value="'+output.data_array.veh_size_opt_speed+'"]').prop('selected', true);
        }
        if(output.data_array.veh_size_opt_load != ''){
            $('select[name="veh_size_opt_load"] option[value="'+output.data_array.veh_size_opt_load+'"]').prop('selected', true);
        }

        //enable select list
        if(output.data_array.veh_size_field_1 != ''){size_2.prop('disabled', false);}
        if(output.data_array.veh_size_field_2 != ''){size_3.prop('disabled', false);}
        if(output.data_array.veh_size_field_3 != ''){$('.sizeoption select.vehsize').prop('disabled', false);}

        //check ht_compare_center
        loadtyre_comparecheck();
    }
    function loadvehicle_preload(output, textStatus, xhr){
        pixel();
        $('#findtyre_onload').html(output.html);
        filter_cate();
        filter_rof();
        findtyre_noresult();

        //pre-select options
        var pre_select_cat = output.data_array.veh_cat;
        // console.log(output);
        $('select[name="veh_cat[0]"] option[value="'+pre_select_cat[0]+'"]').prop('selected', true);
        if(pre_select_cat[0] != ''){
            $('select[name="veh_cat[1]"]').prop('disabled', false);
        }

        //load sub-categories
        var total_cat = parseInt(output.total_cat);
        $.each(output.options_of, function(k,v){
            var elementname = 'veh_cat['+k+']';
            var select_obj = $('select[name="'+elementname+'"]');

            //remove list items
            select_obj.find("option:gt(0)").remove();
            select_obj.find("optgroup").remove();

            //insert list items
            select_obj.append(v);

            //pre-select option
            $('select[name="veh_cat['+k+']"] option[value="'+pre_select_cat[k]+'"]').prop('selected', true);

            //enable select list
            if(pre_select_cat[k] != ''){
                $('select[name="veh_cat['+(parseInt(k)+1)+']"]').prop('disabled', false);
            }

        });

        set_preselected_vehicle();


        //check ht_compare_center
        loadtyre_comparecheck();

    }


    //by vehicle
    $('select.vehcat').change(function(){

        $('#findtyre_output').html('');//reset output
        $('#findtyre_onload').hide();//reset output

        var current_dd = parseInt($(this).attr('data-no'));
        var is_end = $(this).attr('data-end');
        if(is_end==1){
            if($(this).val() != ''){
                loading_show();
                findtyre_filter('rfq-inno-tyre-by-vehicle','&tyreact=loadvehicle&cat_no='+current_dd,loadvehicle_catlist);
                set_preselected_vehicle();

                console.log('track evt');
                dataLayer.push({ 
                    'event': 'findTyreSearch'
                });
            }
        }else{
            var total_cat = $('select.vehcat').length;
            for(var i = (current_dd+1), j = total_cat; i<j; i++ ){
                var elementname = 'veh_cat['+i+']';
                var select_obj = $('select[name="'+elementname+'"]');

                //remove list items
                select_obj.find("option:gt(0)").remove();
                select_obj.find("optgroup").remove();

                //disable
                select_obj.prop('disabled', 'disabled');
            }

            if($(this).val() != '') {
                findtyre_filter('rfq-inno-tyre-by-vehicle','&tyreact=loadvehicle&cat_no='+current_dd,loadvehicle_catlist);
            }
        }
    });
    $('body').on('click', '#findtyre_vehicle_cate .type-cate label', filter_item_bycate);

    //by size
    $('select[name=veh_size_field_1]').change(function(){
        $('#findtyre_output').html('');//reset output
        loadsize_resetselect(1);
        if($(this).val() != '') {
            findtyre_filter('inno-tyre-by-size','&tyreact=loadsize_field2',loadsize_2);
        }
    });
    $('select[name=veh_size_field_2]').change(function(){
        $('#findtyre_output').html('');//reset output
        loadsize_resetselect(2);
        if($(this).val() != '') {
            findtyre_filter('inno-tyre-by-size','&tyreact=loadsize_field3',loadsize_3);
        }
    });
    $('select[name=veh_size_field_3]').change(function(){
        $('#findtyre_output').html('');//reset output
        loadsize_resetselect(3);
        if($(this).val() != '') {
            loading_show();
            findtyre_filter('rfq-inno-tyre-by-size','&tyreact=loadsize_result',loadsize_item);
            set_preselected_vehicle();

            console.log('track evt');
            dataLayer.push({ 
                'event': 'findTyreSearch'
            });
        }
    });
    $('select[name=veh_size_opt_load] , select[name=veh_size_opt_speed]').change(function(){
        $('#findtyre_output').html('');//reset output
        loading_show();
        findtyre_filter('rfq-inno-tyre-by-size','&tyreact=loadsize_optional',loadsize_optitem);
        set_preselected_vehicle();

        console.log('track evt');
        dataLayer.push({ 
            'event': 'findTyreSearch'
        });
        
    });
    $('body').on('click', '#findtyre_size_cate .type-cate label', filter_item_bycate);
    
    /* Run On Flat */
    $('body').on('click', 'input#findtyre_rof', function(){
        //check if category is selected
        var selected_cate = $('.type-cate > li').find('label.type_checked').attr('for');
        var rof_on = ($(this).is(':checked'))? 'on':'off';
        filter_item_display(selected_cate,rof_on);

        $.cookie('ftrof',rof_on,{expires:1,path:'/'}); //set cookies

        reset_item_color();

        //For OEtyre
        if($('div#findtyre_result_oetyre').length == 1){
            reset_oetyre_item_color();

            //No item in OEtyre
            oetyre_item_noresult();
            reset_item_color();
        }
    });

    function findtyre_preload(tyretype){
        var datas = [];

        if(tyretype == 'vehicle'){
            var totalcat = $.cookie('ftveh[totalcat]');

            datas.push({ name: "action",    value: "rfq-inno-tyre-by-vehicle" });
            datas.push({ name: "security",  value: $('input#ajax-nonce').val() });
            datas.push({ name: "tyreact",   value: "loadvehicle_preload" });
            datas.push({ name: "totalcat",  value: totalcat });

            for(var i = 0, j = totalcat; i<j; i++ ){
                datas.push({ name: "veh_cat["+i+"]", value: $.cookie("ftveh[vehcat]["+i+"]") });
            }
            datas.push({ name: "tyre_cate", value: $.cookie('ftsize[cat]') });
            datas.push({ name: "tyre_compare", value: $.cookie('ftcompare') });

            findtyre_ajax($.param(datas),loadvehicle_preload);
        }else if(tyretype == 'size'){

            datas.push({ name: "action",    value: "rfq-inno-tyre-by-size" });
            datas.push({ name: "security",  value: $('input#ajax-nonce').val() });
            datas.push({ name: "tyreact",   value: "loadsize_preload" });

            datas.push({ name: "veh_size_field_1", value: $.cookie('ftsize[size1]') });
            datas.push({ name: "veh_size_field_2", value: $.cookie('ftsize[size2]') });
            datas.push({ name: "veh_size_field_3", value: $.cookie('ftsize[size3]') });
            datas.push({ name: "veh_size_opt_speed", value: $.cookie('ftsize[size_speed]') });
            datas.push({ name: "veh_size_opt_load", value: $.cookie('ftsize[size_load]') });
            datas.push({ name: "tyrecate", value: $.cookie('ftsize[cat]') });
            datas.push({ name: "tyre_compare", value: $.cookie('ftcompare') });

            findtyre_ajax($.param(datas),loadsize_preload);
        }
    }

    function set_preselected_vehicle(){
        var vehicle_model = [];
        var vehicle_size = [];
        var size_option = '';
        
        if($('.vehsize_opt').length == 2){

            $('.vehsize option:selected').each(function(i,e){



                if(i <= 2 ){
                     if($(e).val() != "")
                        vehicle_size.push($(e).text()) ;
                 }else{
                    if($(e).val() != "")
                        size_option += $(e).text();
                 }
            });

             var last_selected_name = vehicle_size.join("/") +' '+size_option;

        }else{

            $('.vehcat option:selected').each(function(i,e){
                vehicle_model.push($(e).text()) ;
            });

            var last_selected_name = vehicle_model.join(" / ");
        }

        
        var last_vehicle_selected = $('.vehcat option:selected').last().val();


        $.ajax({
            url: hatt_params.ajax_url,
            data: {
                'action':'rfq_set_side_form',
                'last_selected_name' : last_selected_name,
                'last_selected_id' : last_vehicle_selected
            },
            success:function(data) {
                //removes the tyre item from the form list
                console.log(data);
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
    }

    //preload (from compare)
    if($('div#preload_findtyre').length ==1 ) {
        var tyretype = $('div#preload_findtyre').attr('data-type');
        findtyre_preload(tyretype);
    }

    //preload (from back button)
    if(isreturnpage === true){
        console.log('is return');

        if($('div.findtyre_canvas').length == 1){
            if($('div.vehdd_vehicle').length == 1) {
                if($.cookie('findtyre')=='vehicle'){
                    var last_no = parseInt($.cookie('ftveh[totalcat]')) - 1;
                    if($.cookie('ftveh[vehcat]['+last_no+']')!==undefined && $.cookie('ftveh[vehcat]['+last_no+']')!='') {
                        loading_show();
                    }
                    findtyre_preload('vehicle');
                }else{
                    $.cookie('findtyre','vehicle');
                    window.location.reload();
                }
            }else if($('div.vehdd_size').length == 1){
                if($.cookie('findtyre')=='size'){
                    if($.cookie('ftsize[size3]')!=undefined && $.cookie('ftsize[size3]')!='') {
                        loading_show();
                    }
                    findtyre_preload('size');
                }else{
                    $.cookie('findtyre','size');
                    window.location.reload();
                }
            }
        }
    }
});


jQuery(document).ready(function($){
    

    $('.btn-box .back').click(function(){
        window.history.go(-1);
    })



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