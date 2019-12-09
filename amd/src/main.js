define(
    ['jquery', 'core/ajax', 'core/notification', 'core/str', 'core/url', 'core/modal_factory', 'core/modal_events'],
    function($, Ajax, Notification, Str, Url,  ModalFactory, ModalEvents) {
    return {
        watchTimeleft: function(uniqid) {
            if (this.debug > 5) console.log('MAIN.watchTimeleft(uniqid)', uniqid);
            var self = this;

            setInterval(function() {
                $('#sessions-' + uniqid).find('.timeleft').each(function(){
                    var timeleft = +$(this).attr('data-timeleft');
                    timeleft -= 1;
                    if (timeleft < 0) {
                        $(this).closest('li').remove();
                    } else {
                        $(this).attr('data-timeleft', timeleft);
                        console.log('timeleft: ', timeleft);
                        $(this).html(new Date(timeleft * 1000).toISOString().substr(11, 8));
                    }
                });
            }, 1000);
        },
    };
});
