

<section id="sidebar" class="phplive-sidebar">
    
    <h3>הוראות:</h3>

    
        1. כתבו קוד php <br/> 
    2. לחצו Ctrl + Enter להפעלתו <br/>
    3. ראו תוצאה בריבוע הצהוב <br/>
    <br/>
    
    <h3>הערות:</h3>
    
    פונקציות מסוימות לא ניתנות לביצוע <br/>
    מתוך הגבלות בטיחותיות. <br/>
    <br/>
    תגי הפתיחה והסגירה <?php ?>  <br/>
    מתווספים באופן אוטומטי <br/>
    
<br/>
קוד לא יפעל יותר משניה אחת

<br/><br/>


</section>	<!-- /sidebar -->

<section id="content">

    <form method="post"  action="http://sandbox.phpguide.co.il/sandbox.php" name="sandboxform" id="sandboxform" target="xmlFrame" dir="rtl">
        <div dir="ltr">&nbsp;&lt;?php </div>
        <textarea name="code" id="sandboxarea" rows="15" cols="70" dir="ltr" tabindex="1"><?=e($code)?></textarea><br/>
        <input type="hidden" name="is_remote" value="true" />
        
        <div>
            <div id="phplive_link" style="float:left">
                <a href="javascript:generate_code_url()" id="code_get_link" tabindex="3" >קישור לקוד הזה</a>
                <span id="code_url" style="display:none"></span>
                <img src="/static/images/pixel.gif" alt="..." title="/static/images/code_url_loader.gif" id="code_url_loader" style="display:none"/>
            </div>
            <input type="button" onclick="actual_run_code()" tabindex="2" style="display:block; float:right" value="בצע קוד"/>
            <div class="clear"></div>
        </div>
        
    </form>
    <iframe style="display:none;" src="http://sandox.phpguide.co.il/iframe.htm"  id="xmlFrame" name="xmlFrame"></iframe>
    <br/>
    <div dir="ltr">Response: </div>
    <div id="sandboxresponse" dir="ltr"></div>
    
</section>

