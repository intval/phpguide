
<div class="row" >
<div class="offset1" id="reg_form_holder">

<?= CHtml::beginForm('','post',array('id'=>"regForm", 'dir'=>"rtl", 'onsubmit' => 'return false;')) ?>



<legend><h4>
עדיין לא בחרתי שם משתמש
</h4></legend>

    
    <div class="alert-message warning" id="regResult"></div>
    
<div class="clearfix">
    <label for="regname">
	שם משתמש:
    </label>
    <div class="input">
	<?= CHtml::textField('reguser',null, array('tabindex'=>"5", 'id'=>"regname",'title' => 'בשם הזה יקירו אתכם המשתמשים האחרים'));?>
    </div>
</div>

<div class="clearfix">
    <label for="regpass">
	סיסמה:
    </label>
    <div class="input">
	<?= CHtml::passwordField('regpass',null,array('tabindex'=>"6", 'id'=>"regpass"));?>
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
	'כניסה'
	, bu('login/Register'), 
	array('beforeSend' => 'login.regSubmitted', 'success' => 'login.regSuccess'), 
	array('class' => 'btn', 'id' => 'regSubmitBtn', 'tabindex'=>'8')
	)?>

    
    
<?=CHtml::endForm()?>


</div>
</div>



<script type="text/javascript">
  $(document).ready(function(){
      
      $('#loginname').focus();
      
      var tooltip_options = {

        // place tooltip on the right edge
        position: "center left",

        // a little tweaking of the position
        offset: [-2, 10],

        // use the built-in fadeIn/fadeOut effect
        effect: "fade",

        // custom opacity setting
        opacity: 0.7

    };
    
  // select all desired input fields and attach tooltips to them
    $("#reg_form_holder input[type=email]").tooltip(tooltip_options);    
    $("#reg_form_holder input[type=text]").tooltip(tooltip_options);    
  });
</script>






<div class="row" style="margin-top:50px;">
    <div class="offset1">  
        
        <?= CHtml::beginForm('','post',array('id'=>"loginForm", 'dir'=>"rtl", 'onsubmit' => 'return false;')) ?>

        
<legend><h4>
    יש לי משתמש רשום
</h4></legend>

    
        
    <div class="alert-message warning" id="loginResult">
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

    <script type="text/javascript">
	redirect_to = '<?=bu(e($return_location))?>';
    </script>

        
    </div>
</div>
