    <?php
    $user = & Yii::app()->user;
    $email = $user->isGuest ? '' : $user->email;
    ?>

<div class="user_info">
        
  
        <?php $this->widget('GravatarWidget', array('size' => 50, 'email' => $email)); ?>
        
    <p class="right">
    

    <?php

    
    if($user ->isGuest)
    {
        $this->widget('ext.eauth.EAuthWidget', array('action' => 'login/externalLogin'));
    }
    else 
    {
        ?>
            
            שלום
          
            <span dir="ltr" id="user_name"><?=e($user->login)?></span> <br/>

            ברוך הבא ללמוד PHP
	    <br/><br/>
            <div class="logout-link" title="התנתק">
                <a href="<?= Yii::app()->createUrl('Login/logout')?>" title="התנתק">x</a>
            </div>

        
        <?php
    }
    ?>     
        </p>
        <div class="clear"></div>
    </div>
   
