<div class="homepage_posts" >

    
<?  $i = 0; foreach ($articles as $article):  ?>

    <div class="blogpost">

        <article class="post">

            <div>
                <div class="right post-image">
                    <img src="/static/images/pixel.gif" title="<?=e($article->image);?>" alt="<?=e($article->title);?>" />
                </div>
                <div class="right post-content">
                    <h1 class="title"><a id="post<?=$article->id?>" href="<?=bu(e(urlencode($article->url)));?>.htm" rel="bookmark" title="<?=e($article->description);?>" ><?=e($article->title);?></a></h1>
                    <?=$article->html_desc_paragraph;?>
                    <br/>
                    <div class="submited">
                        <div class="right"><?=e($article->author->real_name);?>, </div>
                        <div class="right">&nbsp;<?=Helpers::date2heb($article->pub_date);?></div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <time datetime="<?=Helpers::date2rfc($article->pub_date);?>" pubdate="pubdate"></time>
        </article>
    </div>
<? endforeach; ?>

</div>
