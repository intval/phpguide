<?php
/** @var $this PHPGWidget */
/** @var $showCategory bool */
/** @var QnaQuestion[] $qnas */

if(isset($qnas) && !empty($qnas)): ?>

    <div>
        <h3 style="color: #BC1D35;float:right;">
            דיונים אחרונים
        </h3>

        <? if($showCategory): ?>
            <div style="float:left">

                <a href="<?=bu('qna')?>" style="margin-left: 15px;">
                    כל הפורומים
                </a>

                <a href="<?= Yii::app()->urlManager->createUrl('qna/createNewTopic') ?>">
                    אשכול חדש
                </a>
            </div>
        <? endif; ?>

    </div>

    <?php
        foreach($qnas as $qna)
            $this->renderPartial('forum.views.qna.qnaHomeItem', ['qna' => &$qna, 'showCategory' => $showCategory]);
    ?>
    <div class='clear'></div>
    <div>

    </div>

<?php endif; ?>