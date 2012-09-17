
<div class="qna_view_question" id="qnaQuestionHolder">
    
    <? $this->renderPartial('//qna/qnaHomeItem', array('qna' => &$qna)) ?>
    <div class="clear"></div>
    
    <?php if((!Yii::app()->user->isguest &&  Yii::app()->user->is_admin) || $qna->authorid === Yii::app()->user->id) { ?><a class="qna-question-edit" title='ערוך תשובה'></a><?php } ?>
	<?php if(!Yii::app()->user->isguest && Yii::app()->user->is_admin) { ?><a class="qna-question-delete" title='מחק תשובה'></a><?php } ?>
    
    
    <div style="border-top:1px dashed #D1D1D1; margin-top:10px; padding-top:10px; " class="qnapost" id='questionText<?=$qna->qid?>'>
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
	    $this->renderPartial('//qna/comment', array('answer' => &$answer , 'canUserMarkAnswer' => &$canUserMarkAnswer));
	}
    ?>
</section>


<?php 

$model = new QnaComment();
$model->qid = $qna->qid;
$this->renderPartial('commentsForm', array('model' => $model)); 

?>
