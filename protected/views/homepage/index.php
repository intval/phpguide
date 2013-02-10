<?php
/*** @var $this PHPGController */
/*** @var $qnas array */
/*** @var $articles array */

$blogpostCacheAttrs = [
    'duration' => 400,
    'dependency' =>[
        'class'=>'system.caching.dependencies.CDbCacheDependency',
        'sql'=>Article::getCacheDependencySql()
    ]
];

?>

<?php $this->renderPartial('//qna/newQuestionForm') ?>

<section class='clearfix homepage-qna'>
    <?php  $this->renderPartial('//qna/homeQnaList', array('qnas' => &$qnas)) ?>
</section>

<div class="homepage-banner">
    פרסם כאן
</div>

<?php if($this->beginCache('HomepageBlogpostsFragmentCache', $blogpostCacheAttrs)) { ?>

<div class='homepage-articles'>
<?php  $this->renderPartial('//article/homepageArticlesList',
            array('articles' =>  $articles )); ?>
&larr; <a href='<?=bu('Article/All')?>'>כל הפוסטים</a>
</div>

<?php $this->endCache(); } ?>