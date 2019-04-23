var AdminNewsIndex = {
    buildNewsCategory: function(localeId, newsCategoryElementId, selectedValue)
    {
        if (typeof jsonNewsCategory !== 'undefined') {
            var newsCategoryElement = $('#' + newsCategoryElementId);
            if (newsCategoryElement) {
                var firstOption = newsCategoryElement.find('option:first');

                newsCategoryElement.empty();
                newsCategoryElement.append('<option value="">' + firstOption.text() + '</option>');
                $.each(jsonNewsCategory, function(id, data){
                    if (data.fk_locale == localeId) {
                        var selected = data.news_category_id == selectedValue ? 'selected' : '';
                        var html = '<option value="'+ data.news_category_id +'" '+ selected +'>' + data.news_category_name + '</option>';
                        newsCategoryElement.append(html);
                    }
                });
            }
        }
    }
};

$(function(){
    AdminCommon.initializeManualUpdate('news');

    var locale = $('#locale');
    if (locale) {
        locale.change(function(){
            AdminNewsIndex.buildNewsCategory(this.value, 'newsCategory', $('#hiddenNewsCategoryId').val());
        });
        if (locale.val()) {
            AdminNewsIndex.buildNewsCategory(locale.val(), 'newsCategory', $('#hiddenNewsCategoryId').val());
        }
    }

    $('#btAddNew').click(function(){
        AdminCommon.goTo('/news/edit');
    });
})