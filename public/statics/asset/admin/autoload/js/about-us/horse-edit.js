$(function(){
    var form = $('#validate');
    if (form) {
        AdminCommon.addEventLoadingWhenSubmitForm(form);
    }
    $('.fck').each(function(){
        AdminCommon.displayFCK(this.id);
    });
})