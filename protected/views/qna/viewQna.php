
<div class="qna_view_question">
    
    <? $this->renderPartial('//qna/qnaHomeItem', array('qna' => &$qna)) ?>
    <div class="clear"></div>
    
    <div style="border-top:1px dashed #D1D1D1; margin-top:10px; padding-top:10px; " class="qnapost">
	<?=  $qna->html_text ?>
    </div>
    
</div>

<h3>
    <span id="answersCounter"><?=$qna->answers?> </span>
	תשובות
</h3>


<section class="answers" id="qnaAnswers">
    <?php 
	foreach($qna->comments as $answer)
	{
	    $this->renderPartial('//qna/comment', array('answer' => &$answer));
	}
    ?>
</section>


<?php 

$model = new QnaComment();
$model->qid = $qna->qid;
$this->renderPartial('commentsForm', array('model' => $model)); 

?>
