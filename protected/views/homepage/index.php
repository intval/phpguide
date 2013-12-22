<?php
/*** @var $this PHPGController */
/*** @var $qnas array */
/*** @var $articles array */
?>


<div class='homepage-articles'>
<?php  $this->renderPartial('//article/homepageArticlesList', ['articles' => $articles]); ?>
&larr; <a href='<?=bu('Article/All')?>'>כל הפוסטים</a>
</div>