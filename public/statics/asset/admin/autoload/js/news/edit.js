var ID_EVENT_CATE = '7';
var NewsEdit = {
    applyEventDate: function(){
        var categoryId = $('#categoryId').val();
        var eventDate = $('.event-date');
        eventDate.hide();
        if (categoryId == ID_EVENT_CATE) {
            eventDate.show();
        }
    }
};

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