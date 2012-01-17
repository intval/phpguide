<div class="qna-home-row">
    <div class="counts">
        <!--<div class="votes">
            <div class="item-count">0</div>
            <div>אהבו</div>
        </div>-->
        <div class="status  <?=$qna->answers < 1 ? 'un' : '';?>answered">
            <div class="item-count"><?=$qna->answers?></div>
            <div>תשובות</div>
        </div>
        <div class="views">
             <div class="item-count"><?=$qna->views?></div>
             <div>צפיות</div>
        </div>
    </div>

    <div class="question-summary-wrapper">
        <h2><a href="<?= bu('qna/view/id/'.$qna->qid);?>" title="<?=e(strip_tags(mb_substr($qna->html_text, 0, 500)))?>"><?=e($qna->subject)?></a></h2>
        <div class="userinfo">
            שאל
            
                <?=e($qna->author->login)?>

            ,
            <span class="relativetime" style="display:inline-block;">
                <?= Helpers::date2heb(new DateTime($qna->time)); ?>
	        </span>
            

        </div>

    </div>

</div>

