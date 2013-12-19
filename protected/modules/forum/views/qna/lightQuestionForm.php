<div class="qnaCommentForm">
        

    <?php  echo  CHtml::beginForm('', 'post', array('onsubmit' => 'return false;'))  ; ?>
    
    
    
    <div class='controls_holder'>
	<a title="bold text" href="javascript:$('#editedQuestion').bbcode('b');" class="abold"><b>B</b></a>
	<a title="italic text" href="javascript:$('#editedQuestion').bbcode('i')" class="aitalic"><i>I</i></a>
	<a title="underlined" href="javascript:$('#editedQuestion').bbcode('u')" class="aunderline"><u>U</u></a>
	<a title="block of code" href="javascript:$('#editedQuestion').bbcode('php')" class="acode">PHP</a>
	<a title="image" href="javascript:$('#editedQuestion').bbcode('img')" class="aimage">img</a>
	<a title="link to url" href="javascript:$('#editedQuestion').bbcode('url')" class="alink">A</a>
	<div class="clear" ></div>
    </div>
    
    <?php 
    echo Chtml::activeHiddenField($model, 'qid'),
    CHtml::activeTextArea($model,'bb_text', array('id' => 'editedQuestion')); 


    $ajaxProperties = array('success' => 'qna.editQuestionSuccess', 'beforeSend' => 'qna.editQuestionSent');
    $htmlProperties = array('class' => 'btn btnEditQuestion');
    $btnText = 'עריכת שאלה';
    	
    echo CHtml::activeHiddenField($model, 'authorid'), 
    	 CHtml::activeHiddenField($model, 'subject', array('id' => 'editQuestionSubjectHidden'));
  
    
    echo Chtml::ajaxSubmitButton( $btnText, bu('/qna/new'), $ajaxProperties, $htmlProperties);
    echo CHtml::endForm(); ?>
    
</div>