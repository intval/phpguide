<div id="homepage_posts" >
    <div class="row">
	<div class="span6">
    
<?  $i = 0;
    foreach ($articles as $article):  
    
    $article->pub_date = new DateTime($article->pub_date);    
?>

    <div class="blogpost">
        <article class="post">

	    <h1 class="title"><a id="post<?=$article->id?>" href="<?=bu(e(urlencode($article->url)));?>.htm" rel="details" title="<?=e($article->description);?>" ><?=e($article->title);?></a></h1>

	    <div class="submited">
		<div class="right"><?=e($article->author->full_name);?>, </div>
		<div class="right">&nbsp;<?=Helpers::date2heb($article->pub_date);?></div>
		<div class="clear"></div>
	    </div>
	    
	    <div class="right post-image">
	    <img src="/static/images/pixel.gif" title="<?=e($article->image);?>" alt="<?=e($article->title);?>"  />
	    </div>

	    <?=$article->html_desc_paragraph;?>
	    
         
           
            <time datetime="<?=Helpers::date2rfc($article->pub_date);?>" pubdate></time>         
	    <div class="clear"></div>
        </article>

    </div>
<?
    $i++;
    
    if($i %2 == 0)
    {
	echo '
	    </div>
	 </div>
	 <div class="row">
	    <div class="span6">
	    ';
    }
    else
    {
	echo '
	    </div>
	    <div class="span6">
	    ';
    }
    endforeach;
?>
	</div>
    </div>
</div>
