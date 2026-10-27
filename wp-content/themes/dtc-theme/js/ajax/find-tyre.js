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
        }
    };
})(jQuery);

jQuery(document).ready(function($){

    //disable select lists except first
    if($('div.findtyre_canvas').length == 1){
        if($('div.vehdd_vehicle').length == 1) {
            $('select.vehcat:not(:first)').prop('disabled', true);
            $('select.vehcat-rfq:not(:first)').prop('disabled', true);
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

    var veh_0 = $('select[name="veh_cat[0]"]');
    var veh_1 = $('select[name="veh_cat[1]"]');
    var veh_2 = $('select[name="veh_cat[2]"]');
    var veh_3 = $('select[name="veh_cat[3]"]');

    function reset_filter_jscookie(){
        $.removeCookie('ftrof', {expires:1,path:'/'});
        $.removeCookie('ftcate', {expires:1,path:'/'});
    }

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
    function filter_rof(){
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

    function filter_cate(){
        $('ul.type-cate > li').each(function(){
            var cate_term = $(this).children('label').attr('for');
            if($('div#findtyre_items').find('div.type-box[data-cat-filter*="'+cate_term+'"]').length == 0){
                $(this).remove(); //remove empty category
            }
        });

        //highlight 1st displayed category
        $('.type-cate > li').removeClass('type_checked');
        $('.type-cate > li').find('label').removeClass('type_checked');
        $('ul.type-cate > li:first-child').addClass('type_checked');
    }
    function filter_item_bycate(){
        var cate_term = $(this).attr('for');
        // $('div#findtyre_items').find('div.type-box').hide();
        // $('div#findtyre_items').find('div.type-box[data-cat-filter*="'+cate_term+'"]').show();

        var rof_on = ($('input#findtyre_rof').is(':checked'))? 'on':'off'; //add-in ROF filter
        filter_item_display(cate_term,rof_on);

        $.cookie('ftcate',cate_term,{expires:1,path:'/'}); //set cookies

        $('.type-cate > li').removeClass('type_checked');
        $('.type-cate > li').find('label').removeClass('type_checked');
        $(this).addClass('type_checked');

        //reset row color
        // $('.type-box:visible').each(function(index){
        //     $(this).css("background-color", ( index % 2 ? "#eeeeef" : "#fff" ));
        // });
        reset_item_color();

        //For OEtyre
        if($('div#findtyre_result_oetyre').length == 1){
            reset_oetyre_item_color();

            //No item in OEtyre
            oetyre_item_noresult();
            reset_item_color();
        }


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
    function filter_item_to_oetyre(){
        //Move OEtyre to OEtyre box

        //prevent error (might cause by cache)
        $('div#findtyre_result_oetyre').show();
        $('div#findtyre_result_other').show();
        $('div#findtyre_items').show();

        $('div#findtyre_items').find('div.type-box').each(function(){
            var is_oetyre = $(this).attr('data-isoe');
            var tyreID = $(this).attr('data-ID');
            if(is_oetyre==1){
                //move item to OEtyre box
                $(this).prependTo($('#findtyre_result_oetyre .box-colspace-result'));
            }
        });


        if($('div.box-colspace-result').find('.type-box:visible').length==0){
            //hide OEtyre box
            $('div#findtyre_result_oetyre').hide();
            $('div#findtyre_result_other').hide();
        }

        if($('div#findtyre_items').find('.type-box:visible').length==0){
            //hide others
            console.log("hide>!!");
            $('div#findtyre_result_other').hide();
            // $('div#findtyre_items').hide();
            $('div#findtyre_items').show();
        }

        //No item in OEtyre
        oetyre_item_noresult();

        //No item in 'Other'
        oetyre_otheritem_noresult();

        //reset colors
        reset_item_color();
        reset_oetyre_item_color();


    }

    function oetyre_item_noresult(){
        if($('div.box-colspace-result').find('.type-box:visible').length==0){
            $('div.box-colspace-content-result').find('p#noresult-oetyre').show();
        }else{
            $('div.box-colspace-content-result').find('p#noresult-oetyre').hide();
        }
    }
    function oetyre_otheritem_noresult(){
        if($('div#findtyre_items').find('.type-box:visible').length==0){
            $('div.tab-content').find('p#noresult-ajax').show();
        }else{
            $('div.tab-content').find('p#noresult-ajax').hide();
        }
    }


    // new OE


    function findtyre_noresult(){
        var total_item = $('#findtyre_items').find('div.type-box').length;
        if(total_item==0){
            $('#findtyre_output').find('div.col-sm-3').hide();
            $('#findtyre_output').find('div.col-sm-9').removeClass('col-sm-9').addClass('col-sm-12');

            $('#findtyre_output').find('div.rof_box').hide(); //hide ROF checkbox

            //Hide OEtyre
            $('#findtyre_output').find('div#findtyre_result_oetyre').hide();
            $('#findtyre_output').find('div#findtyre_result_other').hide();
        }
    }
    function findtyre_ajax(datas,callback){
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

                //For OEtyre
                if($('div#findtyre_result_oetyre').length == 1){
                    $('.box-colspace-result').find('div.button_compare_'+attr_id).each(function(){
                        $(this).parent().attr('checked','checked');
                        $(this).removeClass('uncheck').addClass('checked');
                    });
                }

            });
            return;
        }
    }

    function loadtyre_sizedropdown(){
        //duplicate OEtyre size dropdown
        if($('#findtyre_oesize_output').length ==1 ) {
            if($('#findtyre_sizedd').find('div#oesizedd_sample').length <= 0){
                $('div#oesizedd_sample').appendTo($('#findtyre_sizedd')).show();
                $('div#oesizedd_sample').clone().appendTo($('#sizedd_mobile'));
            }
        }
    }
    function loadvehicle_byoesize(output, textStatus, xhr){

        $('#findtyre_output').html(output.html);
        filter_cate();
        filter_rof();
        findtyre_noresult();

        //OEtyre
        filter_item_to_oetyre();
        loadtyre_sizedropdown();

        resultCallback(290);

        //prevent error when refresh page
        reset_filter_jscookie();

    }
    function loadvehicle_bydd_oesize(output, textStatus, xhr){
        $('#findtyre_output').show();
        $('#findtyre_items').html(output.html);
        $('#findtyre_catedd').html(output.side_html);
        filter_cate();
        filter_rof();

        //check ht_compare_center
        loadtyre_comparecheck();

        //OEtyre
        filter_item_to_oetyre();

        //solve bug:
        $('input#findtyre_rof').prop('checked', false);

        //prevent error when refresh page
        reset_filter_jscookie();

    }

    function loadvehicle_catlist(output, textStatus, xhr){
        //reset output
        $('#findtyre_output').html('');
        $('#findtyre_oesize_output').html('');

        if(output.result==1){
            $('#findtyre_output').html(output.html);
            filter_cate();
            filter_rof();
            findtyre_noresult();

            //OEtyre Size Filter
            $('#findtyre_oesize_output').hide().html(output.html_oesize);
            if(output.show_oesize==1){
                $('#findtyre_oesize_output').show();
            }

            //OEtyre
            filter_item_to_oetyre();
            loadtyre_sizedropdown();

            //called when vehicle result is returned
            resultCallback(338);
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

        //prevent error when refresh page
        reset_filter_jscookie();
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
        filter_rof();
        findtyre_noresult();

        loadsize_optional(output);
        loadsize_img(output);

        resultCallback(426);

        //prevent error when refresh page
        reset_filter_jscookie();
    }
    function loadsize_optitem(output, textStatus, xhr){
        $('#findtyre_output').html(output.html);
        filter_cate();
        filter_rof();
        findtyre_noresult();

        loadsize_img(output);

        resultCallback(439);

        //prevent error when refresh page
        reset_filter_jscookie();
    }

    function loadtyre_preload(){

        var cookie_cate = '';
        var cookie_rof = '';

        if($.cookie('ftcate') !== undefined && $.cookie('ftcate') != ''){
            if($('.type-cate > li').find('label[for='+$.cookie('ftcate')+']').length > 0){
                $('.type-cate > li').removeClass('type_checked');
                $('.type-cate > li').find('label').removeClass('type_checked');
                $('.type-cate > li').find('label[for='+$.cookie('ftcate')+']').addClass('type_checked');

                cookie_cate = $.cookie('ftcate'); //prevent cookie error
            }else{
                $.cookie('ftcate','',{expires:1,path:'/'}); //set cookies
                cookie_cate = '';
            }
        }
        if($.cookie('ftrof') !== undefined && $.cookie('ftrof') == 'on'){
            if($('div#findtyre_items').find('div.type-box[data-rof*=on]').length > 0){
                $('input#findtyre_rof').prop('checked', true);
                cookie_rof = 'on';
            }else{
                $.cookie('ftrof','off',{expires:1,path:'/'}); //set cookies
                cookie_rof = '';
            }
        }

        //OEtyre
        loadtyre_sizedropdown();
        filter_item_to_oetyre();

        //filter if set ROF or category
        filter_item_display(cookie_cate,cookie_rof);

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

        resultCallback(492);

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
        
        //show items by category & ROF filter
        loadtyre_preload();

        //check ht_compare_center
        loadtyre_comparecheck();
    }
    function loadvehicle_preload(output, textStatus, xhr){

        $('#findtyre_output').html(output.html);
        filter_cate();
        filter_rof();
        findtyre_noresult();

        // resultCallback(523);

        //pre-select options
        var pre_select_cat = output.data_array.veh_cat;
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

        //show items by category & ROF filter
        loadtyre_preload();

        //check ht_compare_center
        loadtyre_comparecheck();

        //OEtyre Size Filter
        $('#findtyre_oesize_output').hide().html(output.html_oesize);
        if(output.show_oesize==1){
            $('#findtyre_oesize_output').show();
        }
        loadtyre_sizedropdown();

    }


    //by vehicle
    $('select.vehcat').change(function(){

        //reset output

        $('#findtyre_output').html('');
        $('#findtyre_oesize_output').html('');

        var current_dd = parseInt($(this).attr('data-no'));
        var is_end = $(this).attr('data-end');

        console.log('select,is_end:',is_end);
        console.log('value:', $(this).val() );

        if(is_end==1){
            if($(this).val() != ''){
                loading_show();
                findtyre_filter('inno-tyre-by-vehicle','&tyreact=loadvehicle&cat_no='+current_dd,loadvehicle_catlist);
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
                findtyre_filter('inno-tyre-by-vehicle','&tyreact=loadvehicle&cat_no='+current_dd,loadvehicle_catlist);
            }
        }
    });

    $('body').on('click', '#findtyre_vehicle_cate .type-cate label', filter_item_bycate);

    //by vehicle for rfq page
    $('select.vehcat-rfq').change(function(){

        $('#findtyre_output').html('');//reset output
        
        var current_dd = parseInt($(this).attr('data-no'));
        var is_end = $(this).attr('data-end');

        console.log('select,is_end:',is_end);
        console.log('value:', $(this).val() );

        if(is_end==1){
            $('#findtyre-rfq-initial').html(''); //removes all the default tyre list
            
            if($(this).val() != ''){
                loading_show();
                findtyre_filter('inno-tyre-by-vehicle','&rfq=true&tyreact=loadvehicle&cat_no='+current_dd,loadvehicle_catlist);
            }
        }else{
            var total_cat = $('select.vehcat').length;
            console.log("total_cat:",total_cat);
            
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
                findtyre_filter('inno-tyre-by-vehicle','&tyreact=loadvehicle&cat_no='+current_dd,loadvehicle_catlist);
            }



        }
    });

    $('body').on('click', '#findtyre_oesize_output .vsize-item', function(){
        $('#findtyre_output').html(''); //reset output
        $('#findtyre_oesize_output').hide(); //hide OE-size filter box

        var sel_size = parseInt($(this).attr('data-size'));
        $('select#oesize-filter-mobile').val(sel_size);
        //$('#sizedd_mobile').find('select#oesize-filter-mobile').val(sel_size);

        loading_show();
        findtyre_filter('inno-tyre-by-vehicle','&tyreact=loadvehicle&filteroe=1&oe_size='+sel_size,loadvehicle_byoesize);

    });
    $('body').on('change', 'select#oesize-filter-mobile', function(){
        //reset output
        $('#findtyre_items').html('');
        $('#findtyre_catedd').html('');
        $('#findtyre_output').hide();
        $('#findtyre_result_oetyre .box-colspace-result').html('');

        var sel_size = parseInt($(this).val());

        loading_show();
        findtyre_filter('inno-tyre-by-vehicle','&tyreact=loadvehicle_vehsize&filteroe=1&oe_size='+sel_size,loadvehicle_bydd_oesize);

    });
    // $('body').on('click', '#findtyre_vehicle_cate .type-cate label', filter_item_bycate); // from-rfq

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
            findtyre_filter('inno-tyre-by-size','&tyreact=loadsize_result',loadsize_item);
        }
    });
    $('select[name=veh_size_opt_load] , select[name=veh_size_opt_speed]').change(function(){
        $('#findtyre_output').html('');//reset output
        loading_show();
        findtyre_filter('inno-tyre-by-size','&tyreact=loadsize_optional',loadsize_optitem);
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

    //OEtyre result
    $('body').on('click', '.box-colspace h2.title', function(){
        if($(this).parent('.box-colspace').find('.box-colspace-content').is(':hidden')){
            $(this).removeClass('box-close').addClass('box-open');
            $(this).parent('.box-colspace').find('.box-colspace-content').slideDown();
        }
        else{
            $(this).removeClass('box-open').addClass('box-close');
            $(this).parent('.box-colspace').find('.box-colspace-content').slideUp();
        }
        return false;
    });

    function findtyre_preload(tyretype){
        var datas = [];

        if(tyretype == 'vehicle'){
            var totalcat = $.cookie('ftveh[totalcat]');

            datas.push({ name: "action",    value: "inno-tyre-by-vehicle" });
            datas.push({ name: "security",  value: $('input#ajax-nonce').val() });
            datas.push({ name: "tyreact",   value: "loadvehicle_preload" });
            datas.push({ name: "totalcat",  value: totalcat });

            for(var i = 0, j = totalcat; i<j; i++ ){
                datas.push({ name: "veh_cat["+i+"]", value: $.cookie("ftveh[vehcat]["+i+"]") });
            }
            // datas.push({ name: "tyre_cate", value: $.cookie('ftsize[cat]') });
            // datas.push({ name: "tyre_compare", value: $.cookie('ftcompare') });
            datas.push({ name: "tyre_cate", value: $.cookie('ftcate') });
            datas.push({ name: "tyre_compare", value: $.cookie('ftcompare') });
            datas.push({ name: "tyre_rof", value: $.cookie('ftrof') });
            datas.push({ name: "tyre_oeset", value: $.cookie('ftoeset') });

            findtyre_ajax($.param(datas),loadvehicle_preload);
        }else if(tyretype == 'size'){

            datas.push({ name: "action",    value: "inno-tyre-by-size" });
            datas.push({ name: "security",  value: $('input#ajax-nonce').val() });
            datas.push({ name: "tyreact",   value: "loadsize_preload" });

            datas.push({ name: "veh_size_field_1", value: $.cookie('ftsize[size1]') });
            datas.push({ name: "veh_size_field_2", value: $.cookie('ftsize[size2]') });
            datas.push({ name: "veh_size_field_3", value: $.cookie('ftsize[size3]') });
            datas.push({ name: "veh_size_opt_speed", value: $.cookie('ftsize[size_speed]') });
            datas.push({ name: "veh_size_opt_load", value: $.cookie('ftsize[size_load]') });
            // datas.push({ name: "tyrecate", value: $.cookie('ftsize[cat]') });
            // datas.push({ name: "tyre_compare", value: $.cookie('ftcompare') });
            datas.push({ name: "tyre_cate", value: $.cookie('ftcate') });
            datas.push({ name: "tyre_compare", value: $.cookie('ftcompare') });
            datas.push({ name: "tyre_rof", value: $.cookie('ftrof') });

            findtyre_ajax($.param(datas),loadsize_preload);
        }
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
                /*}else{
                    $.cookie('findtyre','vehicle');
                    window.location.reload();*/
                }
            }else if($('div.vehdd_size').length == 1){
                if($.cookie('findtyre')=='size'){
                    if($.cookie('ftsize[size3]')!=undefined && $.cookie('ftsize[size3]')!='') {
                        loading_show();
                    }
                    findtyre_preload('size');
                /*}else{
                    $.cookie('findtyre','size');
                    window.location.reload();*/
                }
            }
        }
    }

    function resultCallback(lineno){
        //this function is called whenever '$('#findtyre_output').html(output.html);' is set

        // console.log(lineno,'[find tyre vehicle] callback');
        $('[data-toggle="tooltip"]').tooltip(); //init tooltip after NEW results loaded

        // console.log(size_1.val());
        // console.log(size_2.val());
        // console.log(size_3.val());
        // console.log(size_speed.val());
        // console.log(size_load.val());
        // console.log(veh_0.val(), veh_0.find("optgroup option:selected").text() );
        // console.log(veh_1.val(), veh_1.children("option:selected").text() );
        // console.log(veh_2.val(), veh_2.children("option:selected").text() );
        // console.log(veh_3.val(), veh_3.children("option:selected").text() );
        
        console.log('evt');
        if(typeof dataLayer !== 'undefined'){
            console.log("push!");
            dataLayer.push({ 
                'event': 'findTyreSearch'
            });   
        }
        var pageURL ="";
        //baidu tracking
        /*
        if(size_1.val() ){
            console.log("size");
            var size1 = size_1.val();
            var size2 = size_2.val();
            var size3 = size_3.val();
            var optLoad = size_load.val();
            var optSpeed = size_speed.val();
            var pagePath = "/filter-tyre/find-tyre?type=size";
            console.log(size1,size2,size3,optLoad,optSpeed);
            pageURL = pagePath + "&first_number=" + size1 + "&second_number=" + size2 + "&third_number=" + size3 + "&opt-load=" + optLoad + "&opt-speed=" + optSpeed;
        }else{
            console.log("veh");
            var brand = veh_0.find("optgroup option:selected").text();
            var variant = veh_1.children("option:selected").text();
            var year = veh_2.children("option:selected").text();
            var model = veh_3.children("option:selected").text();
            console.log(brand,variant,year,model);
            var pagePath = "/filter-tyre/find-tyre?type=vehicle";
            pageURL = pagePath + "&brand=" + brand + "&variant=" + variant + "&model=" + model + "&year=" + year;
        }
        //Trigger on findTyreSearch execute this code
        _hmt.push (['_ trackPageview', pageURL]);
        */


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