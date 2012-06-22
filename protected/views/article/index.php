
    <h1 class='content-title'><span></span><?=e($article->title);?></h1>
    
    <!-- publisher -->
    <div id="content-publishing-info">
        <div class="right"><?=e($article->author->login);?>, </div>
        <div class="right">&nbsp;<time datetime="<?=$article->pub_date->date2rfc()?>"  dir="rtl"><?=$article->pub_date->date2heb();?></time></div>
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
           
        <img src="/static/images/pixel.gif" title="<? $this->widget('GravatarWidget', array('email' => $article->author->email, 'size' => 50, 'linkOnly' => true)); ?>" alt="<?=e($article->author->login)?>" width="50" height="50" class="right"/>
        <p style=" margin-right:10px; width:245px" class="right">
            על המחבר:
          
            <b><?=e($article->author->real_name)?></b> 
            <span dir="ltr">(<?=e($article->author->login)?>)</span>
  	<!--<br/><br/><a href="/forum/index.php?action=profile;u=<?=e($article->author->id)?>" style="font-size:95%">פרופיל משתמש</a>-->
            
        </p>
        <div class="clear"></div>
    </div>
        
        <div  id="like_for_concrete_post" class="left" style="margin:10px  0 0 10px;"></div>
        <div class='clear'></div>
    
    	<?php  if(!Yii::app()->user->isguest && ($article->author->id === Yii::app()->user->id || Yii::app()->user->is_admin)):  ?>
	        <div><a href="<?= bu('Add?edit='.$article->id)?>">Edit this article</a></div>
	        <div class='clear'></div>
        <?php endif; ?>
        
    </div>
    
 
    
    
    <?  $this->renderPartial('//article/comments', array('comments' => $article->comments)); ?>


    
        
    <a name='comments_form' ></a>    
	<div class="comment-table" id="comments_form">
            <b style="color:green">
            פרגן, מה אכפת לך :)
            </b>
	    <br/><br/>
	    <?php echo CHtml::beginForm('', 'post', array('id' => 'comments_inputs', 'class' => 'form-stacked')); ?>
	    
		<?= Chtml::hiddenField("Comment[blogid]", e($article->id))?>

		<div id="comments_alert"></div>
		<div class="clearfix">
		    <label for="textarea">תגובה</label>
		    <?= CHtml::textArea("Comment[text]", '', array('id' => 'commenttext')) ?>
		</div>
		<div class="form-actions">
	
אל תתבייש, חשוב לנו לדעת מה אתה חושב -->	    

		    <?=CHtml::ajaxSubmitButton(
			    'שלח תגובה!'
			    ,bu('comments/add') ,
			    array('success' => 'comment_sumbitted_callback', 'beforeSend' => 'sendcomment'), 
			    array('class'=> 'btn btn-primary', 'id' => 'addCommentBtn'))?>

		</div>
		<?php echo CHtml::endForm();?>
	    
	</div>
	<img src="static/images/ajax-loader.gif" id="comments_loading_img"/>    
	    
	    
	    
