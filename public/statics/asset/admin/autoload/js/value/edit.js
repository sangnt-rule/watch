$(function(){
    $('.fck').each(function(){
        AdminCommon.displayFCK(this.id);
    });

    var form = $('#validate');
    if (form) {
        AdminCommon.addEventLoadingWhenSubmitForm(form);
    }

    NewsEdit.applyEventDate();
    $('#categoryId').change(function(){
        NewsEdit.applyEventDate();
    });
})