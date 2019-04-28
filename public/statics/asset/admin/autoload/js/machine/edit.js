var MachineEdit = {
    productEvent: '',
    success : function (message, url) {
        AdminCommon.openDialogAlert(message, function () {
            AdminCommon.redirect(url);
        });

    },
    error : function (message,productId){
        AdminCommon.openDialogAlert(message);
    }
};
$(document).ready(function () {
    $("#validate").validationEngine();
    $('.fck').each(function(){
        AdminCommon.displayFCK(this.id);
    });
});