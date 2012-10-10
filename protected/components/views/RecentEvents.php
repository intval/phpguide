
    
<section id="last_comments" class="rblock">
    <h3>תגובות אחרונות</h3>
    <?php foreach($comments as $comment): ?>
    <dl>
            <dt><?php $this->widget('GravatarWidget', array('size' => 24, 'email' => $comment->CommentAuthor->email)); ?></dt>
            <dd>
                    <a dir='rtl' href="/users/<?=e($comment->CommentAuthor->login);?>" class="nick"><?=e($comment->CommentAuthor->login);?></a>
                    &nbsp;&mdash;&nbsp;
                    <a dir='rtl' href="<?=bu(e(urlencode($comment->Article->url)));?>.htm" class="blog"><?=e($comment->Article->title)?></a>
                    &nbsp;&larr;&nbsp; 
                    <a dir='rtl' href="<?=bu(e(urlencode($comment->Article->url)));?>.htm#comment<?=$comment->cid?>" class="topic"><?=e(mb_substr($comment->text,0,100, 'utf-8'))?></a>
            </dd>

    </dl>
    <?php endforeach; ?>
</section>
