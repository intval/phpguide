<div class="answer" id="answer<?=$answer->aid?>">
	<div>	
		<span class="userinfo" >
	            <? $this->widget('GravatarWidget', array('email' => $answer->author->email, 'size' => 20, 'htmlOptions' => array('class'=>"avatar"))); ?>
		    ענה
		    <?=e($answer->author->login)?>
		   ב-
		   <span  style="font-size:10px"> <?= Helpers::date2heb($answer->time, false) ?> </span>
		   <a id="answer_<?=$answer->aid?>" href="<?= Yii::app()->request->requestUri . "#answer_" . $answer->aid?>">#</a>
		</span>
		
		<?php if(Yii::app()->user->is_admin || $answer->authorid === Yii::app()->user->id) { ?><a class="qna-answer-edit" title='ערוך תשובה'></a><?php } ?>
		<?php if(Yii::app()->user->is_admin) { ?><a class="qna-answer-delete" title='מחק תשובה'></a><?php } ?>
		<div class="clear"></div>
	</div>
	
	<p>
	<?=$answer->html_text?>
	</p>
</div>