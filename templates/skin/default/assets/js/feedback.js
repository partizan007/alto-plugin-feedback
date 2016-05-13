/*---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Project URI: http://altocms.com
 * @Description: Advanced Community Engine
 * @Copyright: Alto CMS Team
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 */

;var ls = ls || { };

(function($, ls){
    $(function(){
        var formFeedback = $('.js-feedback-form');

        formFeedback.submit(function(){
            var url = ls.routerUrl('feedback');
            ls.ajaxSubmit(url, $(this), function(response){
                var messageError = '', messageNotice = '';

                if (!response) {
                    messageError = 'System error #1001';
                } else {
                    if (response.bStateError) {
                        messageError = response.sMsg;
                    } else {
                        messageNotice = response.sMsg;
                    }
                    if (response.aErrFields) {
                        $.each(response.aErrFields, function(index, item){
                            $('[name=' + index + ']').addClass('error');
                        });
                        $('.input-text.error:first').focus();
                    }
                }
                if (messageError) {
                    ls.msg.error(null, messageError);
                } else {
                    formFeedback.hide();
                    $('.js-feedback-result').html(messageNotice).addClass('system-message-notice').show();
                }
            });
            return false;
        });
    });
})(jQuery, ls);

// EOF