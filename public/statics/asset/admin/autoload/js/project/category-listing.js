$(function(){
    AdminCommon.initializeManualUpdate('project');

    $('#btAddNew').click(function(){
        AdminCommon.goTo('/project/category-edit');
    });
})