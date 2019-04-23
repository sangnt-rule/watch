$(function(){
    AdminCommon.initializeManualUpdate('homepage');

    $('#btAddNew').click(function(){
        AdminCommon.goTo('/homepage/youtube-edit/');
    });
})