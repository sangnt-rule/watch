$(function(){
    if (Common.isMobile()) {
        $('.youtube iframe').each(function(){
            $(this).attr('width', '100%');
            $(this).removeAttr('height');
        })
    }
})