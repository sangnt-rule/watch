var AdminReportIndex = {
    buildReportCategory: function(localeId, reportCategoryElementId, selectedValue)
    {
        if (typeof jsonReportCategory !== 'undefined') {
            var reportCategoryElement = $('#' + reportCategoryElementId);
            if (reportCategoryElement) {
                var firstOption = reportCategoryElement.find('option:first');

                reportCategoryElement.empty();
                reportCategoryElement.append('<option value="">' + firstOption.text() + '</option>');
                $.each(jsonReportCategory, function(id, data){
                    if (data.fk_locale == localeId) {
                        var selected = data.report_category_id == selectedValue ? 'selected' : '';
                        var html = '<option value="'+ data.report_category_id +'" '+ selected +'>' + data.report_category_name + '</option>';
                        reportCategoryElement.append(html);
                    }
                });
            }
        }
    }
};

$(function(){
    AdminCommon.initializeManualUpdate('report');

    var locale = $('#locale');
    if (locale) {
        locale.change(function(){
            AdminReportIndex.buildReportCategory(this.value, 'reportCategory', $('#hiddenReportCategoryId').val());
        });
        if (locale.val()) {
            AdminReportIndex.buildReportCategory(locale.val(), 'reportCategory', $('#hiddenReportCategoryId').val());
        }
    }

    $('#btAddNew').click(function(){
        AdminCommon.goTo('/report/edit');
    });
})