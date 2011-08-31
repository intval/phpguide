
<div id="greeting">
    <h1 class="title">
ברוך הבא לאתר לימוד PHP
    </h1>
    <br/>
    <? /*
תתחיל
<a href="learnPHP/intro.htm" style="color:green">
    בקורס לימוד PHP חינם
</a>
    <br/>
     
     */ ?>
    תתקדם בחומר עם 
    <a href="#guides_cats">
    מגוון הכתבות והמדריכים
    </a>
    <br/>
    אם ישארו לך שאלות — חברי הקהילה יישמחו לענות לך עליהם. כתוב את שאלתך בטופס הבא:
<br/><br/>
<br/>
</div>


<div class="new_question_form" >
    <div style="margin:0 auto;width:90%;">
        <h4 >
            שאל כל שאלה ב- php/sql
            , אנחנו נענה
        </h4>
        <form id="new_forum_post_form" onsubmit="return false">
            <textarea name="forum_topic" id="forum_question_text"></textarea>
            <input type="hidden" name='csrf' id="csrf" value="{{ csrf|e }}" />
        </form>
        <div id="forum_question_controls" >
            <div class="right"><input value="לשאול (Ctrl+Enter)"  onclick="submit_new_question()" id="qsub" type="button"></div>
            <div class="left">
                <a title="bold text" href="javascript:bbstyle('b');"><b>B</b></a>
                <a title="italic text" href="javascript:bbstyle('i')"><i>I</i></a>
                <a title="underlined" href="javascript:bbstyle('u')"><u>U</u></a>
                <a title="block of code" href="javascript:bbstyle('php')">PHP</a>
                <a title="link to url" href="javascript:bbstyle('url')">A</a>
            </div>
            <div class="clear"></div>
            <span style="font-size:80%">
         
                אנא רשמו את נושא השאלה בשורה הראשונה כדי לעזור למנועי החיפוש, ואחריה את השאלה עצמה
                <br/>
                <b>נושא</b> השאלה כפי שיראו אותו המשתמשים האחרים:
                <span id="new_qna_subject_preview" style="color:green; font-weight:bold;"></span>
        </div>
    </div>
</div>


<div class="categories_list">
    
    <a name="guides_cats"></a>
    <div>
        <h4 class="right" width="250px" >מדריכים מתקדמים לפי קטגוריה</h4>
        <a href="<?=bu('Add')?>" class="addlink left">הוסף מדריך</a>
        <div class="clear"></div>
    </div>
    <div style="width:49%;" class="right">
        <? $break = sizeof($categories) / 2; $i = 0;
           foreach( $categories as $cat ):  ?>
		
        <a href=<?=bu("cat/" . e(urlencode($cat['name'])) . ".htm")?>><?=e($cat['name']);?></a><br/>
        
            <? if(++$i == $break ): ?> 
                </div><div style="width:49%;" class="right">
            <? endif; ?>
        
	<? endforeach; ?>
    </div>
    <div class="clear"></div>
</div>


<h3>פרסומים אחרונים</h3>
<br/><br/>


<?php $this->renderPartial('//list/articlesList', array('articles' => & $articles )); ?>
