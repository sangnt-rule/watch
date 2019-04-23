$(function(){
    AdminCommon.initializeManualUpdate('club');
    $('#btAddNew').click(function(){
        AdminCommon.goTo('/club/category-edit');
    });
})