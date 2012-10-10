<?php $this->renderPartial('//qna/newQuestionForm') ?>

<section class='clearfix homepage-qna'>
    <?php  $this->renderPartial('//qna/homeQnaList', array('qnas' => &$qnas)) ?>
</section>

<div class="homepage-banner">
    פרסם כאן
</div>

<div class='homepage-articles'>
<?php  $this->renderPartial('//article/homepageArticlesList', array('articles' =>  $articles )); ?>
&larr; <a href='<?=bu('Article/All')?>'>כל הפוסטים</a>
</div>
