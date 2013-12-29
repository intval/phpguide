<?php
/** @var $this PHPGWidget */
/** @var $showCategory bool */
/** @var QnaQuestion[] $qnas */

$this->renderPartial('homeQnaList', [
    'qnas' => & $qnas,
    'allCategories' => & $allCategories,
    'paginationTotalPages' => $paginationTotalPages,
    'paginationCurrentPage' => $paginationCurrentPage,
    'showCategory' => $showCategory
]);

Yii::app()->clientScript->registerScript
    (
        'paginator',
        "pag4 = new Paginator
        (
            'paginator5',
            $paginationTotalPages /*total*/,
            15,
            $paginationCurrentPage /*current*/,
            document.location.pathname + '?page='
        );",
        CClientScript::POS_READY);
?>

<div class="paginator" id="paginator5" dir="ltr"></div>