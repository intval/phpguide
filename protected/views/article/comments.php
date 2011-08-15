   <section class="comments" id='post_comments'>
    <? if (isset($comments[0])): ?>
    
	<h2>תגובות לכתבה:</h2>
        <? foreach($comments as $comment): ?>
        <a id="comment<?=$comment->cid?>"></a>
        <div class="blog-comment">
            <span class='comment-author'><?=e($comment->author)?></span><span dir="rtl">&nbsp;</span>
            <span dir="ltr" class='comment-date'><?$dt = new DateTime($comment->date); echo $dt->format('d/m/Y H:i')?></span><br/>
            <?=Helpers::anchorize_urls_in_text(nl2br(e($comment->text), true))?>
        </div>
        <?  endforeach;?>
        
    <?endif;?>
    </section>