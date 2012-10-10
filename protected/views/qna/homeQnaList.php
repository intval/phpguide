<?php if($qnas): ?>

<h3 style="color: #BC1D35;">
    שאלות אחרונות
</h3>

    <?
        foreach($qnas as $qna)
        {
                $this->renderPartial('//qna/qnaHomeItem', array('qna' => &$qna));
        }
    ?>
    <div class='clear'></div>

<?php endif; ?>