$(function(){
    AdminCommon.initializeManualUpdate('admin-privilege');

    $('#btAddNew').click(function(){
        AdminCommon.redirect('admin-privilege/edit/?r=' + $('#r').val())
    });
});