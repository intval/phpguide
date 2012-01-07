<?php $time = new DateTime($answer->time); ?>

<div class="answer">
	<span class="userinfo" >
            <? $this->widget('GravatarWidget', array('email' => $answer->author->email, 'size' => 20, 'htmlOptions' => array('class'=>"avatar"))); ?>
	    ענה
	    <?=e($answer->author->login)?>
	   ב-
	   <span  style="font-size:10px"> <?= Helpers::date2heb($time, 1) ?> </span>
	   <a id="answer_<?=$answer->aid?>" href="<?= Yii::app()->request->requestUri . "#answer_" . $answer->aid?>">#</a>
	</span>
	
	<p>
	<?=$answer->html_text?>
	</p>
</div>