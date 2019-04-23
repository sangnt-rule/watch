var AdminMemberIndex = {
    buildMemberCategory: function(localeId, memberCategoryElementId, selectedValue)
    {
        if (typeof jsonMemberCategory !== 'undefined') {
            var memberCategoryElement = $('#' + memberCategoryElementId);
            if (memberCategoryElement) {
                var firstOption = memberCategoryElement.find('option:first');

                memberCategoryElement.empty();
                memberCategoryElement.append('<option value="">' + firstOption.text() + '</option>');
                $.each(jsonMemberCategory, function(id, data){
                    if (data.fk_locale == localeId) {
                        var selected = data.member_category_id == selectedValue ? 'selected' : '';
                        var html = '<option value="'+ data.member_category_id +'" '+ selected +'>' + data.member_category_name + '</option>';
                        memberCategoryElement.append(html);
                    }
                });
            }
        }
    }
};

$(function(){
    AdminCommon.initializeManualUpdate('member');

    var locale = $('#locale');
    if (locale) {
        locale.change(function(){
            AdminMemberIndex.buildMemberCategory(this.value, 'memberCategory', $('#hiddenMemberCategoryId').val());
        });
        if (locale.val()) {
            AdminMemberIndex.buildMemberCategory(locale.val(), 'memberCategory', $('#hiddenMemberCategoryId').val());
        }
    }

    $('#btAddNew').click(function(){
        AdminCommon.goTo('/member/edit');
    });
})