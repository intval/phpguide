<?php
/** @var $currentLoggedInUserEmail string */
/** @var $currentUserFirstName string */
/** @var $articleCategory string */
/** @var $article Article */
/** @var $tweetText string */
?>
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


    <div class="info_box" data-ng-controller="PostViewCtrl">

        <div class="right left-spaced">

            <img
                src="/static/images/pixel.gif"
                title="<?php $this->widget('GravatarWidget', ['email' => $article->author->email, 'size' => 16, 'linkOnly' => true]); ?>"
                alt="<?=e($article->author->login)?>"
             />

            <a href="<?= bu('users/'.e($article->author->login))?>"><?=e($article->author->login)?></a>
        </div>

        <div class="right left-spaced">
            <a
               title="להעלות לכתבה את הרייטינג"
               class="{{ hasAlreadyVoted ? 'inactive' : 'active' }}"
               data-ng-click="vote('up')" ><i class="icon-upload icon-{{ hasAlreadyVoted ? 'inactive' : 'white active' }} rating-up" ></i></a>
            <span>{{ postRating }}</span>
            <a  title="להוריד לכתבה את הרייטינג"
                data-ng-click="vote('down')"><i class="icon-download icon-{{ hasAlreadyVoted ? 'inactive' : 'white active' }} rating-down"></i></a>
        </div>

        <div class="right left-spaced">
            <i class="icon-eye-open"></i> <?=$article->GetViewsCount()?>
        </div>

        <div class="right left-spaced">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?=bu('posts/'.$article->id)?>" class="post-share-btn share-on-facebook-16-16"></a>
            <a href="http://twitter.com/intent/tweet?text=<?=urlencode($tweetText)?>" class="post-share-btn share-on-twitter-16-16"></a>
            <a href="https://plus.google.com/share?url=<?=bu('posts/'.$article->id)?>" class="post-share-btn share-on-gplus-16-16"></a>
            <div class="clear"></div>
        </div>

        <div class="clear"></div>
    </div>


    <div>
    	<?php  if(!Yii::app()->user->isguest && ($article->author->id === Yii::app()->user->id || Yii::app()->user->is_admin)):  ?>
            <br/><br/>
            <hr/>
	        <div><a href="<?= bu('Add?edit='.$article->id)?>">Edit this article</a></div><br/>
	        <div class='clear'></div>
        <?php endif; ?>

        <?php
        if(!Yii::app()->user->isguest && Yii::app()->user->is_admin): ?>

            <div>
                <? if($article->approved != Article::APPROVED_PUBLISHED) { ?>
                    <a href="<?= bu('Add/approve?id='.$article->id)?>">Approve for homepage</a><br/>
                <? }
                   if($article->approved != Article::APPROVED_SANDBOX){
                ?>
                    <a href="<?= bu('Add/send2Sandbox?id='.$article->id)?>">Send to Sandbox</a><br/>
                <? } else { ?>
                    Currently in sandbox<br/>
                <? }
                   if($article->approved != Article::APPROVED_NONE){
                ?>
                    <a href="<?= bu('Add/disapprove?id='.$article->id)?>">Disapprove the publication</a>
                <? } ?>
            </div>
            <div class='clear'></div>
        <?php endif; ?>
    </div>
    
 
    
    
    <?php  $this->renderPartial('//article/comments', array('comments' => $article->comments)); ?>


    
        
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
	    
	    
	    
