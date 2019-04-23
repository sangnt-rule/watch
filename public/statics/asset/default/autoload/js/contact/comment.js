var ContactComment = {
    refreshCaptcha: function(){
        var img = $('#imageCaptcha');
        var src = '/captcha.jpg?m=' + Math.random();
        img.attr('src', src);
    }
}

$(function(){
    $('#btRefreshCaptcha').click(function(){
        ContactComment.refreshCaptcha();
    });
    $('#formComment').validationEngine();
})