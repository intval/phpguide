<?php
/** @var $showCategory bool */
/***
 * @var QnaQuestion[] $qnas;
 */
if(isset($qnas) && !empty($qnas)): ?>

<h3 style="color: #BC1D35;">
    דיונים אחרונים
</h3>

    <?php
        foreach($qnas as $qna)
            $this->renderPartial('forum.views.qna.qnaHomeItem', ['qna' => &$qna, 'showCategory' => $showCategory]);
    ?>
    <div class='clear'></div>

<?php endif; ?>