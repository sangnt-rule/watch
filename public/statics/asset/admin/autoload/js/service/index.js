var AdminServiceIndex = {
    buildServiceCategory: function(localeId, serviceCategoryElementId, selectedValue)
    {
        if (typeof jsonServiceCategory !== 'undefined') {
            var serviceCategoryElement = $('#' + serviceCategoryElementId);
            if (serviceCategoryElement) {
                var firstOption = serviceCategoryElement.find('option:first');

                serviceCategoryElement.empty();
                serviceCategoryElement.append('<option value="">' + firstOption.text() + '</option>');
                $.each(jsonServiceCategory, function(id, data){
                    if (data.fk_locale == localeId) {
                        var selected = data.service_category_id == selectedValue ? 'selected' : '';
                        var html = '<option value="'+ data.service_category_id +'" '+ selected +'>' + data.service_category_name + '</option>';
                        serviceCategoryElement.append(html);
                    }
                });
            }
        }
    }
};

$(function(){
    AdminCommon.initializeManualUpdate('service');

    var locale = $('#locale');
    if (locale) {
        locale.change(function(){
            AdminServiceIndex.buildServiceCategory(this.value, 'serviceCategory', $('#hiddenServiceCategoryId').val());
        });
        if (locale.val()) {
            AdminServiceIndex.buildServiceCategory(locale.val(), 'serviceCategory', $('#hiddenServiceCategoryId').val());
        }
    }

    $('#btAddNew').click(function(){
        AdminCommon.goTo('/service/edit');
    });
})