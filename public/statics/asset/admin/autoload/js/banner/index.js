$(document).ready(function () {
    /*$(".check-all").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });*/
    AdminCommon.initializeManualUpdate('banner');
    AdminCommon.initializeCheckAll();
});