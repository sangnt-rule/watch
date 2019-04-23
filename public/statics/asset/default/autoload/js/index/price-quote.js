$(function(){
    Common.addEventLoadingWhenSubmitForm($('#validate'));
});
var priceQuote = {
    success : function (message) {
        Common.openDialogAlert(message, function () {
            Common.redirect('price-quote.html');
        });
    },
    error : function (message,productId){
        Common.openDialogAlert(message);
    }
};
