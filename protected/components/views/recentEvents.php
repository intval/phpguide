
    
<section id="last_comments" class="rblock">
    <h3>תגובות אחרונות</h3>
    <? foreach($comments as $comment): ?>
    <dl>
            <dt><?php $this->widget('GravatarWidget', array('size' => 24, 'email' => $comment->CommentAuthor->email)); ?></dt>
            <dd>
                    <a href="/users/<?=e($comment->CommentAuthor->login);?>" class="nick"><?=e($comment->CommentAuthor->login);?></a>
                    &nbsp;&mdash;&nbsp;
                    <a href="<?=bu(e(urlencode($comment->Article->url)));?>.htm" class="blog"><?=e($comment->Article->title)?></a>
                    &nbsp;&larr;&nbsp; 
                    <a href="<?=bu(e(urlencode($comment->Article->url)));?>.htm#comment<?=$comment->cid?>" class="topic"><?=e(mb_substr($comment->text,0,100))?></a>
            </dd>

    </dl>
    <? endforeach; ?>
</section>
