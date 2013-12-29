<?php
/*** @var $this PHPGController */
/*** @var $articles array */
/*** @var $paginationCurrentPage integer */
/*** @var $paginationTotalPages integer */
?>

<div class='homepage-articles'>

    <?=
    $this->renderPartial('//article/allArticles', [
        'articles'     => $articles,
        'paginationTotalPages' => $paginationTotalPages,
        'paginationCurrentPage' => $paginationCurrentPage
    ]);
    ?>

</div>