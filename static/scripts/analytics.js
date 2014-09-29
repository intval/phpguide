window.Analytics = function(){};
window.Analytics.track = function(category, action, eventName, data){
    console.log('Tracking analytics event: ', category, action, eventName, data);
};

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
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

 
	/* Heap analytics */
	window.heap=window.heap||[];
    window.heap.load=function(a){window._heapid=a;var b=document.createElement("script");b.type="text/javascript",b.async=!0,b.src=("https:"===document.location.protocol?"https:":"http:")+"//cdn.heapanalytics.com/js/heap.js";var c=document.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c);var d=function(a){return function(){heap.push([a].concat(Array.prototype.slice.call(arguments,0)))}},e=["identify","track"];for(var f=0;f<e.length;f++)heap[e[f]]=d(e[f])};
    window.heap.load(analyticsConfnig.heap);


	var currentUserId = null;

    if(typeof(window.user) !== 'undefined' && typeof(window.user.id) !== 'undefined')
	{
		mixpanel.identify(window.user.id);
		currentUserId = window.user.id;
	}

	ga('create', 'UA-18788673-3', 'auto', {userId: currentUserId});
	ga('send', 'pageview');


    window.Analytics.track = function(category, action, eventName, data)
    {
        ga('send', 'event', category, action, eventName, data);
        mixpanel.track(category + '/' + eventName + '/' + action, data);
    };

})();



