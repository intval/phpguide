<?php $this->renderPartial('newQuestionForm') ?>









<?php  $this->renderPartial('homeQnaList', array('qnas' => &$qnas)) ?>

<div class="paginator" id="paginator4" dir="ltr"></div>

<?php 
Yii::app()->clientScript->registerScript('paginator', "pag4 = new Paginator('paginator4', ".$pagination['total_pages'] . " /*total*/, 15, " . $pagination['current_page'] ." /*current*/, 'qna/?page=');", CClientScript::POS_READY);
?>
