<?php
/*** @var $user \User */
$user = & Yii::app()->user;
?>

<script type='text/javascript'>
var isguest = <?=Yii::app()->user->isguest ? 'true' : 'false' ?>;
</script>

<?php if(!$user->isguest): ?>

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
				<a href="login/logout/" class='logout' title="התנתקות"></a>
			</nav>
		</div>
		<div class='clear'></div>
	</div>
	<div class="action">
		<a href="<?= bu('Add')?>">הוסף כתבה לאתר</a>
	</div>
</section>



<?php else: ?>

<section id="userinfo" class='unregistered'>

	<div class="ava">
		<a href="#" class="avatar"><img src='<?= PHPGController::getAssetsBaseStatic() ?>/images/auth_girl.png' alt='loginbox' /></a>
		<div style='float:right'>
			שלום
            <span dir="ltr" id="user_name">אורח</span>
			<br/>
			<a href='<?= Yii::app() ->createUrl('login/index'); ?>'>הזדהות והרשמה</a>
		</div>
		<div class='clear'></div>
	</div>
	
	<div class="action">
		<a class="sign_in_with_google" href="<?= Yii::app() ->createUrl('loginExternal/login', array('service' => 'google')); ?>"></a>
		<a class="sign_in_with_facebook" href="<?= Yii::app() ->createUrl('loginExternal/login', array('service' => 'facebook')); ?>"></a>
	</div>
	
	
	<!--  auth popup  -->
	<div id='only_auth_users_allowed_popup'>
		<div class="auth_window_background" id='only_auth_window_background' style="cursor: pointer; display: block; opacity: 0.4;"></div>
		<div class="auth_window" style="z-index: 9999; top: 160px; left: 50%; position: fixed; display: block">
			
			<div class="head-wind">
				<span>רק משתמשים רשומים יכולים</span>
				<a class="close_auth_window"  onclick='return false' href="#" id="close_auth_window"></a>
			</div>
			<div class="enter-block">
			
				בוא נכיר,
				<br/>
				<br/>
				
				כדי שתוכל 
				<span id='unauth_operation_description'>123</span>
				 לחץ בבקשה על אחד הכפתורים הבאים כדי להזדהות באמצעות פייסבוק או גוגל.
								
				
				<br/><br/>
					<a href='<?= Yii::app() ->createUrl('loginExternal/login', array('service' => 'facebook', 'backto' => Yii::app()->request->url)); ?>' class='sign_in_with_facebook_long'></a>
					<br/>
					<a href='<?= Yii::app() ->createUrl('loginExternal/login', array('service' => 'google', 'backto' => Yii::app()->request->url)); ?>' class='sign_in_with_google_long'></a>
				<br/>
				לאחר הלחיצה תועבר לעמוד בחירת שם משתמש לאתר ולאחר מכן תגיע חזרה לכאן.
				
				<span id='unauth_operation_form_preserving_info'> 
				 כל הנתונים שהזנת בטפסים יחקו במקומם כשתחזור.
				</span>
				
				<br/><br/>
				
				<p style='font-size:80%'>
				חשוב לציין שאנחנו לא מקבלים שום מידע פרטי עליך מפייסבוק או גוגל חוץ משמך הפרטי, אנחנו לא שולחים לך ספאם עם וויאגרה למייל ולא מפרסים את שמך הפרטי בשום מקום באתר ללא אישורך.
				</p>
				
			</div>
		</div>
	</div>

	<!-- / auth popup -->
	
	
</section>

<?php endif;
