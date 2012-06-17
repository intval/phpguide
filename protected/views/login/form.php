
<div id="reg_form_holder">

	
	
	<br/>
	<h1>הזדהות</h1>
	<br/>
	    
	ההזדהות באתר אפשרית על ידי חשבון הפייסבוק או חשבון הגימייל שלך.
	<br/>
	לחץ על אחד הכפתורים הללו על מנת להזדהות
	
	<br/><br/>
	<a href='<?= Yii::app() ->createUrl('login/externalLogin', array('service' => 'facebook')); ?>' class='sign_in_with_facebook_long'></a>
	<br/>
	<a href='<?= Yii::app() ->createUrl('login/externalLogin', array('service' => 'google')); ?>' class='sign_in_with_google_long'></a>

	<br/>
	<b><u>פרטיות המידע</u></b>
	<br/>
	המידע היחידי שהאתר מקבל מפייסבוק הוא האידי שלך בפייסבוק ושמך. שום דבר מזה לא מוצג באף מקום באתר ומשמש רק אותך בביקורך הבא באתר. שום מידע פרטי אחר, כגון כתובת, חברים, תמונות, שם הכלב וכו' אינו ידוע לנו.
	

	<br/><br/>
	&larr; &nbsp; <a href="#" onclick="jQuery('#login_popup').show(); return false;">כבר יש לי שם משתמש וסיסמה לאתר</a>
	<br/>
	&larr; &nbsp; <a href="#">אין לי פייסבוק וגימייל ובכלל אני חי במאדים</a>
	
</div>



	<!--  Login popup  -->
	<div id='login_popup'>
		<div class="auth_window_background" id='auth_window_background' style="cursor: pointer; display: block; opacity: 0.4;"></div>
		<div class="auth_window" style="z-index: 9999; top: 160px; left: 50%; position: fixed; display: block">
			<div class="head-wind">
				<span>הזדהות</span>
				<a class="close_auth_window"  onclick='return false' href="#" id="close_auth_window"></a>
			</div>
			<div class="enter-block">
				
				    <div class="alert alert-warning" id="loginResult" style="margin-bottom:-10px; display:none;">
					    שם משתמש או סיסמה לא נכונים
					</div>

				<?= CHtml::beginForm('','post',array('id'=>"authPop", 'dir'=>"rtl", 'onsubmit' => 'return false;')) ?>

					<div class="col ">
						<label>שם משתמש:</label>
						<?= CHtml::textField('user',null, array('tabindex'=>"2", 'id'=>"loginname", 'class'=>"txt-field"));?>
					</div>
					<div class="col ">
						<label>סיסמה:</label>
						<?= CHtml::passwordField('pass',null,array('tabindex'=>"3", 'id'=>"loginpass", 'class'=>"txt-field", 'type' => 'password'));?>
						
						<div class="save_me">
						<label><input type="checkbox" checked='checked'> &nbsp; לזכור אותי</label>
						</div>
						<?=CHtml::ajaxSubmitButton(
							'כניסה'
							, bu('login/Login'), 
							array('beforeSend' => 'login.submitted', 'success' => 'login.xhrSuccess'), 
							array('class' => 'submit', 'id' => 'loginSubmitBtn', 'tabindex' => '4')
							)?>
							
						<a href="<?= Yii::app() ->createUrl('login/recover'); ?>">שכחתי סיסמה</a>
					</div>
					
				<?=CHtml::endForm()?>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">redirect_after_login_to = '<?=bu(e($return_location))?>';</script>
    
	<!-- / Login popup -->