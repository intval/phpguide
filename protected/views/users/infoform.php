<div class="form">
<?php $form=$this->beginWidget('CActiveForm',  array(
		'action' => CController::createUrl('users/'.urlencode($user->login).'/update' ),
        'enableClientValidation' => true)); ?>
 
    <?php 
    	echo $form->errorSummary($user); 
    	echo Chtml::activeHiddenField($user, 'id');
    ?>
 
    <div class="row">
        <?php echo $form->label($user,'קצת על עצמך'); ?>
        <?php echo $form->TextArea($user,'about',array('rows'=> 10)) ?>
    </div>
 
    <div class="row">
        <?php echo $form->label($user,'עיר'); ?>
        <?php echo $form->textField($user,'city',array('value'=> $user->city)) ?>
    </div>
 
 	<div class="row">
        <?php echo $form->label($user,'אתר'); ?>
        <?php echo $form->textField($user,'site',array('value'=> $user->site)) ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($user,'מייל'); ?>
        <?php echo $form->textField($user,'email',array('value'=> $user->email)) ?>
    </div>

 
    <div class="row submit">
        <?php echo CHtml::submitButton('עדכן'); ?>
    </div>
 
<?php $this->endWidget(); ?>
</div><!-- form -->