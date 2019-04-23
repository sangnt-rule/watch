$(function(){
    AdminCommon.initializeManualUpdate('service');
    $('#btAddNew').click(function(){
        AdminCommon.goTo('/service/category-edit');
    });
})