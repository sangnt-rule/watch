var AdminCommon = {
    notification: {
        error: {
            type: 'error',
            name: 'Lỗi',
            duration: 10000
        },
        success: {
            type: 'success',
            name: 'Thành công',
            duration: 3000
        },
        warning: {
            type: 'warning',
            name: 'Cảnh báo',
            duration: 5000
        },
        notice: {
            type: 'notice',
            name: 'Thông báo',
            duration: 5000
        },
        wrapperSelector: '#notification_wrapper',
        labelSelector: '#notification_label',
        messageSelector: '#notification_message',
        closeSelector: '#notification_close'
    },
    errorDiv: 'divErrorMsg',

    openNewWindow: function(url){
        window.open(url);
    },

    hideAllErrorMessage: function(){
        $('.errorMsg').hide();
        $('.input-error').removeClass('input-error');
    },

    getAdminUrl: function(path)
    {
        return '/' + path;
    },

    goTo: function(url) {
        window.location.href = url;
    },

    redirect: function(path){
        window.location.href = '/' + path;
    },

    refeshPage: function(){
        window.location.href = window.location.href;
    },

    openDialogProcessing: function(){
        $('#model_processing').swal({
            title: "Good job!",
            text: "You clicked the button!",
            icon: "success",
            button: "Aww yiss!",
        });
    },

    openDialogMessage: function(id, _callback){
        $('#' + id).dialog({
            modal: true,
            width: '400px',
            buttons: {
                OK: _callback ? _callback : function() {
                    $(this).dialog('close')
                }
            }
        });
    },

    openDialogAlert: function(message, callback){
        Swal.fire({
            width: 400,
            type: 'success',
            text: message ,
            onClose: () => {
            callback()
        }
        });
    },

    closeDialogProcessing: function() {
        this.closeDialogById('model_processing');
    },

    closeDialog: function(){
        $(this).closest('.ui-dialog-content').dialog('close');
    },

    closeDialogById: function(id){
        $('#' + id).dialog('close');
    },

    resetAppendedErrorMsg: function()
    {
        $('#' + this.errorDiv).html('');
    },

    randomText: function(nLength)
    {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < nLength; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    },

    displayFCK: function(id)
    {
        CKEDITOR.replace(id,{
            filebrowserImageBrowseUrl 	:
                 '/statics/asset/libs/js/editor/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=' +
                    '/statics/asset/libs/js/editor/ckeditor/filemanager/connectors/php/connector.php'
        });
    },

    initializeCheckAll: function()
    {
        $(".check-all").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    },

    getCheckAllValue: function()
    {
        var result = [];
        $('.check-items').each(function(){
            if (this.checked) {
                result.push(this.value);
            }
        });
        return result;
    },

    initializeManualUpdate: function(controllerName)
    {
        $('#manualUpdateElement').change(function(){
            if (this.value) {
                AdminCommon.submitManualUpdate(controllerName, this.value);
            }
        });
    },

    submitManualUpdate: function(controllerName, actionName)
    {
        var checked = this.getCheckAllValue();
        if (!checked.length) {
            //this.openDialogMessage('model_alertManualAction', null);
            AdminCommon.openDialogAlert('Để thực hiện chức năng này, bạn hãy chọn ít nhất 1 đơn vị dữ liệu');
            /*Swal.fire({
                width: 400,
                type: 'success',
                text: 'Để thực hiện chức năng này, bạn hãy chọn ít nhất 1 đơn vị dữ liệu' ,
                onClose: () => {
                    callback()
                }
            });*/
        } else {
            var params = {
                'manualUpdateId' : checked,
                'manualUpdateAction' : actionName,
                'manualUpdateUrl' : window.location.href
            };
            //this.openDialogProcessing();
            this.redirect( controllerName + '/manual-update/?' + this.encodeQueryData(params) );
        }
    },

    encodeQueryData: function(data)
    {
        var ret = [];
        for (var d in data)
            ret.push(encodeURIComponent(d) + "=" + encodeURIComponent(data[d]));
        return ret.join("&");
    },

    resetErrorMsg: function(data)
    {
        $('#' + this.errorDiv).html('');
    },

    appendErrorMsg: function(msg)
    {
        var html = '<div class="nNote nFailure hideit">';
        html    += '<p>' + msg + '</p>';
        html    += '</div>';
        $('#' + this.errorDiv).prepend(html);
    },

    appendSuccessMsg: function(msg)
    {
        var html = '<div class="nNote nSuccess hideit">';
        html    += '<p>' + msg + '</p>';
        html    += '</div>';
        $('#' + this.errorDiv).prepend(html);
    },

    disableAllValidationError: function() {
        $('.formError').hide();
    },

    addEventLoadingWhenSubmitForm: function(form){
        form.find('input[type=submit]:first').click(function(){
            if (form.validationEngine('validate')) {
                AdminCommon.openDialogProcessing();
            }
        });
    },

    buildProvinceOptions: function(countryId, provinceElementId, selectedValue){
        if (typeof jsonProvince !== 'undefined') {
            var provinceElement = $('#' + provinceElementId);
            if (provinceElement) {
                provinceElement.empty();
                provinceElement.append('<option value="">----------</option>');
                $.each(jsonProvince, function(id, data){
                    if (data.fk_region_country == countryId) {
                        var selected = data.region_province_id == selectedValue ? 'selected' : '';
                        var html = '<option value="'+ data.region_province_id +'" '+ selected +'>' + data.region_province_name + '</option>';
                        provinceElement.append(html);
                    }
                });
            }
        }
    },

    buildDistrictOptions: function(provinceId, districtElementId, selectedValue){
        if (typeof jsonDistrict !== 'undefined') {
            var districtElement = $('#' + districtElementId);
            if (districtElement) {
                districtElement.empty();
                districtElement.append('<option value="">----------</option>');
                $.each(jsonDistrict, function(id, data){
                    if (data.fk_region_province == provinceId) {
                        var selected = data.region_district_id == selectedValue ? 'selected' : '';
                        var html = '<option value="'+ data.region_district_id +'" '+ selected +'>' + data.region_district_name + '</option>';
                        districtElement.append(html);
                    }
                });
            }
        }
    },
    initNotificationDialog: function() {
        var self = this;
        $(self.notification.closeSelector).live('click', function(){
            $(self.notification.wrapperSelector).stop(true,true).fadeOut(200);
        });
    },
    showNotification: function(type, message, label, delay) {
        var self = this;
        label = label || type.name;
        delay = delay || type.duration;

        $(self.notification.wrapperSelector)
            .removeClass()
            .addClass('alert-box')
            .addClass(type.type)
        ;

        $(self.notification.messageSelector).empty();
        $(self.notification.labelSelector).html(label+':');

        $(self.notification.messageSelector).html(message);

        $('html, body').animate({
            scrollTop: 0
        }, 200);

        $(self.notification.wrapperSelector)
            .stop(true, true)
            // .show("drop", { direction: "right" }, 200)
            .fadeIn(200)
            .animate({opacity:1},parseInt(delay))
            .fadeOut(300)
        ;
    },
    getValueAsArray: function(selector) {
        return $(selector).map(function(){return $(this).text();}).get();
    },

    focusScanInputBySelector: function(selector, clearContent) {
        clearContent = clearContent || false;

        if (clearContent) {
            $(selector).attr('value', '');
        }

        $(selector).focus().select();
    },

    isItemUId: function(param){
        var result = false;
        param = param.toUpperCase();
        param = param.trim();
        var firstChar = param.slice(0,1);
        if (firstChar == '1') {
            result = true;
        }
        return result;
    },

    isPackageCode: function(param){
        var result = false;
        param = param.toUpperCase();
        param = param.trim();
        var firstChar = param.slice(0,1);
        if (firstChar == '9') {
            result = true;
        }
        return result;
    },

    inArray : function(value, arr)
    {
        var n = arr.length;
        var i=0;
        for (i=0; i<n; i++) {
            if (arr[i]==value) {
                return true;
            }
        }
        return false;
    }
};


$(document).ready(function(){
    /*
    var current = $('ul#menu').find('a.current');
    if (current) {
        var resource = current.parent('li').parent().parent().find('a.resource');
        if (resource) {
            resource.removeClass('exp');
            var module = resource.parent('li').parent().parent().find('a.module');
            if (module) {
                module.removeClass('exp');
                module.addClass('active');
            }
        }
    }

    $('.exp').collapsible({
        defaultOpen: 'current',
        cookieName: 'navAct',
        cssOpen: 'active',
        cssClose: 'inactive',
        speed: 200
    });
    */

    // AdminCommon.initializeCheckAll();
    // AdminCommon.hideAllErrorMessage();
    // AdminCommon.initNotificationDialog();

    // $('#btGlobalSearch').click(function(){
    //     var param = $('#paramGlobalSearch');
    //     var paramValue = param.val();
    //     if (paramValue) {
    //         var url = '';
    //         if (AdminCommon.isItemUId(paramValue)) {
    //             url = '/item/detail/?uid=';
    //         } else if (AdminCommon.isPackageCode(paramValue)) {
    //             url = '/packing/detail/?code=';
    //         } else {
    //             url = '/orders/detail/?on=';
    //         }
    //         paramValue = paramValue.toUpperCase();
    //         window.location.href = url + paramValue;
    //     } else {
    //         param.focus();
    //     }
    // });
});