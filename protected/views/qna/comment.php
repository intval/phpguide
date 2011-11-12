<?php $time = new DateTime($answer->time); ?>

<div class="answer">
	<span class="userinfo" >
	    <img src="<?=e($answer->author->avatar)?>" height="20" width="20" class="avatar"/>
	    ענה
	    <a href="/forum/index.php?action=profile;u=<?=$answer->author->id_member?>"><?=e($answer->author->member_name)?></a>
	   ב-
	   <span  style="font-size:10px"> <?= Helpers::date2heb($time, 1) ?> </span>
	   <a id="answer_<?=$answer->aid?>" href="./#abc">#</a>
	</span>
	
	<p>
	<?=$answer->html_text?>
	</p>
</div>