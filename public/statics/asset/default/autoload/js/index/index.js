
$(document).ready(function(){
    $('.item1-slick1').each(function(index) {
        var src = $(this).attr('data-image');
        $('.banner-'+index).css('background-image', 'url(' + src + ')');
    });
})