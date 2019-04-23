var AdminAboutUsSubCategoryListing = {
    buildCategory: function(localeId, categoryId, selectedValue)
    {
        if (typeof jsonCategoryData !== 'undefined') {
            var categoryElement = $('#' + categoryId);
            if (categoryElement) {
                var firstOption = categoryElement.find('option:first');

                categoryElement.empty();
                categoryElement.append('<option value="">' + firstOption.text() + '</option>');
                $.each(jsonCategoryData, function(id, data){
                    if (data.fk_locale == localeId) {
                        var selected = data.about_us_category_id == selectedValue ? 'selected' : '';
                        var html = '<option value="'+ data.about_us_category_id +'" '+ selected +'>' + data.about_us_category_name + '</option>';
                        categoryElement.append(html);
                    }
                });
            }
        }
    }
};

$(function(){
    AdminCommon.initializeManualUpdate('about-us');

    var locale = $('#locale');
    if (locale) {
        locale.change(function(){
            AdminAboutUsSubCategoryListing.buildCategory(this.value, 'category', $('#hiddenCategoryId').val());
        });
        if (locale.val()) {
            AdminAboutUsSubCategoryListing.buildCategory(locale.val(), 'category', $('#hiddenCategoryId').val());
        }
    }

    var btAddNew = $('#btAddNew');
    if (btAddNew) {
        var url = '/about-us/sub-category-edit';
        var category = $('#category');
        if (category.val()) {
            url = url + '/?c=' + category.val();
        }
        btAddNew.click(function(){
            AdminCommon.goTo(url);
        });
    }
})