<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'newPostForm',
	'enableAjaxValidation'=>false,
        'action' => CController::createUrl('Add/save' . $editting_id ),
        'enableClientValidation' => true
)); ?>

<div class='addform'>
	<h1 class="title">כותרת</h1>
	
            
            <?= $form->textField($model,'title', array('class' => 'name', 'placeholder' => 'כותרת', 'tabindex' => '1')); ?><br />
            
            <div>
                <img class="right" src="<?=e($author->avatar)?>" width="45" height="45"/>
                <p class="right" style="margin-right:20px">
                    <?=e($author->member_name)?> <br/>
                    <? if($author->full_name): echo e($author->full_name); else: ?>
                    שם מלא:
                    <?= $form->textField($author, 'full_name', array('tabindex'=>"2" ,'id'=>"full_name" , 'title'=>"שם פרטי ושם משפחה (לא חובה, אך מכובד יותר)")) ?>
                    
                    <? endif; ?>
                </p>
                <div class="clear" ></div>
            </div>
            
            <br/><br/>
            תיאור בעמוד הראשי:  (בשני משפטים)
            <br/>
            <?= $form->textArea($plain, "plain_description", array('rows'=>"2", 'tabindex'=>"3", 'style'=>"width:100%")); ?>
            
            
            <br/>
            תמונה(75x75):
            <?= $form->textField($model, 'image', array('tabindex'=>"4", 'dir'=>"ltr", 'class'=>"name", 'style'=>"width:350px",
                   'title'=>"קישור לתמונה בגודל 75 על 75 שתופיע ליד הכתבה בעמוד הראשי")); ?>
            <br/>
            
            <? if ($model->url !== null && $author->is_blog_admin): ?>
            <br/><br/><label>
                <input type="checkbox" name="change_permalink"/>
                לשנות קישור קיים?</label><br/>             
            <? endif; ?>
            <div class="buttons" dir="rtl" >
                <a href="javascript:bbstyle('b');" title="bold text"  class="bold-text">B</a>
                <a href="javascript:bbstyle('i')" title="italic text"  class="italic-text">I</a>
                <a href="javascript:bbstyle('u')" title="underlined"  class="underline-text">U</a>
                <a href="javascript:bbstyle('s')" title="striked out"  class="through-text">S</a>
                <a href="javascript:bbstyle('h1')" title="header1"  class="h1-text">H1</a>
                <a href="javascript:bbstyle('h2')" title="header2"  class="h2-text">H2</a>
                <a href="javascript:bbstyle('h3')" title="header3"  class="h3-text">H3</a>
                <a href="javascript:bbstyle('php')" title="block of code"  class="php-text">PHP</a>
                <a href="javascript:bbstyle('left')" title="div dir-ltr"  class="ltr-text">L.</a>
                <a href="javascript:bbstyle('ltr')" title="span dir-ltr"  class="ltr-text">LTR</a>
                <a href="javascript:bbstyle('img')" title="image"  class="img-text">IMG</a>
                <a href="javascript:bbstyle('youtube')" title="youtube vid"  class="emb-text">EMB</a>
                <a href="javascript:bbstyle('url')" title="link to url"  class="a-text">A</a>
                <a href="javascript:anylinkmenu.nullfunc()" class="a-color" rel='colorsMenu[click]'>color</a>
                <div class="anylinkmenu"></div>
            </div>
            <?= $form->textArea($plain, 'plain_content', array('class'=>"text", 'id'=>'data', 'tabindex'=>"5")) ?>
            

            <b>מנועי חיפוש:</b><br/><br/>
            מילות מפתח: 
            <?= $form->textField($model, 'keywords', array('class' => 'name', 'tabindex' => '6')) ?> <br/>
            תיאור כתבה: 
            <?= $form->textField($model, 'description', array('class' => 'name', 'tabindex' => '7')) ?><br/>

            <div id="newpost_error_text"/>
            יש למלא את כל השדות
            </div>
            <input type="button" name="submit"  id="submit"  class="submit" value="Submit"  />
            <input type="button" name="preview" id="preview" class="submit" value="Preview" />
			<input id="hiddenSubmit" type="submit" style="display: none" />
</div>
<?php $this->endWidget(); ?>
