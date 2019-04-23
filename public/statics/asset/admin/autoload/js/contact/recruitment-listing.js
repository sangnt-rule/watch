$(function(){
    AdminCommon.initializeManualUpdate('contact');

    $('#btAddNew').click(function(){
        AdminCommon.goTo('/contact/recruitment-edit/');
    });
})