<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'newPostForm',
	'enableAjaxValidation'=>false,
        'action' => CController::createUrl('Add/save' ),
        'enableClientValidation' => true
)); ?>

<div class='addform'>

    <div class="errors">
        <?php

            foreach( $article->getErrors() as $errors)
            {
               // $errors is an array of errors for concrete field if it has more then one error whithin it
               echo nl2br(e(implode("\r\n",$errors))) , '<br/>';
            }

            foreach( $plain->getErrors() as $error)
            {
               echo nl2br(e(implode("\r\n",$errors))) , '<br/>';
            }

        ?>
    </div>


	<h1 class="title">הוספת פוסט</h1>
           
            <br />
            כותרת:
            <br/>
            <input type="hidden" name="edit" value="<?=$editing_id?>" />
            
            <?= $form->textField($article,'title', array('class' => 'name', 'placeholder' => 'כותרת', 'tabindex' => '1')); ?><br />
            <br/>
            
            תמונה (75x75) <i>לא חובה</i> :
            <br/> 
            <?= $form->textField($article, 'image', array('tabindex'=>"3", 'dir'=>"ltr", 'class'=>"name", 'style'=>"width:350px",
                   'title'=>"קישור לתמונה בגודל 75 על 75 שתופיע ליד הכתבה בעמוד הראשי")); ?>
            <br/>
            
            
            <br/>
            תיאור בשני משפטים שיופיע בעמוד הראשי ובתחילת הפוסט: 
            <br/>
            <?= $form->textArea($plain, "plain_description", array('rows'=>"2", 'tabindex'=>"2", 'style'=>"width:600px")); ?>
            
           

            <?php if ($article->url !== null && $is_editor_admin): ?>
            <br/><br/><label>
                <input type="checkbox" name="change_permalink"/>
                לשנות קישור קיים?</label><br/>             
            <?php endif; ?>
            <div class="buttons" dir="rtl" >
                <a href="javascript:$('#data').bbcode('b');" title="bold text"  class="bold-text">B</a>
                <a href="javascript:$('#data').bbcode('i')" title="italic text"  class="italic-text">I</a>
                <a href="javascript:$('#data').bbcode('u')" title="underlined"  class="underline-text">U</a>
                <a href="javascript:$('#data').bbcode('s')" title="striked out"  class="through-text">S</a>
                <a href="javascript:$('#data').bbcode('h1')" title="header1"  class="h1-text">H1</a>
                <a href="javascript:$('#data').bbcode('h2')" title="header2"  class="h2-text">H2</a>
                <a href="javascript:$('#data').bbcode('h3')" title="header3"  class="h3-text">H3</a>
                <a href="javascript:$('#data').bbcode('php')" title="block of code"  class="php-text">PHP</a>
                <a href="javascript:$('#data').bbcode('left')" title="div dir-ltr"  class="ltr-text">L.</a>
                <a href="javascript:$('#data').bbcode('ltr')" title="span dir-ltr"  class="ltr-text">LTR</a>
                <a href="javascript:$('#data').bbcode('img')" title="image"  class="img-text">IMG</a>
                <a href="javascript:$('#data').bbcode('youtube')" title="youtube vid"  class="emb-text">EMB</a>
                <a href="javascript:$('#data').bbcode('url')" title="link to url"  class="a-text">A</a>
                <a href="javascript:anylinkmenu.nullfunc()" class="a-color" rel='colorsMenu[click]'>color</a>
                <div class="anylinkmenu"></div>
            </div>
            <?= $form->textArea($plain, 'plain_content', array('class'=>"text", 'id'=>'data', 'tabindex'=>"5")) ?>


          <br/><br/>
          <b>קטגוריה</b><br/><br/>

          <?= $form->dropDownList($article, 'categories', $allCategories,
                  array('style'=>"width:350px;" , 'multiple' => 'true', 'class'=>"chzn-select", 'id'=>"test_me", 'name'=>"Article[categories]" ,'tabindex'=>"6"))
                    ?>

    

          <br/><br/><br/><br/>



            <b>מנועי חיפוש: </b><br/><br/>
            <div>
            מילות מפתח: 
            <?= $form->textField($article, 'keywords', array('class' => 'name', 'tabindex' => '7', 'title' => 'meta keywords למנועי החיפוש')) ?> 
            </div>
            <div class="clear"></div>
            <div>
            תיאור כתבה: 
            <?= $form->textField($article, 'description', array('class' => 'name', 'tabindex' => '8', 'title' => 'meta description למנועי החיפוש')) ?>
            </div>
            <div class="clear"></div>
            
            <div id="newpost_error_text"/>
				<span style="color:red">
				            יש למלא את כל השדות
				</span>

				<p>במקרים מסוימים המאמרים עוברים שינויים קוסמטיים והגהה לשונית אחרי הפרסום. לא להיבהל. :)</p>
            </div>
            <input type="button" name="submit"  id="submit"  class="submit" value="Submit"  />
            <input type="button" name="preview" id="preview" class="submit" value="Preview" />
            <input id="hiddenSubmit" type="submit" style="display: none" />
</div>
<?php $this->endWidget(); ?>
