
<h1 class="category-title">מדריכי PHP</h1>

<div class="categories_list">

    <a id="guides_cats"></a>
    
    <div class="right" style="width:49%;">

	<a href="/cat/JS+%D7%A6%D7%93+%D7%9C%D7%A7%D7%95%D7%97.htm">JS צד לקוח</a><br>
	<a href="/cat/mysql.htm">mysql</a><br>
	<a href="/cat/%D7%90%D7%91%D7%98%D7%97%D7%94.htm">אבטחה</a><br>
	<a href="/cat/%D7%91%D7%99%D7%A6%D7%95%D7%A2%D7%99%D7%9D+%D7%95%D7%90%D7%95%D7%A4%D7%98%D7%99%D7%9E%D7%99%D7%96%D7%A6%D7%99%D7%94.htm">ביצועים ואופטימיזציה</a><br>
	<a href="/cat/%D7%9B%D7%9C%D7%99%D7%9D+%D7%A9%D7%99%D7%9E%D7%95%D7%A9%D7%99%D7%99%D7%9D.htm">כלים שימושיים</a><br>
	<a href="/cat/%D7%9E%D7%91%D7%A0%D7%94+%D7%94%D7%A1%D7%A7%D7%A8%D7%99%D7%A4%D7%98.htm">מבנה הסקריפט</a><br>
	<a href="/cat/%D7%9E%D7%93%D7%A8%D7%99%D7%9B%D7%99%20YII.htm"><b style="color:orangered">מדריכי YII</b> של אליהו בסה</a><br>
	<a href="/cat/codeigniter.htm"><b style="color:orangered">מדריכי CodeIgniter</b> של אלון נגר</a><br>

    </div><div class="right" style="width:49%;">

	<a href="/cat/חדשות+ועדכונים.htm">חדשות ועדכונים</a><br/>
	<a href="/cat/%D7%A0%D7%95%D7%A9%D7%90%D7%99%D7%9D+%D7%9B%D7%9C%D7%9C%D7%99%D7%99%D7%9D.htm">נושאים כלליים</a><br>
	<a href="/cat/%D7%A4%D7%AA%D7%A8%D7%95%D7%A0%D7%95%D7%AA+%D7%A0%D7%A4%D7%95%D7%A6%D7%99%D7%9D.htm">פתרונות נפוצים</a><br>
	<a href="/cat/%D7%A8%D7%A9%D7%AA+%D7%95%D7%A4%D7%A8%D7%95%D7%98%D7%95%D7%A7%D7%95%D7%9C%D7%99%D7%9D.htm">רשת ופרוטוקולים</a><br>
	<a href="/cat/%D7%A9%D7%9C%D7%99%D7%97%D7%AA+%D7%90%D7%99%D7%9E%D7%99%D7%99%D7%9C+%D7%91-PHP.htm">שליחת אימייל ב-PHP</a><br>
	<a href="/cat/%D7%A9%D7%A8%D7%AA%D7%99%D7%9D+apache+wamp.htm">שרתים apache wamp</a><br>
	<a href="/cat/%D7%AA%D7%9E%D7%95%D7%A0%D7%95%D7%AA+%D7%95%D7%92%D7%A8%D7%A4%D7%99%D7%A7%D7%94.htm">תמונות וגרפיקה</a><br>
	<a href="/cat/%D7%9B%D7%A0%D7%A1%D7%99%D7%9D%20%D7%95%D7%94%D7%A8%D7%A6%D7%90%D7%95%D7%AA.htm">כנסים והרצאות</a>
    </div>
    <div class="clear"></div>
</div>


<div id="categories_posts" >


<?php foreach ($articles as $article):  ?>

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
                        <div class="right">
                            <a href='<?=bu('users').'/'.e($article->author->login)?>'><?=
                                e($article->author->login);
                            ?></a>,
                        </div>
                        <div class="right">&nbsp;<?=$article->pub_date->date2heb();?>, </div>
                        <div class="right">&nbsp;תגובות: <?= $article->commentsCount; ?></div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <time datetime="<?=$article->pub_date->date2rfc();?>" ></time>
        </article>
    </div>
<?php endforeach; ?>

</div>

<div class="paginator" id="paginator3" dir="ltr"></div>

<?php 
Yii::app()->clientScript->registerScript('paginator', "pag3 = new Paginator('paginator3', ".$pagination['total_pages'] . " /*total*/, 15, " . $pagination['current_page'] ." /*current*/, '".bu('Article/All')."?page=');", CClientScript::POS_READY);
?>
