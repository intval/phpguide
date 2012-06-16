
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



<div >


    
    <section id="content" >
        <?=$content; ?> 
    </section> <!-- /content -->
    
    <section id="sidebar">
        <?php $this->renderPartial('//layouts/sidebar'); ?>
    </section>






</div>




    
<?php $this->renderPartial('//layouts/footer'); ?>