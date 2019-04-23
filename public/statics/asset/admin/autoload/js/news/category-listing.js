$(function(){
    AdminCommon.initializeManualUpdate('news');

    $('#btAddNew').click(function(){
        AdminCommon.goTo('/news/category-edit');
    });
})