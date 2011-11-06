
<?php $this->renderPartial('//layouts/header'); ?>


<div class="container">
<div class="row">
    
    <section id="sidebar" class="span4">
        <?php $this->renderPartial('//layouts/sidebar'); ?>
    </section>


    <section id="content" class="span12">
        <?=$content; ?> 
    </section> <!-- /content -->

</div>
</div>


    
<?php $this->renderPartial('//layouts/footer'); ?>