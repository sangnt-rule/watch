$(function(){
    AdminCommon.initializeManualUpdate('feature');
    $('#btAddNew').click(function(){
        AdminCommon.goTo('/feature/category-edit');
    });
})