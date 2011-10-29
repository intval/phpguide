<div class="wallPost blogpost">

    <img width="50" height="50" alt="תמונה" class="right wallPost-avatar"
         src="<?=e($post->author->avatar)?>">


    <div class="right wallPost-content">
        <div>
            <h6 class="username"><?=e($post->author->member_name)?></h6>
            <div class="postTime left"> &nbsp; <?=Helpers::dateStr2heb($post->pubdate)?></div>
            <div class="clear"></div>
        </div>
        <?=nl2br(e($post->content))?>

    </div>
    <div class="clear"></div>


    <? $this->renderPartial("//wall/wallPostComment", array('comments' => $post->comments)) ?>


    <div class="comment">
        <input type="text" placeholder="רשום תגובה..." size="50"/>
    </div>

</div>