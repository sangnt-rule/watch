$(function(){
    AdminCommon.initializeManualUpdate('value');

    $('#btAddNew').click(function(){
        AdminCommon.goTo('/value/category-edit');
    });
})