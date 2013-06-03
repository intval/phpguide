
      	<br/>
        <h1>שלום <?=e($name)?></h1><br/>
		עברת בהצלחה את שלב ההזדהות באמצעות חשבון ה-
        <?= $provider ?>
        שלך. 
        <br/>
כדי שתוכל לקחת חלק פעיל באתר, אנא בחר לעצמך שם משתמש והזן את כתובת האימייל שלך.
        
        <br/><br/>
        



<div id="reg_form_holder">

<?= CHtml::beginForm('','post',array('id'=>"regForm", 'dir'=>"rtl", 'onsubmit' => 'return false;')) ?>


    
    <div class="alert alert-warning" id="regResult" style='display:none;'></div>
    
<div class="clearfix">
    <label for="regname">
	שם משתמש:
    </label>
    <div class="input">
	<?= CHtml::textField('reguser',null, array('tabindex'=>"5", 'id'=>"regname",'title' => 'בשם הזה יקירו אתכם המשתמשים האחרים'));?>
    </div>
</div>


<div class="clearfix">
    <label for="regmail">
	אימייל:
    </label>
    <div class="input">
        <input type="email" name="regemail" tabindex="7" id="regmail" title="אנחנו לא שולחים מיילים, פרסומות, ספאם או ויאגרה בלי שתבקש. אנחנו רק מציגים את האוואטר שלך מ-gravatar.com ומאפשרים לך לשחזר סיסמה. בעצם אתה יכול לראות בעצמך כל מה שאנחנו עושים, הקוד של האתר פתוח." />
    </div>
</div>
    
<?=CHtml::ajaxSubmitButton(
	'סיים הרשמה'
	, bu('login/Register'), 
	array('beforeSend' => 'login.regSubmitted', 'success' => 'login.regSuccess'), 
	array('class' => 'btn', 'id' => 'regSubmitBtn', 'tabindex'=>'8')
	)?>

    
    
<?=CHtml::endForm()?>

<script type="text/javascript">redirect_after_login_to = '<?=bu(e($return_location))?>';</script>
</div>


<br/><br/>
	&larr; &nbsp; <a href="#" onclick="jQuery('#existingUserAfterExternalAuth').show(); return false;">כבר יש לי שם משתמש באתר. אני רוצה לחבר את חשבון ה- <?= $provider ?> אליו</a>
<br/><br/>	
	
<div id='existingUserAfterExternalAuth' style='display:none' >
	
	<?= CHtml::beginForm('','post',array('id'=>"loginForm", 'dir'=>"rtl", 'onsubmit' => 'return false;')) ?>
     
	    <div class="alert alert-warning" id="loginResult" style='display:none'>
	    שם משתמש או סיסמה לא נכונים
	</div>
	    
	<div class="clearfix">
	    <label for="loginname">
		שם משתמש:
	    </label>
	    <div class="input">
		<?= CHtml::textField('user',null, array('tabindex'=>"2", 'id'=>"loginname"));?>
	    </div>
	</div>
	
	<div class="clearfix">
	    <label for="loginpass">
		סיסמה:
	    </label>
	    <div class="input">
		<?= CHtml::passwordField('pass',null,array('tabindex'=>"3", 'id'=>"loginpass"));?>
	    </div>
	</div>
	
	<?=CHtml::ajaxSubmitButton(
		'כניסה'
		, bu('login/Login'), 
		array('beforeSend' => 'login.submitted', 'success' => 'login.xhrSuccess'), 
		array('class' => 'btn', 'id' => 'loginSubmitBtn', 'tabindex' => '4')
		)?>
	
	    
	    
	<?=CHtml::endForm()?>
	</div>