/**
 * Created by x on 5/22/2015.
 */
jQuery(document).ready(function($) {

$('.ht_add_new_size').click(function(){
    $('.ht_add_new_size img').show();
    $.post(ajaxurl, {action: 'add_select_type_admin'}, function (result) {
        var res = $.parseJSON(result);
        if (res.status == 1) {
            $('.ht_add_new_size img').hide();
            $('.list_size_tyre').append(res.html);
            select_auto();
            ht_remove();
        }
    })
})
select_auto();
    ht_remove();
function select_auto(){
    $(".select_size").searchable({
        exactMatch: false,                      // Exact matching on search
        wildcards: true,                        // Support for wildcard characters (*, ?)
        ignoreCase: true,                       // Ignore case sensitivity
        latency: 200,                           // how many millis to wait until starting search
        warnMultiMatch: 'top {0} matches ...',  // string to append to a list of entries cut short by maxMultiMatch
        warnNoMatch: 'no matches ...',          // string to show in the list when no entries match
        zIndex: 'auto'
    });
};
    function ht_remove(){
        $('.ht_delete').click(function () {
            $(this).parents('.size_item').remove();
        })
    }

});

/* OETYRE */
jQuery(document).ready(function($) {

    $('.ht_add_new_oetyre').click(function(){
        //clone sample combi
        var clone = $('.ht_sample_oetyre_item').find('div.ht_oetyre_item').clone();
        clone.find('select.sample_oecate').addClass('oetyre_vehcat_dd').attr('name', 'ht_select_oetyre_vehicle[]').removeClass('sample_oecate');
        clone.find('select.sample_oesize').addClass('oetyre_size_dd').attr('name', 'ht_select_oetyre_size[]').removeClass('sample_oesize');
        clone.appendTo( $('.list_oetyre_box') );
        oetyre_select_vehicle();
        oetyre_select_size();
        oetyre_remove();
    })


    $('body').on('change', '.oetyre_vehcat_dd', function(){

        var vehid = $(this).val();
        var postid = $('input#post_ID').val();

        var row_parent = $(this).closest('.ht_oetyre_dd');
        var row_size = row_parent.find('select.oetyre_size_dd');

        if(vehid==0){
            row_size.find("option:gt(0)").remove(); //remove all options except the 1st
        }else{
            row_size.html("<option>Loading...</option>");
            $.post(ajaxurl,
                {action: 'add_select_oetyre_admin',
                    security: $('input#ajax-nonce').val(),
                    veh_id:vehid,
                    post_id:postid },
                function (result) {
                var res = $.parseJSON(result);
                if (res.status == 1) {
                    row_size.html(res.html);
                    oetyre_select_size();
                }
            });
        }
    });

    function oetyre_select_vehicle(){
        $(".oetyre_vehcat_dd").searchable({
            exactMatch: false,                      // Exact matching on search
            wildcards: true,                        // Support for wildcard characters (*, ?)
            ignoreCase: true,                       // Ignore case sensitivity
            latency: 200,                           // how many millis to wait until starting search
            warnMultiMatch: 'top {0} matches ...',  // string to append to a list of entries cut short by maxMultiMatch
            warnNoMatch: 'no matches ...',          // string to show in the list when no entries match
            zIndex: 'auto'
        });
    };

    function oetyre_select_size(){
        $(".oetyre_size_dd").searchable({
            exactMatch: false,                      // Exact matching on search
            wildcards: true,                        // Support for wildcard characters (*, ?)
            ignoreCase: true,                       // Ignore case sensitivity
            latency: 200,                           // how many millis to wait until starting search
            warnMultiMatch: 'top {0} matches ...',  // string to append to a list of entries cut short by maxMultiMatch
            warnNoMatch: 'no matches ...',          // string to show in the list when no entries match
            zIndex: 'auto'
        });
    };

    function oetyre_remove(){
        $('.ht_oetyre_delete').click(function () {
            $(this).parents('.ht_oetyre_item').remove();
        })
    }

    //pre-call
    oetyre_select_vehicle();
    oetyre_select_size();
    oetyre_remove();

});