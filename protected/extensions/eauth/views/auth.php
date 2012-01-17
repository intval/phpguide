
  <?php
	foreach ($services as $name => $service) 
        {
            
            echo  CHtml::link('', array($action, 'service' => $name), array('class' => 'auth-bar auth-bar-'.$name)), "\r\n";
	}
        
  ?>
     <a href="<?= Yii::app() ->createUrl('login/index'); ?>" class="auth-bar auth-bar-password"></a>
      
