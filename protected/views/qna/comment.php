<div class="answer" id="answer<?=$answer->aid?>">
	<div>	
		<span class="userinfo" >
	            <? $this->widget('GravatarWidget', array('email' => $answer->author->email, 'size' => 20, 'htmlOptions' => array('class'=>"avatar"))); ?>
		    ׳¢׳ ׳”
		    <?=e($answer->author->login)?>
		   ׳‘-
		   <span  style="font-size:10px"> <?= $answer->time->date2heb( false) ?> </span>
		   <a id="answer_<?=$answer->aid?>" href="<?= Yii::app()->request->requestUri . "#answer_" . $answer->aid?>">#</a>
		</span>
		
		<?php if((!Yii::app()->user->isguest &&  Yii::app()->user->is_admin) || $answer->authorid === Yii::app()->user->id) { ?><a class="qna-answer-edit" title='׳¢׳¨׳•׳� ׳×׳©׳•׳‘׳”'></a><?php } ?>
		<?php if(!Yii::app()->user->isguest && Yii::app()->user->is_admin) { ?><a class="qna-answer-delete" title='׳�׳—׳§ ׳×׳©׳•׳‘׳”'></a><?php } ?>

		<div class="clear"></div>
		<? if($is_qna_answered == 0):?>
		<a href="#" class="btn btn-success btn-mini correct_ans" style="float:left;" ref="<?= $answer->aid; ?>";>זו התשובה</a>
		<? endif; ?>
		<? if($answer->is_correct == 1): ?>
		<span class="badge badge-success">התשובה הנכונה</span>
		<? endif; ?>
	</div>
	
	<p>
	
	<?=$answer->html_text?>
	</p>
</div>

