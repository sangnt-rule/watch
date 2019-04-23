$(function(){
    AdminCommon.initializeManualUpdate('admin-resource');

    $('#btAddNew').click(function(){
        AdminCommon.redirect('admin-resource/edit/?m=' + $('#m').val())
    });
});