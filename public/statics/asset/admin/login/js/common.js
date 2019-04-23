/**
 * Created by khoaldd on 23/06/2016.
 */

var CURRENT_URL = window.location.href.split('?')[0],
    $BODY = $('body'),
    $MENU_TOGGLE = $('#menu_toggle'),
    $SIDEBAR_MENU = $('#sidebar-menu'),
    $SIDEBAR_FOOTER = $('.sidebar-footer'),
    $LEFT_COL = $('.left_col'),
    $RIGHT_COL = $('.right_col'),
    $NAV_MENU = $('.nav_menu'),
    $FOOTER = $('footer');

var menu = {}
var layout = {}
$(document).ready(function(){
    menu.init();
    layout.fullScreen();
    layout.footer();
    layout.iCheck();
    layout.switchery();
    layout.table();
    layout.panelToolBox();
    layout.addPageDemo(false); // TRUE:Demo | FALSE: Live
});
layout.fullScreen = function(){
    $(".fScreen").each(function(){
        $(this).css({'min-height':$(window).height() - $('header').height()});
    });
}
layout.footer = function(){
    if($('.main-full').height() <= $(window).height() - 100 - $('.footer-full').height()){
        $('.footer-full').css({'position':'absolute','top':$(window).height() - $('.footer-full').height() + "px"});
    }
}
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
layout.iCheck = function () {
    // iCheck
    if ($("input.flat")[0]) {
        $(document).ready(function () {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });
    }
// /iCheck
}
layout.switchery = function () {
// Switchery
    if ($(".js-switch")[0]) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {
                color: '#26B99A'
            });
        });
    }
// /Switchery
}
layout.table = function(){
    // Table
    $('table input').on('ifChecked', function () {
        checkState = '';
        $(this).parent().parent().parent().addClass('selected');
        countChecked();
    });
    $('table input').on('ifUnchecked', function () {
        checkState = '';
        $(this).parent().parent().parent().removeClass('selected');
        countChecked();
    });

    var checkState = '';

    $('.bulk_action input').on('ifChecked', function () {
        checkState = '';
        $(this).parent().parent().parent().addClass('selected');
        countChecked();
    });
    $('.bulk_action input').on('ifUnchecked', function () {
        checkState = '';
        $(this).parent().parent().parent().removeClass('selected');
        countChecked();
    });
    $('.bulk_action input#check-all').on('ifChecked', function () {
        checkState = 'all';
        countChecked();
    });
    $('.bulk_action input#check-all').on('ifUnchecked', function () {
        checkState = 'none';
        countChecked();
    });
    function countChecked() {
        if (checkState === 'all') {
            $(".bulk_action input[name='table_records']").iCheck('check');
        }
        if (checkState === 'none') {
            $(".bulk_action input[name='table_records']").iCheck('uncheck');
        }

        var checkCount = $(".bulk_action input[name='table_records']:checked").length;

        if (checkCount) {
            $('.column-title').hide();
            $('.bulk-actions').show();
            $('.action-cnt').html(checkCount + ' Records Selected');
        } else {
            $('.column-title').show();
            $('.bulk-actions').hide();
        }
    }
}

layout.panelToolBox = function(){

// Panel toolbox
    $('.collapse-link').on('click', function() {
        var $BOX_PANEL = $(this).closest('.x_panel'),
            $ICON = $(this).find('i'),
            $BOX_CONTENT = $BOX_PANEL.find('.x_content');

        // fix for some div with hardcoded fix class
        if ($BOX_PANEL.attr('style')) {
            $BOX_CONTENT.slideToggle(200, function(){
                $BOX_PANEL.removeAttr('style');
            });
        } else {
            $BOX_CONTENT.slideToggle(200);
            $BOX_PANEL.css('height', 'auto');
        }

        $ICON.toggleClass('fa-chevron-up fa-chevron-down');
    });

    $('.close-link').click(function () {
        var $BOX_PANEL = $(this).closest('.x_panel');

        $BOX_PANEL.remove();
    });
// /Panel toolbox

}
layout.loadingOpen = function(time){
    var html = "";
    html +='<div class="loading_wrapper">';
    html +='<div class="loading">';
    html +='<div class="loading_top"></div>';
    html +='<div class="loading_left"></div>';
    html +='<div class="loading_right"></div>';
    html +='</div>';
    html +='</div>';
    if(!$(".loading_wrapper").length){
        $('body').append(html);
        if(time > 0){
            setTimeout(function(){
                layout.loadingClose();
            },time);
        };
    }
}
layout.loadingClose = function(){
    $(".loading_wrapper").remove();
}
layout.addPageDemo = function(bool){
    var html = "";
    html += '<li>';
    html += '<a href="#">Layout <!--<span class="caret"></span>--></a>';
    html += '<ul>';
    html += '<li><a href="form.html">Form</a></li>';
    html += '<li><a href="form_buttons.html">Form button</a></li>';
    html += '<li><a href="charts.html">Charts</a></li>';
    html += '<li><a href="echarts.html">Earth Charts</a></li>';
    html += '<li><a href="other_charts.html">Other Charts</a></li>';
    html += '<li><a href="table.html">Table</a></li>';
    html += '<li><a href="table_dynamic.html">Table Dynamic</a></li>';
    html += '<li><a href="page.html">Page blank</a></li>';
    html += '<li><a href="login.html">Login</a></li>';
    html += '<li><a href="404.html">404</a></li>';
    html += '</ul>';
    html += '</li>';
    if(bool){
        $("#header_menu ul:first-child").append(html);
    }
}