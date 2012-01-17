<?php $this->renderPartial('//layouts/header'); ?>

<?php
    $flashes = Yii::app()->user->getFlashes();
    if(count($flashes) > 0)
    {
        $this->addScripts('sticky');
        Yii::app()->clientScript->registerScript('flashes', '$("#flashes div").sticky()', CClientScript::POS_LOAD);
        
        ?>

        <div id="flashes">
            <?php foreach($flashes as $flash): ?>
                <div><?=e($flash)?></div>
            <?php endforeach; ?>
        </div>

        <?php
    }
?>


<div class="container">
<div class="row">
    
    <section id="sidebar" class="span4_5" >
        <?php $this->renderPartial('//layouts/sidebar'); ?>
    </section>


    <section id="content" class="span11 offset0_5">
        <?=$content; ?> 
    </section> <!-- /content -->



</div>

</div>


    
<?php $this->renderPartial('//layouts/footer'); ?>