

<section id="sidebar" class="phplive-sidebar ">
    <br/>
    <h3>הוראות:</h3>

    
        1. כתבו קוד php <br/> 
    2. לחצו Ctrl + Enter להפעלתו <br/>
    3. ראו תוצאה בריבוע הצהוב <br/>
    <br/>

	ניתן לכתוב ב-php וב-<a href="http://hacklang.org/">hack</a><br/>
	באמצעות תגי פתיחה מתאימים <br/>
	<span dir="ltr">(&lt;?php, &lt;?hh)</span>
    

<br/><br/>


</section>	<!-- /sidebar -->

<section id="content" >

    <div style='position:relative;height:405px; width:100%;direction:ltr;' dir="ltr">
        <div id='editor' style='position:absolute;width:100%; height:100%;font-size:16px;'><?php
         echo e($code);
        ?></div>
    </div>

    <?= CHtml::beginForm('//sandbox.phpguide.co.il/sandbox.php', 'post', array('name'=>"sandboxform", 'id'=>"sandboxform", 'target'=>"xmlFrame", 'dir'=>"rtl")) ?>
        <textarea name="code" id="sandboxarea" rows="15" cols="70" dir="ltr" tabindex="1" style="display:none;"></textarea><br/>
        <input type="hidden" name="is_remote" value="true" />
        
        <div>
            <div id="phplive_link" style="float:left">
                <a href="javascript:generate_code_url()" id="code_get_link" tabindex="3" >קישור לקוד הזה</a>
                <span id="code_url" style="display:none"></span>
                <img src="/static/images/pixel.gif" alt="..." title="/static/images/code_url_loader.gif" id="code_url_loader" style="display:none"/>
            </div>
            <input type="button" onclick="actual_run_code()" tabindex="2" style="display:block; float:right;" class="btn" value="בצע קוד"/>
            <div class="clear"></div>
        </div>
        
    <?= CHtml::endForm() ?>
    <iframe style="display:none;" src="//sandox.phpguide.co.il/iframe.htm"  id="xmlFrame" name="xmlFrame"></iframe>
    <br/>
    <div dir="ltr">Response: </div>
    <pre id="sandboxresponse" dir="ltr"></pre>
    
</section>

