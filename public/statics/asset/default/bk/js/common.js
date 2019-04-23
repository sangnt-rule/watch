/**
 * Created by khoaldd on 08/08/2016.
 */
var menu = {};
var page = {};
$(document).ready(function () {
    menu.init();
    page.slider();
});
menu.init = function () {
    var slideout = new Slideout({
        'panel': document.getElementById('panel'),
        'menu': document.getElementById('menu'),
        'padding': 256,
        'tolerance': 70,
        'side' : 'right'
    });

    // Toggle button
    document.querySelector('.h_btn_menu').addEventListener('click', function() {
        slideout.toggle();
    });
};
page.slider = function () {
    $('.bxslider').bxSlider({
        auto: true,
    });

    $('.partner_list_slider').bxSlider({
        slideWidth: 5000,
        minSlides: 2,
        maxSlides: 4,
        slideMargin: 10
    });
}