$(function(){
    AdminCommon.initializeManualUpdate('partner');

    $('#btAddNew').click(function(){
        AdminCommon.goTo('/partner/category-edit');
    });
})