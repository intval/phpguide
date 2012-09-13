<div class="form">
<?php $form=$this->beginWidget('CActiveForm'); 
?>
 
			    <?php echo $form->errorSummary($model); ?>
			 
			    <div class="row">
			        <?php echo $form->label($model,'קצת על עצמך'); ?>
			        <?php echo $form->TextArea($model,'about',array('rows'=> 10)) ?>
			    </div>
			 
			    <div class="row">
			        <?php echo $form->label($model,'עיר'); ?>
			        <?php echo $form->textField($model,'city',array('value'=> $user->city)) ?>
			    </div>
			 
			 	<div class="row">
			        <?php echo $form->label($model,'אתר'); ?>
			        <?php echo $form->textField($model,'site',array('value'=> $user->site)) ?>
			    </div>
	
			 
			    <div class="row submit">
			        <?php echo CHtml::submitButton('עדכן'); ?>
			    </div>
			 
			<?php $this->endWidget(); ?>
			</div><!-- form -->