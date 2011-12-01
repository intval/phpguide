
<? $this->renderPartial('//qna/newQuestionForm') ?>




<div class="categories_list">

    <a name="guides_cats"></a>
    <div>
        <h4 width="250px" class="right">מדריכים מתקדמים לפי קטגוריה</h4>
        <a class="btn success left" href="<?=bu('add')?>">הוסף מדריך</a>
        <div class="clear"></div>
    </div>
    <div class="right" style="width:49%;">

	<a href="/cat/JS+%D7%A6%D7%93+%D7%9C%D7%A7%D7%95%D7%97.htm">JS צד לקוח</a><br>
	<a href="/cat/mysql.htm">mysql</a><br>
	<a href="/cat/%D7%90%D7%91%D7%98%D7%97%D7%94.htm">אבטחה</a><br>
	<a href="/cat/%D7%91%D7%99%D7%A6%D7%95%D7%A2%D7%99%D7%9D+%D7%95%D7%90%D7%95%D7%A4%D7%98%D7%99%D7%9E%D7%99%D7%96%D7%A6%D7%99%D7%94.htm">ביצועים ואופטימיזציה</a><br>
	<a href="/cat/%D7%9B%D7%9C%D7%99%D7%9D+%D7%A9%D7%99%D7%9E%D7%95%D7%A9%D7%99%D7%99%D7%9D.htm">כלים שימושיים</a><br>
	<a href="/cat/%D7%9E%D7%91%D7%A0%D7%94+%D7%94%D7%A1%D7%A7%D7%A8%D7%99%D7%A4%D7%98.htm">מבנה הסקריפט</a><br>

    </div><div class="right" style="width:49%;">


	<a href="/cat/%D7%A0%D7%95%D7%A9%D7%90%D7%99%D7%9D+%D7%9B%D7%9C%D7%9C%D7%99%D7%99%D7%9D.htm">נושאים כלליים</a><br>
	<a href="/cat/%D7%A4%D7%AA%D7%A8%D7%95%D7%A0%D7%95%D7%AA+%D7%A0%D7%A4%D7%95%D7%A6%D7%99%D7%9D.htm">פתרונות נפוצים</a><br>
	<a href="/cat/%D7%A8%D7%A9%D7%AA+%D7%95%D7%A4%D7%A8%D7%95%D7%98%D7%95%D7%A7%D7%95%D7%9C%D7%99%D7%9D.htm">רשת ופרוטוקולים</a><br>
	<a href="/cat/%D7%A9%D7%9C%D7%99%D7%97%D7%AA+%D7%90%D7%99%D7%9E%D7%99%D7%99%D7%9C+%D7%91-PHP.htm">שליחת אימייל ב-PHP</a><br>
	<a href="/cat/%D7%A9%D7%A8%D7%AA%D7%99%D7%9D+apache+wamp.htm">שרתים apache wamp</a><br>
	<a href="/cat/%D7%AA%D7%9E%D7%95%D7%A0%D7%95%D7%AA+%D7%95%D7%92%D7%A8%D7%A4%D7%99%D7%A7%D7%94.htm">תמונות וגרפיקה</a><br>

    </div>
    <div class="clear"></div>
</div>


<? //  $this->renderPartial('//qna/homeQnaList', array('qnas' => &$qnas)) ?>
<!-- <div class="clear"></div> -->
<?  $this->renderPartial('//list/homepageArticlesList', array('articles' => & $articles )); ?>

<!--
<div class="row">
    <div class="span6">
	<? //$this->renderPartial('//list/homepageArticlesList', array('articles' => & $articles )); ?>
    </div>
    <div class="span6">
	<? // $this->renderPartial('//wall/homepageWall', array('wallPosts' => & $wallPosts)) ?>
	<? // $this->renderPartial('//qna/homeQnaList', array('qnas' => &$qnas)) ?>
    </div>
</div>
-->