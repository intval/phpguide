<?php
foreach ($services as $name => $service) 
	echo  CHtml::link('', array($action, 'service' => $name), array('class' => 'sign_in_with_'.$name)), "\r\n";
