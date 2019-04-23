$(function(){
    AdminCommon.initializeManualUpdate('about-us');

    $('#btAddNew').click(function(){
        AdminCommon.goTo('/about-us/horse-edit/');
    });
})