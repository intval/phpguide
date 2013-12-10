window.Analytics = function(){};
window.Analytics.track = function(){};

(function(){

	/* Config */
	var analyticsConfnig = {
		mixPanel: '496f7a0765bbb30010591dac2998c72b',
		gac: 'UA-18788673-3',
		heap: '1092892794'
	};


	/* Don't collect stats on test env */
	if(/local(\.phpguide|host)/.test(window.location.host))
		return;


	/* MixPanel */
	(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f);b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==
	typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");for(g=0;g<i.length;g++)f(c,i[g]);
	b._i.push([a,e,d])};b.__SV=1.2}})(document,window.mixpanel||[]);

	mixpanel.init(analyticsConfnig.mixPanel);

	/* GA */
	window._gaq = _gaq = window._gaq || []; 
	_gaq.push(['_setAccount', analyticsConfnig.gac]); 
	_gaq.push(['_trackPageview']);
	load('http://www.google-analytics.com/ga.js');


	/* Heap analytics */
	window.heap=window.heap||[];
    window.heap.load=function(a){window._heapid=a;var b=document.createElement("script");b.type="text/javascript",b.async=!0,b.src=("https:"===document.location.protocol?"https:":"http:")+"//cdn.heapanalytics.com/js/heap.js";var c=document.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c);var d=function(a){return function(){heap.push([a].concat(Array.prototype.slice.call(arguments,0)))}},e=["identify","track"];for(var f=0;f<e.length;f++)heap[e[f]]=d(e[f])};
    window.heap.load(analyticsConfnig.heap);



    if(typeof(window.user) !== 'undefined' && typeof(window.user.id) !== 'undefined')
	{
		mixpanel.identify(window.user.id);
		
		_gaq.push(['_setCustomVar',
	      1,                   	// This custom var is set to slot #1.  Required parameter.
	      'customerId',     	// The name acts as a kind of category for the user activity.  Required parameter.
	      window.user.id,       // This value of the custom variable.  Required parameter.
	      1                    	// Sets the scope to session-level.  Optional parameter.
	   ]);
	}


    window.Analytics.track = function(category, eventName, data)
    {
        _gaq.push(['_trackEvent', category, eventName, data]);
        mixpanel.track(category + '/'  + eventName, {"data": data});
    };

})();



