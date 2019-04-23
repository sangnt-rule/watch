/**
 * Created by khoaldd on 23/06/2016.
 */

var menu = {}
var layout = {}
$(document).ready(function(){
    menu.init();
    layout.footer();
});

menu.init = function(){
    var slideout = new Slideout({
        'panel': document.getElementById('wrapper'),
        'menu': document.getElementById('header_menu'),
        'side': 'right'
    });

    document.querySelector('#header_menu_btn').addEventListener('click', function() {
        slideout.toggle();
    });

    document.querySelector('#header_menu').addEventListener('click', function(eve) {
        if (eve.target.nodeName === 'A') { slideout.close(); }
    });
}
layout.footer = function(){
    if($('.main-full').height() <= $(window).height() - 100 - $('.footer-full').height()){
        $('.footer-full').css({'position':'fixed','top':$(window).height() - $('footer.footer-full').height() + "px"});
    }
}