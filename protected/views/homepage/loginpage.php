
<div class="row">
<div class="offset1">

<?= CHtml::beginForm('','post',array('id'=>"loginForm", 'dir'=>"rtl", 'onsubmit' => 'return false;')) ?>



<legend><h2>
    הזדהות
</h2></legend>

    
    <div class="alert-message warning" id="loginResult">
    שם משתמש או סיסמה לא נכונים
</div>
    
<div class="clearfix">
    <label for="loginname">
	שם משתמש:
    </label>
    <div class="input">
	<?= CHtml::textField('login',null, array('tabindex'=>"2", 'id'=>"loginname"));?>
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
	array('class' => 'btn', 'id' => 'loginSubmitBtn')
	)?>

    
    
<?=CHtml::endForm()?>

    <script type="text/javascript">
	redirect_to = '<?=bu(e($return_location))?>';
    </script>

</div>
</div>
















<div class="row">
<div class="offset1">

<?= CHtml::beginForm('','post',array('id'=>"regForm", 'dir'=>"rtl", 'onsubmit' => 'return false;')) ?>



<legend><h2>
הרשמה
</h2></legend>

    
    <div class="alert-message warning" id="regResult"></div>
    
<div class="clearfix">
    <label for="regname">
	שם משתמש:
    </label>
    <div class="input">
	<?= CHtml::textField('user',null, array('tabindex'=>"5", 'id'=>"regname"));?>
    </div>
</div>

<div class="clearfix">
    <label for="regpass">
	סיסמה:
    </label>
    <div class="input">
	<?= CHtml::textField('pass',null,array('tabindex'=>"6", 'id'=>"regpass"));?>
    </div>
</div>

<div class="clearfix">
    <label for="regmail">
	אימייל:
    </label>
    <div class="input">
	<?= CHtml::textField('email',null,array('tabindex'=>"7", 'id'=>"regmail"));?>
    </div>
</div>
    
<?=CHtml::ajaxSubmitButton(
	'כניסה'
	, bu('login/Register'), 
	array('beforeSend' => 'login.regSubmitted', 'success' => 'login.regSuccess'), 
	array('class' => 'btn', 'id' => 'regSubmitBtn')
	)?>

    
    
<?=CHtml::endForm()?>


</div>
</div>