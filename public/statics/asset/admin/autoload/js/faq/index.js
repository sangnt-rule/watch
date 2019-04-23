var AdminFaqIndex = {
    buildFaqCategory: function(localeId, faqCategoryElementId, selectedValue)
    {
        if (typeof jsonFaqCategoryData !== 'undefined') {
            var faqCategoryElement = $('#' + faqCategoryElementId);
            if (faqCategoryElement) {
                var firstOption = faqCategoryElement.find('option:first');

                faqCategoryElement.empty();
                faqCategoryElement.append('<option value="">' + firstOption.text() + '</option>');
                $.each(jsonFaqCategoryData, function(id, data){
                    if (data.fk_locale == localeId) {
                        var selected = data.faq_category_id == selectedValue ? 'selected' : '';
                        var html = '<option value="'+ data.faq_category_id +'" '+ selected +'>' + data.faq_category_name + '</option>';
                        faqCategoryElement.append(html);
                    }
                });
            }
        }
    }
};

$(function(){
    AdminCommon.initializeManualUpdate('faq');

    var locale = $('#locale');
    if (locale) {
        locale.change(function(){
            AdminFaqIndex.buildFaqCategory(this.value, 'faqCategory', $('#hiddenFaqCategoryId').val());
        });
        if (locale.val()) {
            AdminFaqIndex.buildFaqCategory(locale.val(), 'faqCategory', $('#hiddenFaqCategoryId').val());
        }
    }
})