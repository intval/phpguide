

<form method="get" action="http://www.google.co.il/search" id="search_form">

<input type="hidden" name="hl" value="iw" />
<input type="text" class="search_form" placeholder="חיפוש" name="q" id="search_field"/>
<input type="checkbox"  name="sitesearch" style="display:none" value="phpguide.co.il" checked /> 

</form>
    

    <? $this->widget('application.components.LoginUser') ?>



    
    
    <div class="blog-links-block">
        <a href='http://feeds.feedburner.com/phpguideblog' class='rssfeed' rel='rss' title='RSS Feed'>הירשם לעדכונים בRSS</a>
        
    <form 
	style="text-align:center;padding:3px;" 
	action="http://feedburner.google.com/fb/a/mailverify" 
	method="post" 
	target="popupwindow" 
        id ="email_subscripe_form" name ="email_subscripe_form"
        onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=phpguideblog', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"
        >
	
	או קבל עדכונים באימייל:
        <input type="text" 
               style="width:150px; text-align: center; height:22px; margin:5px 0;"
               dir="ltr" 
               id="email_subscription" 
               name="email" 
               placeholder="your@email.com"
               />
	<input type="hidden" value="phpguideblog" name="uri"/>
	<input type="hidden" name="loc" value="he_IL"/>
        <br/>
        <a style="font-size: 95%" href="#" onclick="if($('#email_subscription').val()!='') $('#email_subscripe_form').submit();">הרשם עכשיו</a>
        
        <span style="font-size:10px; color:gray; " id="subscription_hint">
        <br/><br/>
            ישלח מייל לאישור ההרשמה ואחריו יופץ מייל על כל כתבה מעניינת וחדשות של "המדריך ל-php" . ניתן להמחק מרשימת התפוצה בכל עת.
        </span>
        
    </form>
    
    </div>
