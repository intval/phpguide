(function () {

    // Don't do anything for small resolutions
    if(jQuery(window).width() < 780)
        return;

    var COOKIE_NAME = 'ouibounceCount';
    var MODAL_WINDOW_ID = 'ouibounce-modal';
    var IGNORED_PAGES = [/^\/oopbook/, '/^\/subscription\/approve/'];

    for (var i = 0, L = IGNORED_PAGES.length; i < L; i++)
        if (document.location.pathname.match(IGNORED_PAGES[i]))
            return;

    jQuery(document).ready(function () {

        var modal = jQuery('#ouibounce-modal .modal');
        var POPUP_NAME = modal.data('popupname');
        var VARIANT = modal.data('variant');

        var displayCount = parseInt(jQuery.cookie(COOKIE_NAME), 10);
        var isModalShown = false;
        var _ouibounce = ouibounce(document.getElementById(MODAL_WINDOW_ID), {

            aggressive: displayCount < 2,
            timer: 0,
            callback: function () {
                window.Analytics.track(
                    'promotions',
                    'popupopen',
                    POPUP_NAME,
                    {source: 'ouibounce', variant: VARIANT}
                );
                jQuery.cookie(COOKIE_NAME, displayCount + 1, {expires: 777});
                isModalShown = true;
            }

        });

        function closeModal(event) {
            if (!isModalShown) return;

                jQuery('#' + MODAL_WINDOW_ID).hide();
                _ouibounce.disable();
                window.Analytics.track('promotions', 'closepopup', POPUP_NAME,
                    {
                        source: 'ouibounce',
                        action: event.data.action,
                        variant: VARIANT
                    });

            isModalShown = false;
        }

        jQuery('body').on('click', {action: 'bodymouseclick'} ,closeModal);
        jQuery('#ouibounce-modal-forward-close').on(
            'click',
            {action: 'notinterestedbtn'},
            function(e){
                e.stopPropagation();
                closeModal(e);
            }
        );

        jQuery(document).keyup(function (e) {
            if (e.keyCode == 27) {
                closeModal({data:{action:'escpaekeydown'}});
                e.stopPropagation();
            }
        });

        jQuery('#ouibounce-modal-forward-btn').on('click', function (e) {
            e.stopPropagation();
            window.Analytics.track(
                'promotions',
                'goto',
                POPUP_NAME,
                {
                    source: 'ouibounce',
                    variant: VARIANT
                }
            );
            document.location = jQuery(this).data('url');
        });

    });
}());

