$(function(){
    AdminCommon.initializeManualUpdate('report');
    $('#btAddNew').click(function(){
        AdminCommon.goTo('/report/category-edit');
    });
})