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
    }
}
$(function(){
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
    }*/

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
})