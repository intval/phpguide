<? $user = & Yii::app()->user; ?>

<? if($user->is_registered): ?>

<section id="userinfo" class='registered'>
	<div class="ava">
		<a href="#" class="avatar"><?php $this->widget('GravatarWidget', array('size' => 48, 'email' => $user->email)); ?></a>
		<div style="float:right">
			
			<div>
				<a href="<?=bu('users/').urldecode($user->login)?>" class="username"><span dir="ltr" id="user_name"><?=e($user->login)?></span></a> 
				<span dir="rtl"></span> 
				<span class='userpoints' title="רייטינג">(<?=$user->points?>)</span>
			</div>
			<nav>
				<a href="#" class='messages' title="הודעות פרטיות"></a>
				<a href="#" class='favorites' title="מועדפים"></a>
				<a href="#" class='preferences' title="הגדרות"></a>
			</nav>
		</div>
		<div class='clear'></div>
	</div>
	<div class="action">
		<a href="<?= bu('Add')?>">הוסף פוסט</a>
	</div>
</section>



<? else: ?>

<section id="userinfo" class='unregistered'>
	<div class="ava">
		<a href="#" class="avatar"><img src='<?=bu('static/images/auth_girl.png')?>' alt='loginbox' /></a>
		<div style='float:right'>
			<span dir="ltr" id="user_name"><?=e($user->login)?></span></a> 
			<span dir="rtl"></span> 
			<span class='userpoints' title='רייטינג'>(<?=$user->points?>)</span>
			<br/>
			<a href='<?= Yii::app() ->createUrl('login/index'); ?>'>הזדהות והרשמה</a>
		</div>
		<div class='clear'></div>
	</div>
	
	<div class="action">
		<a class="sign_in_with_google" href="<?= Yii::app() ->createUrl('login/externalLogin', array('service' => 'google')); ?>"></a>
		<a class="sign_in_with_facebook" href="<?= Yii::app() ->createUrl('login/externalLogin', array('service' => 'facebook')); ?>"></a>
	</div>
	
	
	
	
</section>

<? endif; ?>