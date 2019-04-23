$(function(){
    AdminCommon.initializeManualUpdate('recruitment');
    $('#btAddNew').click(function(){
        AdminCommon.goTo('/recruitment/edit');
    });
});