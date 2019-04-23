/**
 * Created by Admin on 23-Dec-15.
 */
var AdminEdit = {
    partnerGroupId: 2,

    initializePartnerData: function(){
        var roleId = $('#fkRole').val();
        var partnerData = $('#partnerData');
        partnerData.hide();
        if (roleId == this.partnerGroupId) {
            partnerData.show();
        }
    }
};
$(function(){
    AdminCommon.initializeCheckAll();

    AdminEdit.initializePartnerData();
    $('#fkRole').change(function(){
        AdminEdit.initializePartnerData();
    });

    var form = $('#validate');
    if (form) {
        AdminCommon.addEventLoadingWhenSubmitForm(form);
    }
})