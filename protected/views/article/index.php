

    <a href="/" class='blog_entry_back' rel="up">&rarr; <span>חזרה למדריכי PHP</span></a>
    <h1 class='content-title'><span></span><?=e($article->title);?></h1>
    
    <!-- publisher -->
    <div id="content-publishing-info">
        <div class="right"><?=e($article->author->full_name);?>, </div>
        <div class="right">&nbsp;<time datetime="<?=Helpers::date2rfc($article->pub_date)?>" pubdate dir="rtl"><?=Helpers::date2heb($article->pub_date);?></time></div>
        <div class="clear"></div>
    </div>

    <!-- content -->
    <article>
        <header>

            <div class="right post-image">
                <img src="/static/images/pixel.gif" title="<?=e($article->image)?>" alt="<?=e($article->title)?>" />
            </div>
            <div class="right post-content">
                <?=$article->html_desc_paragraph?>   <br/>
            </div>
            <div class="clear"></div>

        </header>
        <br/><br/>
        <?=$article->html_content?>
    </article>
    
    <br/><br/>
    <br/><br/>
    
    <hr/>
   
    <div style="margin-top:15px;">
        <div class="right" style="padding:5px; font-size: 85%;line-height: 16px; margin-bottom: 25px;  width:400px">
        <img src="/static/images/pixel.gif" title="<?=e($article->author->avatar)?>" alt="<?=e($article->author->member_name)?>" width="45" height="45" class="right"/>
        <p style=" margin-right:10px; width:245px" class="right">
            על המחבר:
          
            <b><?=e($article->author->full_name)?></b> 
            <span dir="ltr">(<?=e($article->author->member_name)?>)</span>
   
            <br/>
            <span style="color:gray; font-size:97%"> <? if($article->author->about != null) echo e($article->author->about->value); ?> </span>
            <br/>
            <a href="/forum/index.php?action=profile;u=<?=e($article->author->id_member)?>" style="font-size:95%">פרופיל משתמש</a>
            
        </p>
        <div class="clear"></div>
    </div>
        
       <div  id="like_for_concrete_post" class="left" style="margin:10px  0 0 10px;"></div>
        <div class='clear'></div>
    </div>
    
 
    
    
    <?  $this->renderPartial('comments', array('comments' => $article->comments)); ?>


    
        
        
	<div class="comment-table" id="comments_form">
            <b style="color:green">
            פרגן, מה אכפת לך :)
            </b><br/><br/>
            <div class="clear" ></div>
            <div class="rightcolumn">
                <span class="label-comment">תגובה:</span>
            </div>
            <div class="leftcolumn">
                <form id="comments_inputs" >
                <textarea cols="50" rows="10" name="Comment[text]" id='commenttext'></textarea><br/>
                <input type='hidden' name="Comment[blogid]"  value="<?=e($article->id)?>" />
                אל תתבייש, חשוב לנו לדעת מה אתה חושב -->
                <input type="button" onclick="sendcomment()" value="שלח תגובה (Ctrl + Enter)" class="submit"/> 
                </form>
            </div>
            <div class="clear"></div>
	</div>
        <img src="" alt="loading" title="/static/images/ajax-loader.gif" id="comments_loading_img"/>
