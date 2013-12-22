<div class="qnaCommentForm">
        

    <?php
        $fieldid = ($model->aid ? 'editmessage' . $model->aid :   'message');
        echo  CHtml::beginForm('', 'post', ['onsubmit' => 'return false;']);
    ?>
    
    
    
    <div class='controls_holder'>
	<a title="bold text" href="javascript:$('#<?=$fieldid?>').bbcode('b');" class="abold"><b>B</b></a>
	<a title="italic text" href="javascript:$('#<?=$fieldid?>').bbcode('i')" class="aitalic"><i>I</i></a>
	<a title="underlined" href="javascript:$('#<?=$fieldid?>').bbcode('u')" class="aunderline"><u>U</u></a>
	<a title="block of code" href="javascript:$('#<?=$fieldid?>').bbcode('php')" class="acode">PHP</a>
	<a title="image" href="javascript:$('#<?=$fieldid?>').bbcode('img')" class="aimage">img</a>
	<a title="link to url" href="javascript:$('#<?=$fieldid?>').bbcode('url')" class="alink">A</a>
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

        ?>
        <label>
            <?= CHtml::checkBox('qnasubscribe', true); ?>
            לשלוח לי עדכון במייל כשיש תשובות חדשות באשכול
        </label>
        <?php
    }
    
    echo Chtml::ajaxSubmitButton( $btnText, bu('qna/answer'), $ajaxProperties, $htmlProperties);
    echo CHtml::endForm(); ?>
    
</div>