var AdminAboutUsIndex = {
    buildCategory: function(localeId, categoryId, selectedValue)
    {
        if (typeof jsonCategoryData !== 'undefined') {
            this.resetSubCategory('subCategory');
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
    },

    buildSubCategory: function(categoryId, subCategoryId, selectedValue)
    {
        if (typeof jsonSubCategoryData !== 'undefined') {
            var subCategoryElement = $('#' + subCategoryId);
            if (subCategoryElement) {
                var firstOption = subCategoryElement.find('option:first');

                subCategoryElement.empty();
                subCategoryElement.append('<option value="">' + firstOption.text() + '</option>');
                $.each(jsonSubCategoryData, function(id, data){
                    if (data.fk_about_us_category == categoryId) {
                        var selected = data.about_us_sub_category_id == selectedValue ? 'selected' : '';
                        var html = '<option value="'+ data.about_us_sub_category_id +'" '+ selected +'>' + data.about_us_sub_category_name + '</option>';
                        subCategoryElement.append(html);
                    }
                });
            }
        }
    },

    resetSubCategory: function(subCategoryId) {
        var subCategoryElement = $('#' + subCategoryId);
        if (subCategoryElement) {
            var firstOption = subCategoryElement.find('option:first');
            subCategoryElement.empty();
            subCategoryElement.append('<option value="">' + firstOption.text() + '</option>');
        }
    }
};

$(function(){
    AdminCommon.initializeManualUpdate('about-us');

    var locale = $('#locale');
    if (locale) {
        locale.change(function(){
            AdminAboutUsIndex.buildCategory(this.value, 'category', $('#hiddenCategoryId').val());
        });
        if (locale.val()) {
            AdminAboutUsIndex.buildCategory(locale.val(), 'category', $('#hiddenCategoryId').val());
        }
    }

    var category = $('#category');
    if (category) {
        category.change(function(){
            AdminAboutUsIndex.buildSubCategory(this.value, 'subCategory', $('#hiddenSubCategoryId').val());
        });
        if (category.val()) {
            AdminAboutUsIndex.buildSubCategory(category.val(), 'subCategory', $('#hiddenSubCategoryId').val());
        }
    }
})