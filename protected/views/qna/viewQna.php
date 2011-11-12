<div class="row" >
<div class="offset1">

<div style="border-right:3px solid #13768C;  padding-right:25px; margin-bottom:20px;">
    
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




<div id="qnaCommentForm">
        

        <?php echo  CHtml::beginForm('', 'post', array('onsubmit' => 'return false;'))  ?>
    
    
    
    <div class='controls_holder'>
	<a title="bold text" href="javascript:bbstyle('b');" class="abold"><b>B</b></a>
	<a title="italic text" href="javascript:bbstyle('i')" class="aitalic"><i>I</i></a>
	<a title="underlined" href="javascript:bbstyle('u')" class="aunderline"><u>U</u></a>
	<a title="block of code" href="javascript:bbstyle('php')" class="acode">PHP</a>
	<a title="image" href="javascript:bbstyle('img')" class="aimage">img</a>
	<a title="link to url" href="javascript:bbstyle('url')" class="alink">A</a>
	<div class="clear" ></div>
    </div>
    
    <?php 
    $model = new QnaComment();
    echo Chtml::activeHiddenField($model, 'qid',array('value' => $qna->qid)),
    CHtml::activeTextArea($model,'bb_text', array('id' => 'message')); ?>


                <?= Chtml::ajaxSubmitButton(
			"פרסם תשובה וקבל נקודה", 
			bu('/Qna/newAnswer'),
                        array('success'=>'qna.displayAnswer','beforeSend' => 'qna.answerSent'),
			array('class' => 'btn large primary', 'id' => 'btnNewAnswer')
                        ) ?>

        
        <?php echo CHtml::endForm(); ?>
    
</div>
</div>
    </div>