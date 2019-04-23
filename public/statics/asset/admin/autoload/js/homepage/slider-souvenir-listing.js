$(function(){
    AdminCommon.initializeManualUpdate('homepage');
    $('#btAddNew').click(function(){
        AdminCommon.goTo('/homepage/slider-souvenir-edit/');
    });
})