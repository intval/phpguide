
    
<h1 class="category-title"><?=e($category->name)?></h1>
<div class="category_bread_crumbs">
    <a href="">phpguide</a> 
    &raquo;
    <a href="index.php#guides_cats">כתבות ומדריכים</a>
    &raquo;
מדריכים בנושא 
    <?=e($category->name)?>
</div>



<div id="categories_posts" >

<? foreach ($category->articles as $article):  
    
    $article->pub_date = new DateTime($article->pub_date);
?>

    <div class="blogpost">
        
        <article class="post">
            
            <div>
                <div class="right post-image">
                    <img src="/static/images/pixel.gif" title="<?=e($article->image);?>" alt="<?=e($article->title);?>" />
                </div>
                <div class="right post-content">
                    <h1 class="title"><a id="post<?=$article->id?>" href="<?=bu(e(urlencode($article->url)));?>.htm" rel="details" title="<?=e($article->description);?>" ><?=e($article->title);?></a></h1>
                    <?=$article->html_desc_paragraph;?>
                    <br/>
                    <div class="submited">
                        <div class="right"><?=e($article->author->full_name);?>, </div>
                        <div class="right">&nbsp;<?=Helpers::date2heb($article->pub_date);?></div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <time datetime="<?=Helpers::date2rfc($article->pub_date);?>" pubdate></time>         
        </article>
    </div>
<?endforeach;?>

</div>


