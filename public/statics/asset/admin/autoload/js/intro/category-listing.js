$(function(){
    AdminCommon.initializeManualUpdate('intro');

    $('#btAddNew').click(function(){
        AdminCommon.goTo('/intro/category-edit');
    });
})