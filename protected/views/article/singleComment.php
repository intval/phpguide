

<a id="comment<?=$comment->cid?>"></a>
<div class="blog-comment">
    <span class='comment-author'><?=e($comment->author)?></span><span dir="rtl">&nbsp;</span>
    <span dir="ltr" class='comment-date'><?$dt = new DateTime($comment->date); echo $dt->format('d/m/Y H:i')?></span><br/>
    <?=Helpers::anchorize_urls_in_text(nl2br(e($comment->text)/*, true /*php 5.3 only*/))?>
</div>