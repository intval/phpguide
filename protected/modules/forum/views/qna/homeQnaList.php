<?php
/***
 * @var QnaQuestion[] $qnas;
 */
if(isset($qnas) && !empty($qnas)): ?>

<h3 style="color: #BC1D35;">
    דיונים אחרונים
</h3>

    <?php
        foreach($qnas as $qna)
            $this->render('forum.views.qna.qnaHomeItem', array('qna' => &$qna));
    ?>
    <div class='clear'></div>

<?php endif; ?>