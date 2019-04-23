/**
 * Created by nhannvt on 10/21/2015.
 */
var AdminRoleIndex = {
    initCheckAll:function(){
        var lengthChecked = $(".formRow .aclRow input:checkbox:checked").length;
        var length = $(".formRow .aclRow input:checkbox").length;
        if(length == lengthChecked){
            $(".titleIcon input:checkbox").attr('checked', true);
            $(".titleIcon input:checkbox").closest('.checker > span').addClass('checked');
        }
    }
};
$(function(){
    $(".titleIcon input:checkbox").click(function() {
        var checkedStatus = this.checked;
        $(".formRow .aclRow input:checkbox").each(function() {
            this.checked = checkedStatus;
            if (checkedStatus == this.checked) {
                $(this).closest('.checker > span').removeClass('checked');
            }
            if (this.checked) {
                $(this).closest('.checker > span').addClass('checked');
            }
        });
    });
    AdminRoleIndex.initCheckAll();

    var form = $('#validate');
    if (form) {
        AdminCommon.addEventLoadingWhenSubmitForm(form);
    }
})
