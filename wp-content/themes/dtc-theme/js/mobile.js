jQuery(document).ready(function ($) {

    function toggleBreakpoints() {
        Reusables.Breakpoints.on('body')
            .define([768, Infinity], {
                name: 'breakpoints-768'
            });
    }
    toggleBreakpoints();

    function toggleTinyNav(){
        var menu = $('.js-toggle-tinynav .menu').tinyNav({
            active: 'current-menu-item'
        });
    }
    toggleTinyNav();

    function toggleCompare() {
        var compareBox = $('.compare-top-box');
        compareBox.find('.compare-image-thumbnail').click(function(){
            var thumbnail = $(this);

            var parentBox = thumbnail.closest('.compare-top-box');
            if (parentBox.hasClass('active')) {
                parentBox.removeClass('active');
            }
            else {
                compareBox.removeClass('active');
                parentBox.addClass('active');
            }
        });
    }
    toggleCompare();

});