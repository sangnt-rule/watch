$(function(){
    AdminCommon.initializeManualUpdate('member');
    $('#btAddNew').click(function(){
        AdminCommon.goTo('/member/category-edit');
    });
})