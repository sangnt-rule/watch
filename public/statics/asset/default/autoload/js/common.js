var Common = {
    goTo: function(url){
        window.location.href = url;
    },

    setBookingProcess: function(v){
        var button = $('#booking-button');
        var loading = $('#booking-loading');
        button.hide();
        loading.hide();
        if (v == 'loading') {
            loading.show();
        } else {
            button.show();
        }
    },

    isMobile: function(){
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    },
    addEventLoadingWhenSubmitForm: function(form){
        form.find('input[type=submit]:first').click(function(){
            if (form.validationEngine('validate')) {
                Common.openDialogProcessing();
            }
        });
    },


    openDialogProcessing: function() {
        $('#model_processing').dialog({
            modal: true,
            width: '400px',
            closeOnEscape: false,
            dialogClass: 'noclose'
        });
    },
    openDialogAlert: function(message, callback){
        $('#contentAlert').html(message);

        if (callback === undefined) {
            callback = function() {
                $(this).dialog('close')
            }
        }

        $('#model_alert').dialog({
            modal: true,
            width: '400px',
            closeOnEscape: false,
            dialogClass: 'noclose',
            buttons: {
                OK: callback
            }
        });
    },
    redirect: function(path){
        window.location.href = '/' + path;
    },
}
$(function(){
    $('#validate').validationEngine();
    /*
    var formBooking = $('#formBooking');
    if (formBooking) {
        formBooking.validationEngine();
        Common.setBookingProcess('');
        formBooking.submit(function(){
            if (formBooking.validationEngine('validate')) {
                Common.setBookingProcess('loading');
            }
            return true;
        });
    }

    var formSearch = $('#formSearch');
    if (formSearch) {
        formSearch.validationEngine();
    }

    if( Common.isMobile() ) {
        $('.fck-content img').each(function(){
            var e = $(this);
            e.removeAttr('style');
            e.removeAttr('width');
            e.removeAttr('height');
            e.attr('style', 'width:95%');
        });
        $('.fck-content input[type=image]').each(function(){
            var e = $(this);
            e.removeAttr('style');
            e.removeAttr('width');
            e.removeAttr('height');
            e.attr('style', 'width:95%');
        });
    }
     */

    if (Common.isMobile()) {
        $('#menuSponsor').hide();
    }
});