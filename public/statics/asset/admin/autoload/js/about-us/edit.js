var AdminAboutUsEdit = {
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
    }
};

$(function(){
    $('.fck').each(function(){
        AdminCommon.displayFCK(this.id);
    });

    var form = $('#validate');
    if (form) {
        AdminCommon.addEventLoadingWhenSubmitForm(form);
    }

    var category = $('#categoryId');
    if (category) {
        category.change(function(){
            AdminAboutUsEdit.buildSubCategory(this.value, 'subCategory', 0);
        });
    }
})