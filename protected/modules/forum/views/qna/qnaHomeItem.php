<? /** @var $qna QnaQuestion */ ?>

<div class="qna-home-row">
    <div class="counts">
        <!--<div class="votes">
            <div class="item-count">0</div>
            <div>אהבו</div>
        </div>-->
        <div class="status  <?=$qna->answers < 1 ? 'un' : '';?>answered">
            <div class="item-count"><?=$qna->answers?></div>
            <div>
                תגובות
            </div>
        </div>
        <div class="views">
             <div class="item-count"><?=$qna->views?></div>
             <div>צפיות</div>
        </div>
    </div>

    <div class="question-summary-wrapper">
        <h2><a href="<?=  $qna->getUrl() ?>" title="<?=e(strip_tags(mb_substr($qna->html_text, 0, 500)))?>"><?=e($qna->subject)?></a></h2>
        <div class="userinfo">
            פתח
            
                <a href='<?=bu('users/').urlencode($qna->author->login)?>'><?=e($qna->author->login)?></a>

            ,
            <time class="timeago relativetime" datetime="<?=$qna->time->date2rfc()?>" style="display:inline-block;">
            	<?= $qna->time->date2heb() ?>
            	<?php
            	/* if( QnaController::doesQnaHaveNewAnswersSinceLastVisit($qna)) : ?><span style='color:blue; font-style:italic; padding-right:15px;'>חדש</span><?php endif; */
                ?>
            </time>


            <? if(isset($showCategory) && $showCategory === true): ?>
                ,
            בקטגורית
            <span dir="ltr" style="font-size: 80%">
                <a href='/forum/<?=$qna->categoryid?>'><?=e($qna->category->cat_name); ?></a>
            </span>
            <? endif; ?>
		</div>
	
    </div>
</div>