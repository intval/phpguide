

<a class="ideator" href="http://idea.phpguide.co.il">
   שפר את האתר
</a>

<a class="ideator" style="margin-top:30px;"
   href="http://phpguide.co.il/%D7%9B%D7%A0%D7%A1+%D7%9E%D7%A4%D7%AA%D7%97%D7%99+PHP+%D7%A8%D7%90%D7%A9%D7%95%D7%9F.htm">
 כנס מפתחים
</a>

<script type='text/javascript'>
	var scr = false, _gaq;
	function load(js)
	{
            if(js.substring(0,4) != 'http') js = '/static/scripts/'+js+'.js';
            
            var node = document.createElement('script');
            node.type = 'text/javascript'; node.async = true; node.src = js;
            if(!scr ) scr = document.getElementsByTagName('script')[0]; 
            scr.parentNode.insertBefore(node, scr);
	}
	
        <? foreach( $this->scripts_list as $script) echo  "load('$script');\r\n"; ?> 
        

        _gaq = _gaq || []; _gaq.push(['_setAccount', 'UA-18788673-3']); _gaq.push(['_trackPageview']);
        load('http://www.google-analytics.com/ga.js');
        

</script>

</body>
</html>