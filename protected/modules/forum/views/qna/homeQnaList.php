<?php if($qnas): ?>

<h3 style="color: #BC1D35;">
    שאלות אחרונות
</h3>

    <?php
        foreach($qnas as $qna)
        {
                $this->renderPartial('forum.views.qna.qnaHomeItem', array('qna' => &$qna));
        }
    ?>
    <div class='clear'></div>

<?php endif; ?>