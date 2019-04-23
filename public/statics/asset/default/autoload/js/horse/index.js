var HorseIndex = {
    showInfo: function(id){
        $.ajax({
            url: '/horse/ajax-get-info/',
            type: 'post',
            data: {
                id: id
            },
            success: function(response){
                var popup = $('#horseInfo');
                popup.html(response.html);
                popup.dialog({
                    modal: true,
                    width: '80%',
                    buttons: {
                        OK: function() {
                            $(this).dialog('close')
                        }
                    }
                });
            }
        });
    }
};

$(function(){
    $('.score').click(function(){
        HorseIndex.showInfo(this.rel);
    });
})
