var AdminScheduleIndex = {
    buildScheduleCategory: function(localeId, scheduleCategoryElementId, selectedValue)
    {
        if (typeof jsonScheduleCategory !== 'undefined') {
            var scheduleCategoryElement = $('#' + scheduleCategoryElementId);
            if (scheduleCategoryElement) {
                var firstOption = scheduleCategoryElement.find('option:first');

                scheduleCategoryElement.empty();
                scheduleCategoryElement.append('<option value="">' + firstOption.text() + '</option>');
                $.each(jsonScheduleCategory, function(id, data){
                    if (data.fk_locale == localeId) {
                        var selected = data.schedule_category_id == selectedValue ? 'selected' : '';
                        var html = '<option value="'+ data.schedule_category_id +'" '+ selected +'>' + data.schedule_category_name + '</option>';
                        scheduleCategoryElement.append(html);
                    }
                });
            }
        }
    }
};

$(function(){
    AdminCommon.initializeManualUpdate('schedule');

    var locale = $('#locale');
    if (locale) {
        locale.change(function(){
            AdminScheduleIndex.buildScheduleCategory(this.value, 'scheduleCategory', $('#hiddenScheduleCategoryId').val());
        });
        if (locale.val()) {
            AdminScheduleIndex.buildScheduleCategory(locale.val(), 'scheduleCategory', $('#hiddenScheduleCategoryId').val());
        }
    }

    $('#btAddNew').click(function(){
        AdminCommon.goTo('/schedule/edit');
    });
})