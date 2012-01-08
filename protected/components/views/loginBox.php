<?php $user = & Yii::app()->user; ?>

<div class="user_info">
        
  
        <?php $this->widget('GravatarWidget', array('size' => 50, 'email' => $user->email)); ?>
        
    <p class="right">
    
            שלום
          
            <span dir="ltr" id="user_name"><?=e($user->login)?></span> <br/>

    <?php

    
    if(!$user->is_registered && null === Yii::app()->session['provider'])
    {
        $this->widget('ext.eauth.EAuthWidget', array('action' => 'login/externalLogin'));
    }
    elseif(!$user->is_registered && null !== Yii::app()->session['provider'])
    {
    	echo CHtml::link('בחר לעצצך שם אחר', array('login/index'));
    }
    else 
    {
        ?>
            

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
   
