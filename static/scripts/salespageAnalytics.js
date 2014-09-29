function SalesPageAnalytics(product, analytics)
{

    var startTime = new Date();

    var cookieName = 'SalesPageVisitCounter_' + product;
    var totalVisits = $.cookie(cookieName) || 0;
    jQuery.cookie(cookieName, ++totalVisits, { expires: 730 });

    var userid = 0;
    if(typeof(window['user']) !== 'undefined' && typeof(window['user']['id']) !== 'undefined')
        userid = window['user']['id'];

    var visitData = {
        user: userid,
        referrer: document.referrer,
        secondsOnPage: 0,
        pageVisits: totalVisits
    };

    analytics.track(product, 'pageview', product, visitData);





    jQuery('[data-buy-button]').click(function(){
        analytics.track(product, 'clickedBuyButton', product, visitData);
    });

    jQuery(window).on('unload',function(){
        var msOnPage = new Date() - startTime;
        visitData.secondsOnPage = Math.round( msOnPage / 10) / 100;
        analytics.track(product, 'duration', product, visitData);
    });
}