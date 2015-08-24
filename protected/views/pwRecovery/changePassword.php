<h2>שינוי סיסמה</h2>
<?php
echo CHtml::beginForm('', 'post', array('onsubmit' => 'return false;'));
?>

<fieldset>
	<div class="clearfix">
		<label>	סיסמה חדשה:</label>
		<input type='text' id='newpass' name='pass' placeholder='סיסמה חדשה' />
	</div>

</fieldset>

<?php 
echo CHtml::ajaxSubmitButton('שנה סיסמה', $this->createUrl('PwRecovery/ChangePw') , array('id' => 'changepwBtn', 'beforeSend' => 'login.passwordChangeSubmitted', 'success' => 'login.passwordChangeSuccess'), array('class' => 'btn primary'));
echo CHtml::endForm();
