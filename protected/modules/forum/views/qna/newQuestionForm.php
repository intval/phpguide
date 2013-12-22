<?php
/** @var $allCategories QnaCategory[] */
/** @var $model QnaQuestion*/
/** @var $selectedCategory integer */

$model = new QnaQuestion();
$model->categoryid = $selectedCategory;
?>

<div class="new_question_form" >
    <div style="margin:0 auto;width:90%;">
        <h4 >
            אשכול חדש:
        </h4>
        <?php echo 
            CHtml::beginForm('', 'post', ['id' => 'newQuestionForm', 'name' => 'newQuestionForm']) ,
            CHtml::activeTextField($model,'subject', array('id' => "forum_question_subject")) ,
            CHtml::activeTextArea($model, 'bb_text', array('id' => 'forum_question_text', 'placeholder' => 'פרט את שאלתך'));
        ?>

		<div class='clear' style='margin-top:16px'></div>        
        <div id="forum_question_controls" >

            <div>
            <?
                $data = CHtml::listData($allCategories, 'catid', 'cat_name');
                echo CHtml::activeDropDownList($model, 'categoryid', $data, ['data-sisyphus' => 'exclude']);
            ?>
            </div>

            <div class="right">
                <?= Chtml::ajaxSubmitButton("שלח", bu('/qna/new'),
                        array('success'=>'new_question_submitted_callback', 'beforeSend' => 'disable_new_question_form'),
                		array('class' => 'btn info')
                        ) ?>
            </div>
            
            
            <div class="left">
                <a title="bold text" href="javascript:$('#forum_question_text').bbcode('b');"><b>B</b></a>
                <a title="italic text" href="javascript:$('#forum_question_text').bbcode('i')"><i>I</i></a>
                <a title="underlined" href="javascript:$('#forum_question_text').bbcode('u')"><u>U</u></a>
                <a title="block of code" href="javascript:$('#forum_question_text').bbcode('code')">code</a>
                <a title="link to url" href="javascript:$('#forum_question_text').bbcode('url')">A</a>
            </div>
            <div class="clear"></div>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>