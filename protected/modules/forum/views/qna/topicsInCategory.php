<?php
/** @var $qnas QnaQuestion[] */
/** @var $paginationTotalPages integer */
/** @var $paginationCurrentPage integer */
/** @var $category QnaCategory */
/** @var $allCategories QnaCategory[] */
?>

<h1>
פורום
    <span dir="<?= preg_match('#[א-ת]+#u', $category->cat_name) ? 'rtl' : 'ltr'; ?>"><?=e($category->cat_name)?></span>

</h1>
<span><?=e($category->cat_description);?></span>

<?php
$this->renderPartial('newQuestionForm', ['allCategories' => $allCategories, 'selectedCategory' => $category->catid]);
$this->renderPartial('homeQnaList', array('qnas' => &$qnas));

Yii::app()->clientScript->registerScript
(
        'paginator',
        "pag4 = new Paginator
        (
            'paginator4',
            $paginationTotalPages /*total*/,
            15,
            $paginationCurrentPage /*current*/,
            '/forum/{$category->catid}?page='
        );",
        CClientScript::POS_READY);
?>

<div class="paginator" id="paginator4" dir="ltr"></div>