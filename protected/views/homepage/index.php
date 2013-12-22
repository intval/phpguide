<?php
/*** @var $this PHPGController */
/*** @var $qnas array */
/*** @var $articles array */
/** @var $paginationCurrentPage integer */
/** @var $paginationTotalPages integer */
?>

<div class="lastActiveQuestions">
    <?
    if($paginationCurrentPage == 1)
        $this->widget('forum.components.LastActiveTopicsWidget', ['count' => 3]); ?>
</div>

<div class='homepage-articles'>

<?=
    $this->renderPartial('//article/allArticles', [
        'articles'     => $articles,
        'paginationTotalPages' => $paginationTotalPages,
        'paginationCurrentPage' => $paginationCurrentPage
    ]);
?>

</div>