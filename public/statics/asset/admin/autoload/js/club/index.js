var AdminClubIndex = {
    buildClubCategory: function(localeId, clubCategoryElementId, selectedValue)
    {
        if (typeof jsonClubCategory !== 'undefined') {
            var clubCategoryElement = $('#' + clubCategoryElementId);
            if (clubCategoryElement) {
                var firstOption = clubCategoryElement.find('option:first');

                clubCategoryElement.empty();
                clubCategoryElement.append('<option value="">' + firstOption.text() + '</option>');
                $.each(jsonClubCategory, function(id, data){
                    if (data.fk_locale == localeId) {
                        var selected = data.club_category_id == selectedValue ? 'selected' : '';
                        var html = '<option value="'+ data.club_category_id +'" '+ selected +'>' + data.club_category_name + '</option>';
                        clubCategoryElement.append(html);
                    }
                });
            }
        }
    }
};

$(function(){
    AdminCommon.initializeManualUpdate('club');

    var locale = $('#locale');
    if (locale) {
        locale.change(function(){
            AdminClubIndex.buildClubCategory(this.value, 'clubCategory', $('#hiddenClubCategoryId').val());
        });
        if (locale.val()) {
            AdminClubIndex.buildClubCategory(locale.val(), 'clubCategory', $('#hiddenClubCategoryId').val());
        }
    }

    $('#btAddNew').click(function(){
        AdminCommon.goTo('/club/edit');
    });
})