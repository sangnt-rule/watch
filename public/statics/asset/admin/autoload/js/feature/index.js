var AdminFeatureIndex = {
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
                        var selected = data.feature_category_id == selectedValue ? 'selected' : '';
                        var html = '<option value="'+ data.feature_category_id +'" '+ selected +'>' + data.feature_category_name + '</option>';
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
                    if (data.fk_feature_category == categoryId) {
                        var selected = data.feature_sub_category_id == selectedValue ? 'selected' : '';
                        var html = '<option value="'+ data.feature_sub_category_id +'" '+ selected +'>' + data.feature_sub_category_name + '</option>';
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
            AdminFeatureIndex.buildCategory(this.value, 'category', $('#hiddenCategoryId').val());
        });
        if (locale.val()) {
            AdminFeatureIndex.buildCategory(locale.val(), 'category', $('#hiddenCategoryId').val());
        }
    }

    var category = $('#category');
    if (category) {
        category.change(function(){
            AdminFeatureIndex.buildSubCategory(this.value, 'subCategory', $('#hiddenSubCategoryId').val());
        });
        if (category.val()) {
            AdminFeatureIndex.buildSubCategory(category.val(), 'subCategory', $('#hiddenSubCategoryId').val());
        }
    }
})