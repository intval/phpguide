<div id="qnaCommentForm">
        

    <?php 
    
    echo  CHtml::beginForm('', 'post', array('onsubmit' => 'return false;'))  ;
    
    $fieldid = ($model->aid ? 'editmessage' . $model->aid :   'message');
    
    ?>
    
    
    
    <div class='controls_holder'>
	<a title="bold text" href="javascript:bbstyle('b', '<?=$fieldid?>');" class="abold"><b>B</b></a>
	<a title="italic text" href="javascript:bbstyle('i', '<?=$fieldid?>')" class="aitalic"><i>I</i></a>
	<a title="underlined" href="javascript:bbstyle('u', '<?=$fieldid?>')" class="aunderline"><u>U</u></a>
	<a title="block of code" href="javascript:bbstyle('php', '<?=$fieldid?>')" class="acode">PHP</a>
	<a title="image" href="javascript:bbstyle('img', '<?=$fieldid?>')" class="aimage">img</a>
	<a title="link to url" href="javascript:bbstyle('url', '<?=$fieldid?>')" class="alink">A</a>
	<div class="clear" ></div>
    </div>
    
    <?php 
    echo Chtml::activeHiddenField($model, 'qid'),
    CHtml::activeTextArea($model,'bb_text', array('id' => $fieldid)); 

    if($model -> aid)
    {
    	$ajaxProperties = array('success' => 'qna.editSuccess', 'beforeSend' => 'qna.editSent');
    	$htmlProperties = array('class' => 'btn btnEditAnswer');
    	$btnText = 'עריכת תשובה';
    	
    	echo CHtml::activeHiddenField($model, 'authorid'), CHtml::activeHiddenField($model, 'aid');
    }
    else 
    {
	    $ajaxProperties = array('success'=>'qna.displayAnswer','beforeSend' => 'qna.answerSent');
	    $htmlProperties = array('class' => 'btn primary large', 'id' => 'btnNewAnswer');
	    $btnText = "ענה לשאלה";
    }
    
    echo Chtml::ajaxSubmitButton( $btnText, bu('/Qna/answer'), $ajaxProperties, $htmlProperties);
    echo CHtml::endForm(); ?>
    
</div>