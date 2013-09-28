
<div id="reg_form_holder">

	
	
	<br/>
	<h1>הזדהות</h1>
	<br/>
	    
	ההזדהות באתר אפשרית על ידי חשבון הפייסבוק או חשבון הגימייל שלך.
	<br/>
	לחץ על אחד הכפתורים הללו על מנת להזדהות
	
	<br/><br/>
	<a href='<?= Yii::app() ->createUrl('loginExternal/login', array('service' => 'facebook')); ?>' class='sign_in_with_facebook_long'></a>
	<br/>
	<a href='<?= Yii::app() ->createUrl('loginExternal/login', array('service' => 'google')); ?>' class='sign_in_with_google_long'></a>

	<br/>
	<b>
        <span style="text-decoration: underline;">
            פרטיות המידע
        </span>
    </b>
	<br/>
	המידע היחידי שהאתר מקבל מפייסבוק הוא האידי שלך בפייסבוק ושמך. שום דבר מזה לא מוצג באף מקום באתר ומשמש רק אותך בביקורך הבא באתר. שום מידע פרטי אחר, כגון כתובת, חברים, תמונות, שם הכלב וכו' אינו ידוע לנו.
	

	<br/><br/>

	
</div>

<div>
    <h3>
        כבר יש לי משתמש וסיסמה
    </h3>

    <div class="alert alert-warning" id="loginResult" style="margin-bottom:10px; display:none;">
        -
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

        <a href="<?= Yii::app() ->createUrl('PwRecovery/recover'); ?>">שכחתי סיסמה</a>
    </div>

    <?=CHtml::endForm()?>
</div>



<div>
    <br/><br/><br/>
    <h3>הרשמה</h3>           <br/>

    ניתן לבצע הרשמה גם ללא גוגל ופייסבוק.
    <br/>
    בחר לעצמך שם וסיסמה והקלד את האמייל שלך, שאליו נשלך תזכורת לסיסמה אם תבקש.
    <br/><br/>

    <div class='alert hidden' id="regManualResult" ></div>

    <?= CHtml::beginForm('', 'post', ['id' => 'regManualForm']) ?>

    <input type='text' name='reguser' placeholder="שם משתמש"/>
    שם משתמש
    <br/>
    <input type='text' name='regpass' placeholder="סיסמה" />
    סיסמה
    <br/>
    <input type='text' name='regmail' placeholder="אימייל"/>
    אימייל
    <br/>

    <input type='button' id='regFormSubmitBtn' class='btn' value='להירשם'
            onclick='login.regManualSubmit()'/>

    <?= CHtml::endForm(); ?>


</div>



	
	<script type="text/javascript">redirect_after_login_to = '<?=bu(e($return_location))?>';</script>
    
	<!-- / Login popup -->