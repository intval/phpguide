<? foreach( $comments as $comment ): ?>
<div class="comment">
    <img class="right" width="25" height="25" alt=""
         src="<?=e($comment->author->avatar)?>">
    <h6 class="username"><?=e($comment->author->member_name)?></h6>
    <div class="clear" ></div>
    <?=nl2br(e($comment->content))?>
</div>
<? endforeach; ?>