function SalesPageAnalytics(product, analytics)
{
    analytics.track(product, 'pageview');


    var minutesOnPage = 0;
    window.setInterval(function(){

        minutesOnPage++;
        analytics.track(product, 'duration', minutesOnPage);

    }, 60 * 1000);


    var cookieName = 'SalesPageVisitCounter_' + product;
    var totalVisits = $.cookie(cookieName) || 0;
    jQuery.cookie(cookieName, ++totalVisits, { expires: 730 });


    jQuery('[data-buy-button]').click(function(){
        analytics.track(product, 'clickedBuyButton');
    });
}