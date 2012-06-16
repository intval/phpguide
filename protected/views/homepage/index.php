<? $this->renderPartial('//qna/newQuestionForm') ?>

<section class='clearfix homepage-qna'>
    <?  $this->renderPartial('//qna/homeQnaList', array('qnas' => &$qnas)) ?>
</section>

<div class="homepage-banner">
    פרסם כאן
</div>

<div class='homepage-top2-articles'>
<?  $this->renderPartial('//article/homepageArticlesList', array('articles' =>  array_slice($articles, 0, 2) )); ?>
</div>
